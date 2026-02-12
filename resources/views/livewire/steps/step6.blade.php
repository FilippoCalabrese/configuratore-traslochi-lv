@php
    $finalTotal = $this->calculateFinalTotal();
    $totalTime = $this->getTotalTime();
    $calendarDays = $this->getCalendarDays();
    $monthName = $this->getCalendarMonthName();
@endphp

<div class="w-full flex flex-col h-screen">
    @include('livewire.partials.header', ['currentStep' => 5])

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

                    {{-- Dettaglio Costi --}}
                    <div class="mt-3 rounded-2xl bg-gray-50 border border-dashed border-gray-300 px-4 py-3">
                        <div class="flex items-center gap-2 text-gray-500 mb-3">
                            <svg class="icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>
                            <span class="text-xs font-semibold uppercase tracking-wide">Dettaglio costi</span>
                        </div>
                        
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-sm font-mono text-gray-900">
                                <span>Totale trasporto:</span>
                                <span>€{{ round($transportCost) }} <span class="text-gray-500 text-xs">({{ round($distanzaTotale) }} km)</span></span>
                            </div>
                            
                            <div class="flex justify-between items-center text-sm font-mono text-gray-900">
                                <span>Totale mobili:</span>
                                <span>€{{ number_format($totalPrice, 2, ',', '.') }}</span>
                            </div>
                            
                            {{-- Maggiorazioni --}}
                            @if($this->transportTypeMultiplier > 0 || $this->floorDifferenceCost > 0 || $this->ztlCost > 0 || $this->packagingCost > 0)
                                <div class="pt-2 border-t border-gray-300 space-y-1">
                                    @if($this->transportTypeMultiplier > 0)
                                        <div class="flex justify-between items-center text-xs font-mono text-orange-700">
                                            <span>Tipo trasporto:</span>
                                            <span>+€{{ number_format($this->transportTypeMultiplier, 2, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    @if($this->floorDifferenceCost > 0)
                                        <div class="flex justify-between items-center text-xs font-mono text-orange-700">
                                            <span>Differenza piani:</span>
                                            <span>+€{{ number_format($this->floorDifferenceCost, 2, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    @if($this->ztlCost > 0)
                                        <div class="flex justify-between items-center text-xs font-mono text-orange-700">
                                            <span>ZTL:</span>
                                            <span>+€{{ number_format($this->ztlCost, 2, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    @if($this->packagingCost > 0)
                                        <div class="flex justify-between items-center text-xs font-mono text-orange-700">
                                            <span>Imballaggio:</span>
                                            <span>+€{{ number_format($this->packagingCost, 2, ',', '.') }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                            {{-- Sconti --}}
                            @if($this->distanceDiscount > 0)
                                <div class="pt-2 border-t border-gray-300">
                                    <div class="flex justify-between items-center text-xs font-mono text-emerald-700">
                                        <span>Sconto distanza:</span>
                                        <span>-€{{ number_format($this->distanceDiscount, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Middle column: Calendar --}}
            <div class="flex-1 p-3 sm:p-6 lg:border-r border-gray-200 border-b min-w-0">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Seleziona un giorno</h2>
                <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-3 sm:p-6 w-full box-border">
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
                    <div class="custom-grid-cols">
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
                                    class="p-2 sm:p-3 border border-gray-200 rounded-2xl w-full font-medium transition-all text-sm sm:text-base {{ $isDisabled ? 'opacity-40 cursor-not-allowed bg-gray-50' : 'hover:bg-gray-50 hover:border-gray-300' }} {{ $isSelected ? 'bg-primary text-black border-primary shadow-sm' : 'bg-white text-gray-900' }}"
                                    {{ $isDisabled ? 'disabled' : '' }}
                                >
                                    {{ $dayNum }}
                                </button>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Orari disponibili --}}
                <div class="mt-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Orari disponibili</h2>

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
                        </div>
                    @else
                        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4 text-sm text-gray-600">
                            Seleziona un giorno per vedere gli slot disponibili.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right column: Payment --}}
            <div class="flex-1 p-6">
                {{-- Payment Methods --}}
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Scegli il metodo di pagamento</h2>
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
                            {{ $privacyConsent ? 'checked' : '' }}
                            wire:change="togglePrivacyConsent"
                        />
                        <span class="text-xs text-gray-700 leading-relaxed">
                            Acconsento al trattamento dei miei dati personali con finalità di ricontatto per la finalizzazione dell'offerta.
                            <a href="/privacy-policy" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800 underline font-medium">
                                Privacy Policy
                            </a>
                        </span>
                    </label>
                </div>

                {{-- Clausole legali --}}
                <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-2xl">
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

                {{-- Total --}}
                <div class="bg-amber-100 border border-amber-200 rounded-3xl px-5 py-4 flex items-center justify-between gap-6 mt-6">
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

                {{-- Booking Button --}}
                @php
                    $isBookingEnabled = ($selectedDate !== null && $selectedDate !== '')
                        && ($selectedTimeSlot !== null && $selectedTimeSlot !== '')
                        && ($selectedPayment !== null && $selectedPayment !== '')
                        && $privacyConsent === true;
                    $bookingKey = ($selectedDate ?? '') . '|' . ($selectedTimeSlot ?? '') . '|' . ($selectedPayment ?? '') . '|' . ($privacyConsent ? '1' : '0');
                @endphp
                @if($bookingLoader)
                    <button class="mt-6 btn bg-gray-400 hover:bg-gray-400 text-white w-full text-lg font-semibold cursor-not-allowed" disabled>
                        <span class="loading loading-spinner"></span>
                        Attendi...
                    </button>
                @else
                    <button
                        wire:key="booking-{{ $bookingKey }}"
                        class="mt-6 btn w-full text-lg font-semibold py-3 {{ !$isBookingEnabled ? 'bg-gray-400 hover:bg-gray-400 text-white cursor-not-allowed' : 'btn-primary' }}"
                        wire:click="handleBooking"
                        {{ !$isBookingEnabled ? 'disabled' : '' }}
                    >
                        Prenota
                    </button>
                @endif

                @if($bookingMessage)
                    <div class="flex w-full bg-red-50 border border-red-200 justify-center items-center h-max mt-5 p-4 text-red-700 rounded-2xl">
                        <p class="font-medium">{{ $bookingMessage }}</p>
                    </div>
                @endif

                {{-- Payment Security Badges --}}
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <p class="text-xs text-gray-500 text-center mb-3">Pagamento sicuro garantito da</p>
                    <div class="flex items-center justify-center gap-4 flex-wrap">
                        <img src="{{ asset('images/payment/visa.svg') }}" alt="Visa" class="h-6 opacity-80 hover:opacity-100 transition-opacity" />
                        <img src="{{ asset('images/payment/mastercard.svg') }}" alt="Mastercard" class="h-6 opacity-80 hover:opacity-100 transition-opacity" />
                        <img src="{{ asset('images/payment/amex.svg') }}" alt="American Express" class="h-6 opacity-80 hover:opacity-100 transition-opacity" />
                        <img src="{{ asset('images/payment/klarna.svg') }}" alt="Klarna" class="h-6 opacity-80 hover:opacity-100 transition-opacity" />
                    </div>
                </div>

                {{-- Reviews Carousel --}}
                @php
                use App\Models\Review;
                $reviews = Review::active()->ordered()->get();
                $avatarColors = ['bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-pink-500', 'bg-indigo-500', 'bg-red-500', 'bg-yellow-500', 'bg-teal-500'];
                @endphp

                <div 
                    class="mt-6 pt-6 border-t border-gray-200"
                    x-data="{
                        currentIndex: 0,
                        reviews: @js($reviews->map(function($review) {
                            return [
                                'id' => $review->id,
                                'name' => $review->name,
                                'avatar' => $review->avatar,
                                'rating' => $review->rating,
                                'date' => $review->date,
                                'text' => $review->text,
                            ];
                        })->toArray()),
                        autoPlayInterval: null,
                        init() {
                            this.startAutoPlay();
                        },
                        startAutoPlay() {
                            this.autoPlayInterval = setInterval(() => {
                                this.next();
                            }, 5000);
                        },
                        stopAutoPlay() {
                            if (this.autoPlayInterval) {
                                clearInterval(this.autoPlayInterval);
                                this.autoPlayInterval = null;
                            }
                        },
                        next() {
                            this.currentIndex = (this.currentIndex + 1) % this.reviews.length;
                        },
                        prev() {
                            this.currentIndex = (this.currentIndex - 1 + this.reviews.length) % this.reviews.length;
                        },
                        goTo(index) {
                            this.currentIndex = index;
                        }
                    }"
                    @mouseenter="stopAutoPlay()"
                    @mouseleave="startAutoPlay()"
                >
                    <div class="relative">
                        {{-- Review Card --}}
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm relative overflow-hidden" style="min-height: 200px;">
                            <template x-for="(review, index) in reviews" :key="review.id">
                                <div 
                                    x-show="currentIndex === index"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="absolute inset-0 p-6 flex flex-col"
                                    style="display: none;"
                                >
                                    <div class="flex items-start gap-3 mb-4">
                                        <div 
                                            :class="['{{ $avatarColors[0] }}', '{{ $avatarColors[1] }}', '{{ $avatarColors[2] }}', '{{ $avatarColors[3] }}', '{{ $avatarColors[4] }}', '{{ $avatarColors[5] }}'][index % 8]"
                                            class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm flex-shrink-0"
                                        >
                                            <span x-text="review.avatar"></span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-1">
                                                <h3 class="font-semibold text-base text-gray-900" x-text="review.name"></h3>
                                                <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                                </svg>
                                            </div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <div class="flex items-center gap-0.5">
                                                    <template x-for="i in 5" :key="i">
                                                        <svg 
                                                            :class="i <= review.rating ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300'" 
                                                            class="w-4 h-4" 
                                                            xmlns="http://www.w3.org/2000/svg" 
                                                            viewBox="0 0 24 24" 
                                                            fill="currentColor"
                                                        >
                                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                        </svg>
                                                    </template>
                                                </div>
                                            </div>
                                            <p class="text-xs text-gray-500" x-text="review.date"></p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-700 leading-relaxed" x-text="review.text"></p>
                                </div>
                            </template>
                        </div>

                        {{-- Navigation Arrows --}}
                        <button
                            @click="prev()"
                            class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 bg-white rounded-full p-2 shadow-md hover:shadow-lg transition-all border border-gray-200 hover:border-gray-300"
                            aria-label="Recensione precedente"
                        >
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button
                            @click="next()"
                            class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-white rounded-full p-2 shadow-md hover:shadow-lg transition-all border border-gray-200 hover:border-gray-300"
                            aria-label="Recensione successiva"
                        >
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        {{-- Dots Indicator --}}
                        <div class="flex items-center justify-center gap-2 mt-4">
                            <template x-for="(review, index) in reviews" :key="review.id">
                                <button
                                    @click="goTo(index)"
                                    :class="currentIndex === index ? 'bg-primary w-8' : 'bg-gray-300 w-2'"
                                    class="h-2 rounded-full transition-all duration-300"
                                    :aria-label="`Vai alla recensione ${index + 1}`"
                                ></button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @script
    <script>
        $wire.on('redirect-to-stripe', (event) => {
            const configId = event[0].config_id;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("stripe.checkout") }}';
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
            
            const configInput = document.createElement('input');
            configInput.type = 'hidden';
            configInput.name = 'config_id';
            configInput.value = configId;
            form.appendChild(configInput);
            
            document.body.appendChild(form);
            form.submit();
        });
    </script>
    @endscript

    {{-- Bottom Navigation --}}
    <div class="flex bg-base-100 border-t p-4 w-full justify-between">
        <button
            wire:click="goToStep(4)"
            class="btn bg-gray-300 hover:bg-gray-400 text-gray-800 border-gray-300"
        >
            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            INDIETRO
        </button>
    </div>
</div>
