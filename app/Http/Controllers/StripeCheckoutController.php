<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeCheckoutController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createCheckoutSession(Request $request)
    {
        $request->validate([
            'config_id' => 'required|string',
        ]);

        $config = Configuration::where('config_id', $request->config_id)->first();

        if (! $config) {
            return redirect()->route('home')->with('error', 'Configurazione non trovata');
        }

        // Se la configurazione ha già un pagamento completato, non permettere un nuovo checkout
        if ($config->payment_status === 'paid') {
            return redirect()->route('home')->with('error', 'Questa prenotazione è già stata pagata');
        }

        // Calcola il totale finale
        $totalAmount = $this->calculateFinalTotal($config);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Trasloco',
                        'description' => "Trasloco da {$config->luogo_carico} a {$config->luogo_scarico}",
                    ],
                    'unit_amount' => $totalAmount * 100, // Stripe usa centesimi
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success').'?session_id={CHECKOUT_SESSION_ID}&config_id='.$config->config_id,
            'cancel_url' => route('stripe.cancel').'?config_id='.$config->config_id,
            'customer_email' => $config->email,
            'metadata' => [
                'config_id' => $config->config_id,
            ],
        ]);

        // Salva la session ID nella configurazione
        $config->update([
            'stripe_session_id' => $session->id,
            'payment_status' => 'pending',
        ]);

        // Crea un record di pagamento in stato pending (se non esiste già)
        Payment::firstOrCreate(
            ['stripe_session_id' => $session->id],
            [
                'configuration_id' => $config->id,
                'amount' => $totalAmount,
                'currency' => 'eur',
                'payment_method' => 'stripe',
                'status' => 'pending',
                'metadata' => [
                    'customer_email' => $config->email,
                    'customer_name' => $config->nome,
                ],
            ]
        );

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
            'config_id' => 'required|string',
        ]);

        try {
            $session = Session::retrieve($request->session_id);

            if ($session->payment_status === 'paid') {
                $config = Configuration::where('config_id', $request->config_id)->first();

                if ($config) {
                    $this->completeBooking($config, $session);
                }

                return view('stripe.success', [
                    'config' => $config,
                    'amount' => $session->amount_total / 100,
                ]);
            }

            return redirect()->route('home')->with('error', 'Pagamento non completato');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Errore durante la verifica del pagamento');
        }
    }

    public function cancel(Request $request)
    {
        $configId = $request->get('config_id');

        return redirect()->route('home', ['config' => $configId])->with('error', 'Pagamento annullato');
    }

    public function webhook(Request $request)
    {
        $endpointSecret = config('services.stripe.webhook_secret');

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            if ($session->payment_status === 'paid') {
                $config = Configuration::where('stripe_session_id', $session->id)->first();

                if ($config && $config->payment_status !== 'paid') {
                    $this->completeBooking($config, $session);
                }
            }
        }

        return response()->json(['received' => true]);
    }

    private function calculateFinalTotal(Configuration $config): int
    {
        $finalTotal = $config->total_price;

        // Transport type multiplier
        $multipliers = [
            'solo_trasporto' => 1,
            'trasporto_parziale' => 1.7,
            'trasporto_totale' => 2.0,
        ];
        $finalTotal *= ($multipliers[$config->tipo_trasporto] ?? 1);

        // Floor difference
        if ($config->piano_scarico > $config->piano_carico) {
            $diff = $config->piano_scarico - $config->piano_carico;
            $finalTotal += $diff * ($finalTotal * 0.02);
        }

        // ZTL
        if ($config->ztl) {
            $finalTotal += 20;
        }

        // Imballaggio
        if ($config->imballaggio && $config->tipo_trasporto === 'solo_trasporto') {
            $finalTotal += $finalTotal * 0.03;
        }

        // Transport cost
        $finalTotal += $config->transport_cost;

        // Distance discount
        $km = $config->distanza_totale;
        if ($km > 100 && $km < 250) {
            $finalTotal -= $finalTotal * 0.25;
        } elseif ($km > 250 && $km < 500) {
            $finalTotal -= $finalTotal * 0.10;
        } elseif ($km > 500) {
            $finalTotal -= $finalTotal * 0.05;
        }

        return $finalTotal > 0 ? round($finalTotal) : 0;
    }

    private function completeBooking(Configuration $config, Session $session): void
    {
        // booking_details è già un array grazie al cast nel model
        $bookingDetails = $config->booking_details ?? [];

        // Aggiorna o crea il record di pagamento
        $payment = Payment::where('stripe_session_id', $session->id)->first();

        if ($payment) {
            $payment->update([
                'stripe_payment_intent_id' => $session->payment_intent ?? null,
                'status' => 'paid',
                'paid_at' => now(),
                'metadata' => array_merge($payment->metadata ?? [], [
                    'stripe_customer_id' => $session->customer ?? null,
                    'payment_intent_id' => $session->payment_intent ?? null,
                ]),
            ]);
        } else {
            // Se il pagamento non esiste (webhook chiamato prima del success), crealo
            $payment = Payment::create([
                'configuration_id' => $config->id,
                'stripe_session_id' => $session->id,
                'stripe_payment_intent_id' => $session->payment_intent ?? null,
                'amount' => $session->amount_total / 100,
                'currency' => $session->currency ?? 'eur',
                'payment_method' => 'stripe',
                'status' => 'paid',
                'paid_at' => now(),
                'metadata' => [
                    'stripe_customer_id' => $session->customer ?? null,
                    'payment_intent_id' => $session->payment_intent ?? null,
                ],
            ]);
        }

        $config->update([
            'payment_status' => 'paid',
            'stripe_session_id' => $session->id,
            'current_step' => 7,
            'status' => 'completed',
            'booking_details' => array_merge($bookingDetails, [
                'payment_method' => 'stripe',
                'payment_id' => $payment->id,
                'payment_date' => now()->toIso8601String(),
            ]),
        ]);
    }
}
