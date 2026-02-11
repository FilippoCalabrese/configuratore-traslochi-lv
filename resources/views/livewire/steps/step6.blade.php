@php
    $finalTotal = $this->calculateFinalTotal();
    $totalTime = $this->getTotalTime();
    $calendarDays = $this->getCalendarDays();
    $monthName = $this->getCalendarMonthName();
@endphp

<div class="w-full flex flex-col h-screen">
    @include('livewire.partials.header')



    <div class="bg-base-100 border-b px-4 py-2">
        @include('livewire.partials.progress-bar', ['currentStep' => 6])
    </div>

    <main class="flex w-full items-center justify-center flex-col pb-25 gap-4 flex-1">
        <div class="flex lg:flex-row relative h-full flex-col w-full flex-1">
            @if($bookingLoader)
                <div class="fixed top-0 left-0 z-50 w-full h-screen bg-black bg-opacity-20 flex justify-center items-center"></div>
            @endif

            {{-- Left column: Summary --}}
            <div class="flex-1 p-4 justify-between flex flex-col relative lg:border-r border-b">
                <div>
                    <h2 class="text-lg font-semibold mb-4">Riepilogo trasloco</h2>

                    {{-- Nome --}}
                    <p class="text-xs flex flex-col border mt-2 border-[#cccccc] rounded-xl p-2 font-semibold">
                        <span class="text-xs font-bold uppercase text-gray-700 flex items-center gap-2">
                            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            nome:
                        </span>
                        <span class="text-sm mt-1.5 font-normal text-black">{{ $firstName }}</span>
                    </p>

                    {{-- Luogo Carico --}}
                    <p class="text-xs flex flex-col border mt-2 border-[#cccccc] rounded-xl p-2 font-semibold">
                        <span class="text-xs font-bold uppercase text-gray-700 flex items-center gap-2">
                            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            luogo carico:
                        </span>
                        <span class="text-sm mt-1.5 font-normal text-black">{{ $luogoCarico }}</span>
                    </p>

                    {{-- Luogo Scarico --}}
                    <p class="text-xs flex flex-col border mt-2 border-[#cccccc] rounded-xl p-2 font-semibold">
                        <span class="text-xs font-bold uppercase text-gray-700 flex items-center gap-2">
                            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            luogo scarico:
                        </span>
                        <span class="text-sm mt-1.5 font-normal text-black">{{ $luogoScarico }}</span>
                    </p>

                    {{-- Ascensore & ZTL --}}
                    <div class="flex relative gap-2 w-full">
                        <p class="text-xs flex flex-1 uppercase flex-col border mt-2 border-[#cccccc] rounded-xl p-2 font-bold">
                            <span class="flex items-center gap-2">
                                <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21 16-4 4-4-4"/><path d="M17 20V4"/><path d="m3 8 4-4 4 4"/><path d="M7 4v16"/></svg>
                                Ascensore:
                            </span>
                            <span class="text-sm mt-1.5 font-bold text-black">
                                {{ $ascensore ? 'SI' : 'NO' }}
                            </span>
                        </p>
                        <p class="text-xs flex flex-1 uppercase flex-col border mt-2 border-[#cccccc] rounded-xl p-2 font-bold">
                            <span class="flex items-center gap-2">
                                <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/></svg>
                                ZTL:
                            </span>
                            <span class="text-sm mt-1.5 font-bold text-black">
                                {{ $ztl ? 'SI' : 'NO' }}
                            </span>
                        </p>
                    </div>

                    {{-- Imballaggio --}}
                    <p class="text-xs flex flex-1 uppercase flex-col border mt-2 border-[#cccccc] rounded-xl p-2 font-bold">
                        <span class="flex items-center gap-2">
                            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                            Imballaggio:
                        </span>
                        <span class="text-sm mt-1.5 font-bold text-black">
                            {{ $imballaggio ? 'SI' : 'NO' }}
                        </span>
                    </p>

                    {{-- Tipo Trasporto --}}
                    <p class="text-xs flex flex-1 uppercase flex-col border mt-2 border-[#cccccc] rounded-xl p-2 font-bold">
                        <span class="flex items-center gap-2">
                            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
                            Tipo trasporto:
                        </span>
                        <span class="text-sm mt-1.5 font-normal normal-case text-black">
                            {{ $this->getTransportTypeDisplayText($tipoTrasporto) }}
                        </span>
                    </p>

                    {{-- Tempo Totale --}}
                    <p class="text-xs flex flex-1 uppercase flex-col border mt-2 border-[#cccccc] rounded-xl p-2 font-bold">
                        <span class="flex items-center gap-2">
                            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Tempo totale:
                        </span>
                        <span class="text-sm mt-1.5 font-normal normal-case text-black">
                            {{ round($totalTime) }} minuti ({{ round($totalTime / 60) }} ore)
                        </span>
                    </p>

                    {{-- Costo Trasporto --}}
                    <p>
                        <span class="text-xs flex uppercase flex-col border mt-2 border-[#cccccc] rounded-xl p-2 font-bold">
                            <span class="flex items-center gap-2">
                                <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>
                                COSTO TRASPORTO:
                            </span>
                            <span class="text-sm mt-1.5 font-mono font-normal text-black">
                                €{{ round($transportCost) }} ({{ round($distanzaTotale) }}km)
                            </span>
                        </span>
                    </p>
                </div>

                {{-- Total --}}
                <p class="text-sm flex bg-base-200 uppercase mt-2 justify-between items-center border border-[#cccccc] rounded-xl p-4 font-semibold">
                    <span class="flex items-center gap-2">
                        <svg class="icon-md" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="16" x="4" y="4" rx="2"/><path d="M8 10h8"/><path d="M8 14h4"/></svg>
                        Totale:
                    </span>
                    <span class="text-xl font-mono font-bold text-black">
                        € {{ $finalTotal }}
                    </span>
                </p>

                {{-- Clausole legali --}}
                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                    <h3 class="text-sm font-bold mb-3 text-gray-800">Clausole e condizioni</h3>
                    <div class="space-y-2 text-xs text-gray-700">
                        <p class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>L'azienda non si assume responsabilità in caso di rottura del piano della cucina.</span>
                        </p>
                        <p class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>L'azienda non si assume responsabilità per eventuali danni a oggetti fragili, delicati o di valore non preventivamente dichiarati e assicurati.</span>
                        </p>
                        <p class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Qualsiasi variazione del preventivo verrà quantificata al momento.</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Middle column: Calendar --}}
            <div class="flex-1 p-4 lg:border-r border-b">
                <h2 class="text-lg font-semibold mb-4">Seleziona un giorno</h2>
                <div class="flex justify-between mb-2">
                    <button class="p-1 px-3 border" wire:click="changeCalendarMonth(-1)">
                        <svg class="icon-sm transform rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </button>
                    <span>{{ $monthName }}</span>
                    <button class="p-1 px-3 border" wire:click="changeCalendarMonth(1)">
                        <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </button>
                </div>
                <div class="custom-grid-cols gap-2">
                    @foreach($calendarDays as $day)
                        @if($day === null)
                            <div class="p-2"></div>
                        @else
                            @php
                                $isDisabled = $this->isDayDisabled($day);
                                $isSelected = $selectedDate === $day;
                                $dayNum = (int) date('j', strtotime($day));
                            @endphp
                            <button
                                wire:click="selectDate('{{ $day }}')"
                                class="p-2 border rounded w-full {{ $isDisabled ? 'opacity-50 cursor-not-allowed' : '' }} {{ $isSelected ? 'bg-blue-500 text-white' : 'bg-gray-50' }}"
                                {{ $isDisabled ? 'disabled' : '' }}
                            >
                                {{ $dayNum }}
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Right column: Time slots & Payment --}}
            <div class="flex-1 p-4">
                <h2 class="text-lg font-semibold mb-4">Orari disponibili</h2>

                @if(count($timeSlots) > 0)
                    <div class="space-y-2 border p-3 rounded-lg relative max-h-[230px] overflow-y-scroll">
                        @foreach($timeSlots as $slot)
                            <button
                                wire:click="selectTimeSlot('{{ $slot }}')"
                                class="block p-2 border rounded w-full {{ $selectedTimeSlot === $slot ? 'bg-green-200' : 'bg-gray-50' }}"
                            >
                                {{ $slot }}
                            </button>
                        @endforeach
                        <span class="sticky bottom-0 justify-end flex gap-1.5 items-center right-2 text-xs text-gray-500">
                            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                            Scorri per altri orari
                        </span>
                    </div>
                @else
                    <p>Seleziona un giorno per vedere gli slot disponibili.</p>
                @endif

                {{-- Payment Methods --}}
                <div class="flex flex-1 gap-10 mt-5 flex-col items-center justify-center w-full">
                    <div class="h-max w-full">
                        <div class="w-full flex flex-col gap-5">
                            <h1 class="text-lg font-semibold">
                                Scegli il metodo di pagamento
                            </h1>
                            <div class="form-control border rounded-lg px-3 py-2">
                                <label class="label cursor-pointer">
                                    <span class="label-text text-base">
                                        Pagamento alla consegna
                                        <svg class="icon-lg ml-2 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
                                    </span>
                                    <input
                                        type="radio"
                                        name="payment-method"
                                        class="radio checked:bg-blue-600"
                                        wire:click="selectPayment('consegna')"
                                        {{ $selectedPayment === 'consegna' ? 'checked' : '' }}
                                    />
                                </label>
                                @if($selectedPayment === 'consegna')
                                    <div class="text-sm bg-gray-100 p-3 rounded-lg mt-3">
                                        Selezionando questo metodo di pagamento potrai pagare in contanti al momento della consegna. Una volta confermata la prenotazione, riceverai una mail di conferma con tutti i dettagli.
                                    </div>
                                @endif
                            </div>
                            <div class="form-control border rounded-lg px-3 py-2">
                                <label class="label cursor-pointer">
                                    <span class="label-text text-base">
                                        Pagamento con carta
                                        <svg class="icon-lg ml-2 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                                    </span>
                                    <input
                                        type="radio"
                                        name="payment-method"
                                        class="radio checked:bg-blue-600"
                                        wire:click="selectPayment('carta')"
                                        {{ $selectedPayment === 'carta' ? 'checked' : '' }}
                                    />
                                </label>
                                @if($selectedPayment === 'carta')
                                    <div class="text-sm bg-gray-100 p-3 rounded-lg mt-3">
                                        Selezionando questo metodo di pagamento verrai reindirizzato al sito di Stripe per completare il pagamento tramite carta di credito/debito.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Privacy Consent --}}
                <div class="mt-4 p-3 border rounded-lg bg-gray-50">
                    <label class="flex items-start cursor-pointer">
                        <input
                            type="checkbox"
                            class="checkbox checkbox-sm mt-1 mr-3"
                            wire:model="privacyConsent"
                        />
                        <span class="text-xs text-gray-700">
                            Acconsento al trattamento dei miei dati personali con finalità di ricontatto per la finalizzazione dell'offerta.
                            <a href="/privacy-policy" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800 underline">
                                Privacy Policy
                            </a>
                        </span>
                    </label>
                </div>

                {{-- Booking Button --}}
                @if($bookingLoader)
                    <div class="mt-4 p-2 btn bg-primary text-black rounded w-full text-center">
                        Attendi...
                    </div>
                @else
                    <button
                        class="mt-4 p-2 btn bg-primary text-black rounded w-full"
                        wire:click="handleBooking"
                        {{ (!$selectedTimeSlot || !$privacyConsent) ? 'disabled' : '' }}
                    >
                        Prenota
                    </button>
                @endif

                @if($bookingMessage)
                    <div class="flex w-full bg-red-500 border border-red-700 justify-center items-center h-max mt-5 p-2 text-white rounded-lg">
                        <p>{{ $bookingMessage }}</p>
                    </div>
                @endif
            </div>
        </div>
    </main>

    {{-- Bottom Navigation --}}
    <div class="flex bg-base-100 border-t p-4 w-full justify-between">
        <button
            wire:click="goToStep(5)"
            class="btn bg-gray-300 hover:bg-gray-400 text-gray-800 border-gray-300"
        >
            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            INDIETRO
        </button>
    </div>
</div>
