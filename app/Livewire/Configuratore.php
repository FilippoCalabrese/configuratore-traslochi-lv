<?php

namespace App\Livewire;

use App\Models\Configuration;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Configuratore extends Component
{
    public int $step = 1;

    public ?string $configId = null;

    // Step 1 fields
    public string $firstName = '';

    public string $email = '';

    public string $phone = '';

    public bool $contactConsent = false;

    // Step 2 fields
    public string $luogoCarico = '';

    public string $luogoScarico = '';

    public string $tipoTrasporto = 'solo_trasporto';

    public int $pianoCarico = 0;

    public int $pianoScarico = 0;

    public bool $imballaggio = false;

    public bool $ztl = false;

    public bool $ascensore = false;

    public float $distanzaTotale = 0;

    public float $tempoTotale = 0;

    // Step 3 fields (ex Step 4 - Furniture Selection)
    public string $currentRoom = '';

    public array $roomNames = [
        'Soggiorno',
        'Cucina',
        'Camera',
        'Bagno',
        'Giardino e Garage',
        'Palestra e Altro',
    ];

    public array $selections = [];

    public array $allRoomSelections = [];

    // Step 5 fields
    public array $furnitureConfig = [];

    public float $totalPrice = 0;

    public float $totalCaricoTime = 0;

    public float $totalScaricoTime = 0;

    public float $transportCost = 0;

    public int $finalTotal = 0;

    public float $distanceDiscount = 0;

    public float $transportTypeMultiplier = 0;

    public float $floorDifferenceCost = 0;

    public float $ztlCost = 0;

    public float $packagingCost = 0;

    // Step 6 fields
    public ?string $selectedDate = null;

    public array $timeSlots = [];

    public ?string $selectedTimeSlot = null;

    public string $selectedPayment = '';

    public bool $privacyConsent = false;

    public string $bookingMessage = '';

    public bool $bookingLoader = false;

    public int $calendarMonth;

    public int $calendarYear;

    // Loading
    public bool $isLoading = false;

    protected $listeners = [
        'placeSelected',
    ];

    public function mount()
    {
        $this->calendarMonth = (int) date('n');
        $this->calendarYear = (int) date('Y');

        // Check session for existing config
        $configId = session('configID');
        if ($configId) {
            $config = Configuration::where('config_id', $configId)->first();
            if ($config) {
                $this->configId = $configId;
                $this->step = $config->current_step;
                $this->loadConfigData($config);
            }
        }
    }

    private function loadConfigData(Configuration $config)
    {
        $this->firstName = $config->nome ?? '';
        $this->email = $config->email ?? '';
        $this->phone = $config->phone ?? '';
        $this->contactConsent = (bool) ($config->contact_consent ?? false);
        $this->luogoCarico = $config->luogo_carico ?? '';
        $this->luogoScarico = $config->luogo_scarico ?? '';
        $this->tipoTrasporto = $config->tipo_trasporto ?? 'solo_trasporto';
        $this->pianoCarico = $config->piano_carico ?? 0;
        $this->pianoScarico = $config->piano_scarico ?? 0;
        $this->imballaggio = (bool) $config->imballaggio;
        $this->ztl = (bool) $config->ztl;
        $this->ascensore = (bool) $config->ascensore;
        $this->distanzaTotale = (float) ($config->distanza_totale ?? 0);
        $this->tempoTotale = (float) ($config->tempo_totale ?? 0);
        $this->transportCost = (float) ($config->transport_cost ?? 0);

        // Initialize currentRoom with first available room if not set
        if (empty($this->currentRoom) && ! empty($this->roomNames)) {
            $this->currentRoom = $this->roomNames[0];
        }

        if ($config->furniture_config) {
            $this->furnitureConfig = $config->furniture_config;
            $this->allRoomSelections = $config->furniture_config;
            $this->calculateTotals();
        } else {
            $this->totalPrice = (float) ($config->total_price ?? 0);
            $this->totalCaricoTime = (float) ($config->total_carico_time ?? 0);
            $this->totalScaricoTime = (float) ($config->total_scarico_time ?? 0);
            $this->finalTotal = $this->calculateFinalTotal();
        }

        // Se siamo allo step 3, carica le selezioni per la stanza corrente
        if ($this->step === 3 && ! empty($this->currentRoom)) {
            $this->loadRoomSelections();
        }
    }

    // ========== STEP 1: User Info ==========

    public function submitStep1()
    {
        $this->validate([
            'firstName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'contactConsent' => 'accepted',
        ], [
            'contactConsent.accepted' => 'Devi accettare di essere ricontattato per procedere.',
        ]);

        $this->isLoading = true;
        $configId = 'config-'.Str::random(12);

        $config = Configuration::create([
            'config_id' => $configId,
            'nome' => $this->firstName,
            'email' => $this->email,
            'phone' => $this->phone,
            'contact_consent' => $this->contactConsent,
            'current_step' => 2,
            'status' => 'in_progress',
        ]);

        $this->configId = $configId;
        session(['configID' => $configId]);
        $this->step = 2;
        $this->isLoading = false;
    }

    // ========== STEP 2: Transport Info ==========

    public function placeSelected($field, $address)
    {
        if ($field === 'luogo_carico') {
            $this->luogoCarico = $address;
        } elseif ($field === 'luogo_scarico') {
            $this->luogoScarico = $address;
        }
    }

    public function distanceCalculated($data)
    {
        $this->distanzaTotale = $data['distanza_totale'] ?? 0;
        $this->tempoTotale = $data['tempo_totale'] ?? 0;
        $this->transportCost = round($this->distanzaTotale * 1.5, 0);

        $config = Configuration::where('config_id', $this->configId)->first();
        if ($config) {
            $config->update([
                'luogo_carico' => $this->luogoCarico,
                'luogo_scarico' => $this->luogoScarico,
                'distanza_totale' => $this->distanzaTotale,
                'tempo_totale' => $this->tempoTotale,
                'tipo_trasporto' => $this->tipoTrasporto,
                'imballaggio' => $this->imballaggio,
                'ztl' => $this->ztl,
                'ascensore' => $this->ascensore,
                'piano_carico' => $this->pianoCarico,
                'piano_scarico' => $this->pianoScarico,
                'transport_cost' => $this->transportCost,
                'current_step' => 3,
            ]);
        }

        // Initialize currentRoom if not set
        if (empty($this->currentRoom) && ! empty($this->roomNames)) {
            $this->currentRoom = $this->roomNames[0];
        }

        // Carica le selezioni per la stanza corrente
        $this->loadRoomSelections();

        $this->step = 3;
        $this->isLoading = false;

        // Recalculate final total if we already have furniture selected
        if ($this->totalPrice > 0) {
            $this->finalTotal = $this->calculateFinalTotal();
        }
    }

    public function submitStep2()
    {
        $this->validate([
            'luogoCarico' => 'required|string',
            'luogoScarico' => 'required|string',
        ]);

        $this->isLoading = true;
        // Dispatch event to JS to calculate route
        $this->dispatch('calculateRoute', [
            'luogoCarico' => $this->luogoCarico,
            'luogoScarico' => $this->luogoScarico,
            'companyAddress' => env('COMPANY_ADDRESS', 'Via della Pace, 2, 55015 Turchetto LU, Italy'),
        ]);
    }

    // ========== STEP 3: Furniture Selection ==========

    public function changeRoom($room)
    {
        // Save current room selections
        $this->saveCurrentRoomSelections();
        $this->currentRoom = $room;
        $this->loadRoomSelections();
    }

    private function saveCurrentRoomSelections()
    {
        if ($this->currentRoom && ! empty($this->selections)) {
            // Filtra le selezioni vuote (senza nome) prima di salvare
            $filteredSelections = array_filter($this->selections, function ($selection) {
                $firstLevel = $selection['levels'][0] ?? [];
                return ! empty($firstLevel['name'] ?? '');
            });
            $this->allRoomSelections[$this->currentRoom] = array_values($filteredSelections);
        }
    }

    private function loadRoomSelections()
    {
        $this->selections = $this->allRoomSelections[$this->currentRoom] ?? [];
        // Assicurati che ci sia sempre almeno una selezione vuota
        $this->ensureEmptySelection();
    }

    private function ensureEmptySelection()
    {
        // Controlla se c'è almeno una selezione vuota (senza nome) in prima posizione
        $firstSelection = $this->selections[0] ?? null;
        $firstLevel = $firstSelection['levels'][0] ?? [];
        $hasEmptySelectionAtTop = ! empty($firstSelection) && empty($firstLevel['name']);

        // Se non c'è una selezione vuota in prima posizione, aggiungine una all'inizio
        if (! $hasEmptySelectionAtTop) {
            array_unshift($this->selections, [
                'levels' => [['name' => '', 'quantity' => 1]],
            ]);
        }
    }

    public function addSelection()
    {
        array_unshift($this->selections, [
            'levels' => [['name' => '', 'quantity' => 1]],
        ]);
    }

    public function removeSelection($index)
    {
        unset($this->selections[$index]);
        $this->selections = array_values($this->selections);
        // Assicurati che ci sia sempre almeno una selezione vuota dopo la rimozione
        $this->ensureEmptySelection();
    }

    public function updateSelection($index, $level, $name)
    {
        $furnishData = $this->getFurnishData();
        $roomData = $furnishData[$this->currentRoom] ?? [];

        if ($level === 0) {
            // Search across all rooms
            $found = null;
            $foundRoom = null;
            foreach ($furnishData as $rName => $items) {
                foreach ($items as $item) {
                    if ($item['name'] === $name) {
                        $found = $item;
                        $foundRoom = $rName;
                        break 2;
                    }
                }
            }

            if ($found) {
                // Controlla se la selezione corrente era vuota
                $wasEmpty = empty($this->selections[$index]['levels'][0]['name'] ?? '');

                $quantity = $this->selections[$index]['levels'][0]['quantity'] ?? 1;
                $this->selections[$index]['levels'] = [
                    array_merge($found, ['quantity' => $quantity, 'source_room' => $foundRoom]),
                ];

                // Se la selezione era vuota, aggiungi una nuova selezione vuota in cima
                if ($wasEmpty) {
                    $this->ensureEmptySelection();
                }
            }
        } else {
            // Sub-level selection
            $parentLevel = $this->selections[$index]['levels'][$level - 1] ?? null;
            if ($parentLevel && isset($parentLevel['properties'])) {
                foreach ($parentLevel['properties'] as $prop) {
                    if ($prop['name'] === $name) {
                        $quantity = $this->selections[$index]['levels'][0]['quantity'] ?? 1;
                        // Trim levels after current
                        $this->selections[$index]['levels'] = array_slice($this->selections[$index]['levels'], 0, $level);
                        $this->selections[$index]['levels'][$level] = array_merge($prop, ['quantity' => $quantity]);
                        break;
                    }
                }
            }
        }
    }

    public function incrementQuantity($index)
    {
        if (isset($this->selections[$index]['levels'][0])) {
            $newQty = ($this->selections[$index]['levels'][0]['quantity'] ?? 1) + 1;
            foreach ($this->selections[$index]['levels'] as &$level) {
                $level['quantity'] = $newQty;
            }
        }
    }

    public function decrementQuantity($index)
    {
        if (isset($this->selections[$index]['levels'][0])) {
            $newQty = max(1, ($this->selections[$index]['levels'][0]['quantity'] ?? 1) - 1);
            foreach ($this->selections[$index]['levels'] as &$level) {
                $level['quantity'] = $newQty;
            }
        }
    }

    public function submitStep3()
    {
        $this->saveCurrentRoomSelections();

        // Validate that required properties are selected for each item
        foreach ($this->allRoomSelections as $room => $selections) {
            foreach ($selections as $selection) {
                if (! $this->selectionHasRequiredProperties($selection)) {
                    $this->dispatch('showAlert', [
                        'message' => 'Per continuare, completa i dettagli di tutti i mobili (es. materiale e dimensioni del tavolo).',
                    ]);

                    return;
                }
            }
        }

        // Build furniture config from allRoomSelections
        $furnitureConfig = [];
        foreach ($this->allRoomSelections as $room => $selections) {
            $items = [];
            foreach ($selections as $sel) {
                $consolidated = $this->consolidateSelection($sel['levels'] ?? []);
                if ($consolidated && ($consolidated['quantity'] ?? 0) > 0) {
                    $items[] = $consolidated;
                }
            }
            if (! empty($items)) {
                $furnitureConfig[$room] = $items;
            }
        }

        $this->furnitureConfig = $furnitureConfig;
        $this->calculateTotals();

        $config = Configuration::where('config_id', $this->configId)->first();
        if ($config) {
            $config->update([
                'furniture_config' => $furnitureConfig,
                'current_step' => 4,
            ]);
        }

        $this->step = 4;
    }

    private function selectionHasRequiredProperties(array $selection): bool
    {
        $levels = $selection['levels'] ?? [];
        $baseLevel = $levels[0] ?? null;

        if (! $baseLevel) {
            return false;
        }

        $minProperties = (int) ($baseLevel['minProperties'] ?? 0);

        if ($minProperties <= 0) {
            return true;
        }

        $selectedLevels = array_filter($levels, static function ($level) {
            return ! empty($level['name'] ?? null);
        });

        $selectedPropertiesCount = max(count($selectedLevels) - 1, 0);

        return $selectedPropertiesCount >= $minProperties;
    }

    private function consolidateSelection(array $levels, int $currentLevel = 0): ?array
    {
        if (! isset($levels[$currentLevel]) || empty($levels[$currentLevel]['name'])) {
            return null;
        }

        $result = [
            'name' => $levels[$currentLevel]['name'],
            'quantity' => $levels[$currentLevel]['quantity'] ?? 0,
            'price' => $levels[$currentLevel]['price'] ?? 0,
            'm3' => $levels[$currentLevel]['m3'] ?? 0,
            'tempo_carico' => $levels[$currentLevel]['tempo_carico'] ?? 0,
            'tempo_scarico' => $levels[$currentLevel]['tempo_scarico'] ?? 0,
        ];

        if (! empty($levels[0]['image'] ?? null)) {
            $result['image'] = $levels[0]['image'];
        }

        if (isset($levels[$currentLevel + 1]) && ! empty($levels[$currentLevel + 1]['name'])) {
            $sub = $this->consolidateSelection($levels, $currentLevel + 1);
            if ($sub && ($sub['quantity'] ?? 0) > 0) {
                $result['selectedProperty'] = $sub;
            }
        }

        return $result;
    }

    // ========== STEP 5: Summary ==========

    public function calculateTotals()
    {
        $basePrice = 0;
        $caricoTime = 0;
        $scaricoTime = 0;

        foreach ($this->furnitureConfig as $items) {
            foreach ($items as $item) {
                $this->addTotalsForItem($item, 1, $basePrice, $caricoTime, $scaricoTime);
            }
        }

        $this->totalPrice = $basePrice;
        $this->totalCaricoTime = round($caricoTime);
        $this->totalScaricoTime = round($scaricoTime);
        $this->transportCost = round($this->distanzaTotale * 1.5);
        $this->finalTotal = $this->calculateFinalTotal();
    }

    private function addTotalsForItem($item, $parentQuantity, &$basePrice, &$caricoTime, &$scaricoTime)
    {
        $price = $item['price'] ?? 0;
        $quantity = $item['quantity'] ?? 0;

        if ($price > 0 && $quantity > 0) {
            $itemQuantity = $quantity * $parentQuantity;
            $basePrice += $price * $itemQuantity;
            $caricoTime += ($item['tempo_carico'] ?? 0) * $itemQuantity;
            $scaricoTime += ($item['tempo_scarico'] ?? 0) * $itemQuantity;
        }

        if (isset($item['selectedProperty'])) {
            $this->addTotalsForItem($item['selectedProperty'], ($item['quantity'] ?? 1) * $parentQuantity, $basePrice, $caricoTime, $scaricoTime);
        }
    }

    public function calculateFinalTotal(): int
    {
        $finalTotal = $this->totalPrice;

        // Reset all cost components
        $this->transportTypeMultiplier = 0;
        $this->floorDifferenceCost = 0;
        $this->ztlCost = 0;
        $this->packagingCost = 0;
        $this->distanceDiscount = 0;

        // Transport type multiplier
        $multipliers = [
            'solo_trasporto' => 1,
            'trasporto_parziale' => 1.7,
            'trasporto_totale' => 2.0,
        ];
        $multiplier = $multipliers[$this->tipoTrasporto] ?? 1;
        if ($multiplier > 1) {
            $this->transportTypeMultiplier = $finalTotal * ($multiplier - 1);
        }
        $finalTotal *= $multiplier;

        // Floor difference
        if ($this->pianoScarico > $this->pianoCarico) {
            $diff = $this->pianoScarico - $this->pianoCarico;
            $this->floorDifferenceCost = $diff * ($finalTotal * 0.02);
            $finalTotal += $this->floorDifferenceCost;
        }

        // ZTL
        if ($this->ztl) {
            $this->ztlCost = 20;
            $finalTotal += $this->ztlCost;
        }

        // Imballaggio
        if ($this->imballaggio && $this->tipoTrasporto === 'solo_trasporto') {
            $this->packagingCost = $finalTotal * 0.03;
            $finalTotal += $this->packagingCost;
        }

        // Transport cost
        $finalTotal += $this->transportCost;

        // Distance discount
        $km = $this->distanzaTotale;
        if ($km > 100 && $km < 250) {
            $this->distanceDiscount = $finalTotal * 0.25;
        } elseif ($km > 250 && $km < 500) {
            $this->distanceDiscount = $finalTotal * 0.10;
        } elseif ($km > 500) {
            $this->distanceDiscount = $finalTotal * 0.05;
        }

        $finalTotal -= $this->distanceDiscount;

        return $finalTotal > 0 ? round($finalTotal) : 0;
    }

    public function updateTipoTrasporto($value)
    {
        $this->tipoTrasporto = $value;
        $config = Configuration::where('config_id', $this->configId)->first();
        if ($config) {
            $config->update(['tipo_trasporto' => $value]);
        }
        $this->finalTotal = $this->calculateFinalTotal();
    }

    public function updateImballaggio($value)
    {
        $this->imballaggio = (bool) $value;
        $config = Configuration::where('config_id', $this->configId)->first();
        if ($config) {
            $config->update(['imballaggio' => $this->imballaggio]);
        }
        $this->finalTotal = $this->calculateFinalTotal();
    }

    public function updateFurnitureQuantity($room, $itemIndex, $newQuantity)
    {
        if (isset($this->furnitureConfig[$room][$itemIndex])) {
            $this->updateItemQuantityRecursive($this->furnitureConfig[$room][$itemIndex], max(1, $newQuantity));
            $this->calculateTotals();
        }
    }

    private function updateItemQuantityRecursive(&$item, $quantity)
    {
        $item['quantity'] = $quantity;
        // Le proprietà selezionate (es. materiale, dimensione) devono ereditare
        // la quantità solo tramite il moltiplicatore del livello padre,
        // non avere anche una propria quantità moltiplicata ricorsivamente.
        // Altrimenti si ottengono quantità al quadrato/cubo (es. 13 → 13×13),
        // con totali completamente sballati.
        if (isset($item['selectedProperty'])) {
            $this->updateItemQuantityRecursive($item['selectedProperty'], 1);
        }
    }

    public function removeFurnitureItem($room, $itemIndex)
    {
        if (isset($this->furnitureConfig[$room])) {
            unset($this->furnitureConfig[$room][$itemIndex]);
            $this->furnitureConfig[$room] = array_values($this->furnitureConfig[$room]);
            if (empty($this->furnitureConfig[$room])) {
                unset($this->furnitureConfig[$room]);
            }
            $this->calculateTotals();
        }
    }

    public function submitStep4()
    {
        $this->isLoading = true;

        $config = Configuration::where('config_id', $this->configId)->first();
        if ($config) {
            $config->update([
                'furniture_config' => $this->furnitureConfig,
                'total_price' => $this->totalPrice,
                'total_carico_time' => $this->totalCaricoTime,
                'total_scarico_time' => $this->totalScaricoTime,
                'transport_cost' => $this->transportCost,
                'current_step' => 5,
            ]);
        }

        $this->step = 5;
        $this->isLoading = false;
    }

    // ========== STEP 5: Calendar & Booking ==========

    public function changeCalendarMonth($direction)
    {
        $this->calendarMonth += $direction;
        if ($this->calendarMonth > 12) {
            $this->calendarMonth = 1;
            $this->calendarYear++;
        } elseif ($this->calendarMonth < 1) {
            $this->calendarMonth = 12;
            $this->calendarYear--;
        }
        $this->selectedDate = null;
        $this->timeSlots = [];
        $this->selectedTimeSlot = null;
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->selectedTimeSlot = null;
        $this->bookingMessage = '';
        $this->fetchAvailableTimeSlots();
    }

    private function fetchAvailableTimeSlots()
    {
        // Generate time slots from 7:00 to 19:00
        // In production, this would check Google Calendar
        $this->timeSlots = [];
        for ($hour = 7; $hour <= 19; $hour++) {
            $this->timeSlots[] = $hour.':00';
        }
    }

    public function selectTimeSlot($slot)
    {
        $this->selectedTimeSlot = $slot;
    }

    public function selectPayment($method)
    {
        $this->selectedPayment = $method;
    }

    public function togglePrivacyConsent()
    {
        $this->privacyConsent = ! $this->privacyConsent;
    }

    public function handleBooking()
    {
        if (! $this->selectedDate) {
            $this->bookingMessage = 'Seleziona un giorno';

            return;
        }

        if (! $this->selectedTimeSlot) {
            $this->bookingMessage = 'Seleziona un orario';

            return;
        }

        if (empty($this->selectedPayment)) {
            $this->bookingMessage = 'Seleziona un metodo di pagamento';

            return;
        }

        if (! $this->privacyConsent) {
            $this->bookingMessage = 'Devi accettare la privacy policy';

            return;
        }

        $this->bookingLoader = true;

        try {
            $config = Configuration::where('config_id', $this->configId)->first();
            if (! $config) {
                throw new \Exception('Configurazione non trovata');
            }

            // Parse date and time
            $dateParts = explode('-', $this->selectedDate);
            $startHour = (int) explode(':', $this->selectedTimeSlot)[0];

            $startDate = \Carbon\Carbon::create($dateParts[0], $dateParts[1], $dateParts[2], $startHour, 0, 0, 'Europe/Rome');

            // Calculate total duration
            $totalDuration = $this->tempoTotale;
            if ($this->tipoTrasporto === 'trasporto_parziale') {
                $totalDuration += ($this->totalCaricoTime + $this->totalScaricoTime) / 2;
            } elseif ($this->tipoTrasporto === 'trasporto_totale') {
                $totalDuration += $this->totalCaricoTime + $this->totalScaricoTime;
            }

            $endDate = $startDate->copy()->addMinutes(round($totalDuration));

            $bookingDetails = [
                'start' => $startDate->toIso8601String(),
                'end' => $endDate->toIso8601String(),
                'summary' => "Trasloco del cliente Email: {$this->email} Telefono: {$this->phone} da {$this->luogoCarico} a {$this->luogoScarico} totale: {$this->calculateFinalTotal()}€",
            ];

            // Se il pagamento è con carta, salva i dettagli e reindirizza a Stripe
            if ($this->selectedPayment === 'carta') {
                $config->update([
                    'booking_details' => $bookingDetails,
                    'payment_status' => 'pending',
                ]);

                $this->bookingLoader = false;

                // Reindirizza a Stripe checkout tramite form POST
                $this->dispatch('redirect-to-stripe', ['config_id' => $this->configId]);

                return;
            }

            // Se il pagamento è alla consegna, completa direttamente e crea record di pagamento
            $config->update([
                'booking_details' => $bookingDetails,
                'current_step' => 6,
                'status' => 'completed',
                'payment_status' => 'pending',
            ]);

            // Crea un record di pagamento per il pagamento alla consegna
            Payment::create([
                'configuration_id' => $config->id,
                'amount' => $this->calculateFinalTotal(),
                'currency' => 'eur',
                'payment_method' => 'cash_on_delivery',
                'status' => 'pending',
                'metadata' => [
                    'customer_email' => $this->email,
                    'customer_name' => $this->firstName,
                    'payment_type' => 'consegna',
                ],
            ]);

            $this->step = 6;
        } catch (\Exception $e) {
            $this->bookingMessage = $e->getMessage();
        } finally {
            $this->bookingLoader = false;
        }
    }

    // ========== NAVIGATION ==========

    public function goToStep($step)
    {
        $this->step = $step;
        $config = Configuration::where('config_id', $this->configId)->first();
        if ($config) {
            $config->update(['current_step' => $step]);
        }
    }

    public function restartConfiguration(): void
    {
        session()->forget('configID');

        $this->reset();

        $this->calendarMonth = (int) date('n');
        $this->calendarYear = (int) date('Y');
    }

    // ========== HELPERS ==========

    public function getFurnishData(): array
    {
        $rooms = Room::query()
            ->with('furnishItems')
            ->get();

        if ($rooms->isNotEmpty()) {
            $result = [];

            foreach ($rooms as $room) {
                $result[$room->name] = $room->furnishItems->map(function ($item) {
                    $data = [
                        'name' => $item->name,
                    ];

                    if ($item->image) {
                        $data['image'] = $item->image;
                    }

                    if (! is_null($item->min_properties)) {
                        $data['minProperties'] = $item->min_properties;
                    }

                    if ($item->label) {
                        $data['label'] = $item->label;
                    }

                    if (! is_null($item->base_price)) {
                        $data['price'] = (float) $item->base_price;
                    }

                    if (! is_null($item->base_m3)) {
                        $data['m3'] = (float) $item->base_m3;
                    }

                    if (! is_null($item->base_tempo_carico)) {
                        $data['tempo_carico'] = (float) $item->base_tempo_carico;
                    }

                    if (! is_null($item->base_tempo_scarico)) {
                        $data['tempo_scarico'] = (float) $item->base_tempo_scarico;
                    }

                    if (! empty($item->properties)) {
                        $data['properties'] = $item->properties;
                    }

                    return $data;
                })->toArray();
            }

            return $result;
        }

        $path = public_path('furnish.json');
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true) ?? [];
        }

        return [];
    }

    public function getAllFurnitureOptions(): array
    {
        $furnishData = $this->getFurnishData();
        $allOptions = [];

        foreach ($furnishData as $roomName => $items) {
            foreach ($items as $item) {
                $allOptions[] = [
                    'name' => $item['name'],
                    'displayName' => $item['name'],
                    'room' => $roomName,
                    'image' => $item['image'] ?? null,
                    'fullOption' => $item,
                ];
            }
        }

        return $allOptions;
    }

    public function getCalendarDays(): array
    {
        $firstDay = mktime(0, 0, 0, $this->calendarMonth, 1, $this->calendarYear);
        $dayOfWeek = (int) date('w', $firstDay);
        $daysInMonth = (int) date('t', $firstDay);

        $days = [];
        for ($i = 0; $i < $dayOfWeek; $i++) {
            $days[] = null;
        }
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $days[] = sprintf('%04d-%02d-%02d', $this->calendarYear, $this->calendarMonth, $i);
        }

        return $days;
    }

    public function getCalendarMonthName(): string
    {
        $months = [
            1 => 'gennaio', 2 => 'febbraio', 3 => 'marzo', 4 => 'aprile',
            5 => 'maggio', 6 => 'giugno', 7 => 'luglio', 8 => 'agosto',
            9 => 'settembre', 10 => 'ottobre', 11 => 'novembre', 12 => 'dicembre',
        ];

        return ($months[$this->calendarMonth] ?? '').' '.$this->calendarYear;
    }

    public function isDayDisabled($dateStr): bool
    {
        if (! $dateStr) {
            return true;
        }
        $date = strtotime($dateStr);
        $today = strtotime('today');
        $tomorrow = strtotime('tomorrow');

        return $date <= $today || $date == $tomorrow;
    }

    public function calculateItemTotalPrice($item): float
    {
        $total = ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
        if (isset($item['selectedProperty'])) {
            $total += $this->calculateItemTotalPrice($item['selectedProperty']);
        }

        return $total;
    }

    public function getTransportTypeDisplayText($value): string
    {
        $mapping = [
            'solo_trasporto' => 'Solo Trasporto',
            'trasporto_parziale' => 'Trasporto + Montaggio o Smontaggio',
            'trasporto_totale' => 'Trasporto + Montaggio + Smontaggio',
        ];

        return $mapping[$value] ?? $value;
    }

    #[Computed]
    public function isBookingEnabled(): bool
    {
        return ($this->selectedDate !== null && $this->selectedDate !== '')
            && ($this->selectedTimeSlot !== null && $this->selectedTimeSlot !== '')
            && ($this->selectedPayment !== null && $this->selectedPayment !== '')
            && $this->privacyConsent === true;
    }

    public function getTotalTime(): float
    {
        $totalTime = $this->tempoTotale;
        if ($this->tipoTrasporto === 'trasporto_parziale') {
            $totalTime += ($this->totalCaricoTime + $this->totalScaricoTime) / 2;
        } elseif ($this->tipoTrasporto === 'trasporto_totale') {
            $totalTime += $this->totalCaricoTime + $this->totalScaricoTime;
        }

        return $totalTime;
    }

    public function render()
    {
        return view('livewire.configuratore')->layout('layouts.app');
    }
}
