@php
    $config = null;
    $bookingDetails = null;
    $bookingDate = null;
    $bookingTime = null;
    
    if ($configId) {
        $config = \App\Models\Configuration::where('config_id', $configId)->first();
        if ($config) {
            $bookingDetails = $config->booking_details ?? null;
            if ($bookingDetails && isset($bookingDetails['start'])) {
                $startDate = \Carbon\Carbon::parse($bookingDetails['start']);
                $bookingDate = $startDate->format('d/m/Y');
                $bookingTime = $startDate->format('H:i');
            }
        }
    }
@endphp

<div
    class="w-full bg-center bg-opacity-30 bg-repeat flex flex-col h-screen"
    style="background-image: url('{{ asset('images/bg.svg') }}')"
>
    @include('livewire.partials.header', ['currentStep' => 6])

    <main class="flex w-full md:flex-row flex-col p-4 gap-4 justify-center flex-1">
        <div class="flex flex-1 gap-10 flex-col items-center justify-center w-full max-w-3xl">
            <div class="p-8 bg-white border border-gray-200 rounded-3xl shadow-[0_18px_40px_rgba(15,23,42,0.08)] w-full">
                <div class="w-full flex flex-col gap-6">
                    <div class="text-center">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">
                            Prenotazione avvenuta con successo!
                        </h1>
                        <p class="text-gray-600">
                            Grazie per aver effettuato la prenotazione. Ti abbiamo inviato una mail con i dettagli della prenotazione.
                        </p>
                    </div>

                    {{-- Riepilogo prenotazione --}}
                    @if($bookingDate && $bookingTime)
                        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Riepilogo prenotazione</h2>
                            
                            <div class="flex flex-col md:flex-row gap-6 md:gap-8">
                                <div class="flex items-start gap-3 flex-1">
                                    <svg class="icon-md mt-0.5 text-gray-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                    <div class="flex-1">
                                        <div class="text-xs font-semibold uppercase text-gray-500 mb-1">Data</div>
                                        <div class="text-base font-semibold text-gray-900">{{ $bookingDate }}</div>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3 flex-1">
                                    <svg class="icon-md mt-0.5 text-gray-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <div class="flex-1">
                                        <div class="text-xs font-semibold uppercase text-gray-500 mb-1">Ora</div>
                                        <div class="text-base font-semibold text-gray-900">{{ $bookingTime }}</div>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3 flex-1">
                                    <svg class="icon-md mt-0.5 text-gray-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>
                                    <div class="flex-1">
                                        <div class="text-xs font-semibold uppercase text-gray-500 mb-1">Importo totale</div>
                                        <div class="text-2xl font-bold text-gray-900">€ {{ $this->calculateFinalTotal() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Informazioni contatto --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
                        <div class="flex items-start gap-3 mb-3">
                            <svg class="icon-lg text-blue-600 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Sarai ricontattato da L&C Traslochi</h3>
                                <p class="text-sm text-gray-700 leading-relaxed mb-3">
                                    Verrai ricontattato ai contatti che hai indicato (<strong>{{ $email }}</strong> e <strong>{{ $phone }}</strong>) per:
                                </p>
                                <ul class="text-sm text-gray-700 space-y-2 ml-4 list-disc">
                                    <li>Accertamenti finali sulla configurazione del trasloco</li>
                                    <li>Coordinamento finale pre-trasloco</li>
                                    <li>Conferma definitiva dell'offerta commerciale</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">
                        <button
                            type="button"
                            wire:click="restartConfiguration"
                            class="btn btn-primary w-full sm:w-auto"
                        >
                            Ricomincia una nuova configurazione
                            <svg class="icon-sm ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
