@php
    $finalTotal = $this->calculateFinalTotal();
    $totalTime = $this->getTotalTime();
    $calendarDays = $this->getCalendarDays();
    $monthName = $this->getCalendarMonthName();
@endphp

<div class="w-full flex flex-col h-screen">
    @include('livewire.partials.header', ['currentStep' => 6])

    <main class="flex w-full items-center justify-center flex-col pb-25 gap-4 flex-1">
        <div class="flex lg:flex-row relative h-full flex-col w-full flex-1 max-w-7xl mx-auto">
            @if($bookingLoader)
                <div class="fixed top-0 left-0 z-50 w-full h-screen bg-black bg-opacity-20 flex justify-center items-center"></div>
            @endif

            {{-- Left column: Summary --}}
            <div class="flex-1 p-6 justify-between flex flex-col relative lg:border-r border-gray-200 border-b">
                <div class="space-y-3">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Riepilogo trasloco</h2>

                    {{-- Nome --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm px-4 py-3">
                        <div class="flex items-start gap-2">
                            <svg class="icon-sm mt-0.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <div class="flex-1">
                                <div class="text-xs font-semibold uppercase text-gray-500">Nome</div>
                                <div class="text-sm text-gray-900 mt-0.5">{{ $firstName }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Luogo Carico --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm px-4 py-3">
                        <div class="flex items-start gap-2">
                            <svg class="icon-sm mt-0.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <div class="flex-1">
                                <div class="text-xs font-semibold uppercase text-gray-500">Indirizzo di carico</div>
                                <div class="text-sm text-gray-900 mt-0.5">{{ $luogoCarico }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Luogo Scarico --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm px-4 py-3">
                        <div class="flex items-start gap-2">
                            <svg class="icon-sm mt-0.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <div class="flex-1">
                                <div class="text-xs font-semibold uppercase text-gray-500">Indirizzo di scarico</div>
                                <div class="text-sm text-gray-900 mt-0.5">{{ $luogoScarico }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Ascensore & ZTL --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm px-3 py-2.5">
                            <div class="flex items-center gap-1.5 text-gray-500">
                                <svg class="icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21 16-4 4-4-4"/><path d="M17 20V4"/><path d="m3 8 4-4 4 4"/><path d="M7 4v16"/></svg>
                                <span class="text-xs font-semibold uppercase tracking-wide">Ascensore</span>
                            </div>
                            <div class="mt-1 text-sm font-semibold {{ $ascensore ? 'text-emerald-600' : 'text-red-500' }}">
                                {{ $ascensore ? 'Sì' : 'No' }}
                            </div>
                        </div>
                        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm px-3 py-2.5">
                            <div class="flex items-center gap-1.5 text-gray-500">
                                <svg class="icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/></svg>
                                <span class="text-xs font-semibold uppercase tracking-wide">ZTL</span>
                            </div>
                            <div class="mt-1 text-sm font-semibold {{ $ztl ? 'text-emerald-600' : 'text-red-500' }}">
                                {{ $ztl ? 'Sì' : 'No' }}
                            </div>
                        </div>
                    </div>

                    {{-- Imballaggio --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm px-4 py-3">
                        <div class="flex items-start gap-2">
                            <svg class="icon-sm mt-0.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                            <div class="flex-1">
                                <div class="text-xs font-semibold uppercase text-gray-500">Imballaggio</div>
                                <div class="text-sm text-gray-900 mt-0.5 font-semibold {{ $imballaggio ? 'text-emerald-600' : 'text-red-500' }}">
                                    {{ $imballaggio ? 'Sì' : 'No' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tipo Trasporto --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm px-4 py-3">
                        <div class="flex items-start gap-2">
                            <svg class="icon-sm mt-0.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
                            <div class="flex-1">
                                <div class="text-xs font-semibold uppercase text-gray-500">Tipo trasporto</div>
                                <div class="text-sm text-gray-900 mt-0.5">
                                    {{ $this->getTransportTypeDisplayText($tipoTrasporto) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tempo Totale --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm px-4 py-3">
                        <div class="flex items-start gap-2">
                            <svg class="icon-sm mt-0.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <div class="flex-1">
                                <div class="text-xs font-semibold uppercase text-gray-500">Tempo totale</div>
                                <div class="text-sm text-gray-900 mt-0.5">
                                    {{ round($totalTime) }} minuti ({{ round($totalTime / 60) }} ore)
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Costo Trasporto --}}
                    <div class="mt-3 rounded-2xl bg-gray-50 border border-dashed border-gray-300 px-4 py-3">
                        <div class="flex items-center gap-2 text-gray-500">
                            <svg class="icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>
                            <span class="text-xs font-semibold uppercase tracking-wide">Costo trasporto</span>
                        </div>
                        <div class="mt-1 text-sm font-mono text-gray-900">
                            €{{ round($transportCost) }} <span class="text-gray-500">({{ round($distanzaTotale) }} km)</span>
                        </div>
                    </div>
                </div>

                {{-- Total --}}
                <div class="bg-amber-100 border border-amber-200 rounded-3xl px-5 py-4 flex items-center justify-between gap-6 mt-4">
                    <div class="flex flex-col gap-0.5 flex-1">
                        <span class="text-xs font-semibold tracking-wide text-amber-700 uppercase">Totale stimato</span>
                        <span class="text-[11px] text-amber-800">
                            IVA inclusa, potrebbero esserci piccole variazioni dopo il sopralluogo.
                        </span>
                    </div>
                    <div class="text-right flex-shrink-0 min-w-[140px]">
                        <div class="text-3xl font-extrabold text-gray-900 font-mono whitespace-nowrap">
                            € {{ $finalTotal }}
                        </div>
                    </div>
                </div>

                {{-- Clausole legali --}}
                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-2xl">
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
            <div class="flex-1 p-6 lg:border-r border-gray-200 border-b">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Seleziona un giorno</h2>
                <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <button 
                            class="p-2 rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors" 
                            wire:click="changeCalendarMonth(-1)"
                        >
                            <svg class="icon-sm transform rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                        </button>
                        <span class="text-lg font-semibold text-gray-900">{{ $monthName }}</span>
                        <button 
                            class="p-2 rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors" 
                            wire:click="changeCalendarMonth(1)"
                        >
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
                                    class="p-3 border border-gray-200 rounded-2xl w-full font-medium transition-all {{ $isDisabled ? 'opacity-40 cursor-not-allowed bg-gray-50' : 'hover:bg-gray-50 hover:border-gray-300' }} {{ $isSelected ? 'bg-primary text-black border-primary shadow-sm' : 'bg-white text-gray-900' }}"
                                    {{ $isDisabled ? 'disabled' : '' }}
                                >
                                    {{ $dayNum }}
                                </button>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right column: Time slots & Payment --}}
            <div class="flex-1 p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Orari disponibili</h2>

                @if(count($timeSlots) > 0)
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-4 space-y-2 relative max-h-[230px] overflow-y-auto">
                        @foreach($timeSlots as $slot)
                            <button
                                wire:click="selectTimeSlot('{{ $slot }}')"
                                class="block w-full p-3 border border-gray-200 rounded-2xl text-left font-medium transition-all {{ $selectedTimeSlot === $slot ? 'bg-primary text-black border-primary shadow-sm' : 'bg-white text-gray-900 hover:bg-gray-50 hover:border-gray-300' }}"
                            >
                                {{ $slot }}
                            </button>
                        @endforeach
                        <span class="sticky bottom-0 justify-end flex gap-1.5 items-center right-2 text-xs text-gray-500 bg-white/90 backdrop-blur-sm py-1">
                            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                            Scorri per altri orari
                        </span>
                    </div>
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4 text-sm text-gray-600">
                        Seleziona un giorno per vedere gli slot disponibili.
                    </div>
                @endif

                {{-- Payment Methods --}}
                <div class="mt-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Scegli il metodo di pagamento</h2>
                    <div class="space-y-3">
                        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-4 hover:border-gray-300 transition-colors">
                            <label class="flex items-center cursor-pointer gap-3">
                                <input
                                    type="radio"
                                    name="payment-method"
                                    class="radio radio-primary"
                                    wire:click="selectPayment('consegna')"
                                    {{ $selectedPayment === 'consegna' ? 'checked' : '' }}
                                />
                                <div class="flex items-center gap-2 flex-1">
                                    <svg class="icon-md text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
                                    <span class="text-base font-medium text-gray-900">Pagamento alla consegna</span>
                                </div>
                            </label>
                            @if($selectedPayment === 'consegna')
                                <div class="text-sm text-gray-600 bg-gray-50 p-3 rounded-xl mt-3 border border-gray-100">
                                    Selezionando questo metodo di pagamento potrai pagare in contanti al momento della consegna. Una volta confermata la prenotazione, riceverai una mail di conferma con tutti i dettagli.
                                </div>
                            @endif
                        </div>
                        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-4 hover:border-gray-300 transition-colors">
                            <label class="flex items-center cursor-pointer gap-3">
                                <input
                                    type="radio"
                                    name="payment-method"
                                    class="radio radio-primary"
                                    wire:click="selectPayment('carta')"
                                    {{ $selectedPayment === 'carta' ? 'checked' : '' }}
                                />
                                <div class="flex items-center gap-2 flex-1">
                                    <svg class="icon-md text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                                    <span class="text-base font-medium text-gray-900">Pagamento con carta</span>
                                </div>
                            </label>
                            @if($selectedPayment === 'carta')
                                <div class="text-sm text-gray-600 bg-gray-50 p-3 rounded-xl mt-3 border border-gray-100">
                                    Selezionando questo metodo di pagamento verrai reindirizzato al sito di Stripe per completare il pagamento tramite carta di credito/debito.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Privacy Consent --}}
                <div class="mt-6 p-4 border border-gray-200 rounded-2xl bg-gray-50">
                    <label class="flex items-start cursor-pointer gap-3">
                        <input
                            type="checkbox"
                            class="checkbox checkbox-primary mt-0.5"
                            wire:model="privacyConsent"
                        />
                        <span class="text-xs text-gray-700 leading-relaxed">
                            Acconsento al trattamento dei miei dati personali con finalità di ricontatto per la finalizzazione dell'offerta.
                            <a href="/privacy-policy" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800 underline font-medium">
                                Privacy Policy
                            </a>
                        </span>
                    </label>
                </div>

                {{-- Booking Button --}}
                @if($bookingLoader)
                    <button class="mt-6 btn btn-primary w-full text-lg font-semibold" disabled>
                        <span class="loading loading-spinner"></span>
                        Attendi...
                    </button>
                @else
                    <button
                        class="mt-6 btn btn-primary w-full text-lg font-semibold py-3"
                        wire:click="handleBooking"
                        {{ (!$selectedTimeSlot || !$privacyConsent) ? 'disabled' : '' }}
                    >
                        Prenota
                    </button>
                @endif

                @if($bookingMessage)
                    <div class="flex w-full bg-red-50 border border-red-200 justify-center items-center h-max mt-5 p-4 text-red-700 rounded-2xl">
                        <p class="font-medium">{{ $bookingMessage }}</p>
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
