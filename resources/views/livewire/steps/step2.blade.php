<div
     class="w-full flex bg-center bg-opacity-30 bg-repeat flex-col h-screen"
     style="background-image: url('{{ asset('images/bg.svg') }}')"
     x-data="googleMapsAutocomplete()"
     x-init="initAutocomplete()"
>
    <form wire:submit="submitStep2" class="flex flex-1 w-full flex-col">
        @include('livewire.partials.header')



        <div class="bg-base-100 border-b px-4 py-2">
            @include('livewire.partials.progress-bar', ['currentStep' => 2])
        </div>

        <div class="flex flex-1 flex-col pb-20 items-center justify-center w-full">
            <div class="p-8 card bg-base-100 w-full max-w-xl shadow-md">
                <div class="w-full space-y-6">
                    {{-- Indirizzo Carico --}}
                    <div>
                        <label class="font-medium text-gray-700 block mb-3 flex items-center gap-2">
                            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            Indirizzo Carico
                        </label>
                        <input
                            x-ref="luogoCarico"
                            type="text"
                            required
                            class="input input-bordered input-soft h-12 w-full"
                            placeholder="Es. Via Roma 1, 55015 Turchetto LU, Italia"
                            wire:model="luogoCarico"
                            x-on:change="$wire.set('luogoCarico', $el.value)"
                        />
                    </div>

                    {{-- Indirizzo Scarico --}}
                    <div>
                        <label class="font-medium text-gray-700 block mb-3 flex items-center gap-2">
                            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            Indirizzo Scarico
                        </label>
                        <input
                            x-ref="luogoScarico"
                            type="text"
                            required
                            class="input input-bordered input-soft h-12 w-full"
                            placeholder="Es. Via Roma 1, 55015 Turchetto LU, Italia"
                            wire:model="luogoScarico"
                            x-on:change="$wire.set('luogoScarico', $el.value)"
                        />
                    </div>

                    {{-- Servizi Accessori --}}
                    <div>
                        <label class="font-medium text-gray-700 block mb-3 flex items-center gap-2">
                            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
                            Servizi Accessori
                        </label>
                        <select
                            wire:model="tipoTrasporto"
                            required
                            class="text-base select select-bordered w-full rounded-2xl h-12"
                        >
                            <option value="solo_trasporto">Solo Trasporto</option>
                            <option value="trasporto_parziale">Trasporto + Montaggio o Smontaggio</option>
                            <option value="trasporto_totale">Trasporto + Montaggio + Smontaggio</option>
                        </select>

                        <div class="flex gap-3 mt-4">
                            <div class="flex flex-col items-start w-full">
                                <label class="font-medium text-gray-700 block mb-3 flex items-center gap-2">
                                    <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>
                                    Piano Carico
                                </label>
                                <select wire:model="pianoCarico" class="select select-bordered w-full rounded-2xl h-12">
                                    @for($i = 0; $i < 20; $i++)
                                        <option value="{{ $i }}">{{ $i === 0 ? 'Piano terra' : $i . '° Piano' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="flex flex-col items-start w-full">
                                <label class="font-medium text-gray-700 block mb-3 flex items-center gap-2">
                                    <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>
                                    Piano Scarico
                                </label>
                                <select wire:model="pianoScarico" class="select select-bordered w-full rounded-2xl h-12">
                                    @for($i = 0; $i < 20; $i++)
                                        <option value="{{ $i }}">{{ $i === 0 ? 'Piano terra' : $i . '° Piano' }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Imballaggio e ZTL --}}
                    <div class="flex gap-4 items-start justify-between">
                        <div class="w-full">
                            <label class="font-medium text-gray-700 block mb-3 flex items-center gap-2">
                                <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                                Imballaggio:
                            </label>
                            <div class="flex gap-2">
                                <button type="button" wire:click="$set('imballaggio', true)"
                                    class="font-bold py-1 px-3 btn flex-1 {{ $imballaggio ? 'bg-primary text-black hover:bg-primary-700' : 'bg-gray-300 hover:bg-gray-400' }}">
                                    Si
                                </button>
                                <button type="button" wire:click="$set('imballaggio', false)"
                                    class="font-bold py-1 px-3 btn flex-1 {{ !$imballaggio ? 'bg-primary text-black hover:bg-primary-700' : 'bg-gray-300 hover:bg-gray-400' }}">
                                    No
                                </button>
                            </div>
                        </div>

                        <div class="w-full">
                            <label class="font-medium text-gray-700 block mb-3 flex items-center gap-2">
                                <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/></svg>
                                ZTL:
                            </label>
                            <div class="flex gap-2">
                                <button type="button" wire:click="$set('ztl', true)"
                                    class="font-bold py-1 px-3 btn flex-1 {{ $ztl ? 'bg-primary text-black hover:bg-primary-700' : 'bg-gray-300 hover:bg-gray-400' }}">
                                    Si
                                </button>
                                <button type="button" wire:click="$set('ztl', false)"
                                    class="font-bold py-1 px-3 btn flex-1 {{ !$ztl ? 'bg-primary text-black hover:bg-primary-700' : 'bg-gray-300 hover:bg-gray-400' }}">
                                    No
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Ascensore --}}
                    <div>
                        <label class="font-medium text-gray-700 block mb-3 flex items-center gap-2">
                            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21 16-4 4-4-4"/><path d="M17 20V4"/><path d="m3 8 4-4 4 4"/><path d="M7 4v16"/></svg>
                            Ascensore:
                        </label>
                        <div class="flex gap-2">
                            <button type="button" wire:click="$set('ascensore', true)"
                                class="font-bold py-1 px-3 btn flex-1 {{ $ascensore ? 'bg-primary text-black hover:bg-primary-700' : 'bg-gray-300 hover:bg-gray-400' }}">
                                Si
                            </button>
                            <button type="button" wire:click="$set('ascensore', false)"
                                class="font-bold py-1 px-3 btn flex-1 {{ !$ascensore ? 'bg-primary text-black hover:bg-primary-700' : 'bg-gray-300 hover:bg-gray-400' }}">
                                No
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Navigation --}}
        <div class="flex fixed bottom-0 bg-base-100 border-t p-4 w-full justify-between">
            <button type="button" wire:click="goToStep(1)"
                class="btn bg-gray-300 hover:bg-gray-400 text-gray-800 border-gray-300">
                <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                INDIETRO
            </button>
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <span wire:loading wire:target="submitStep2" class="loading loading-spinner mx-[24px]"></span>
                <span wire:loading.remove wire:target="submitStep2" class="flex gap-1.5">
                    AVANTI
                    <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </span>
            </button>
        </div>
    </form>
</div>

@script
<script>
    $wire.on('calculateRoute', (params) => {
        const data = params[0];
        const companyAddress = data.companyAddress;
        const userOrigin = data.luogoCarico;
        const userDestination = data.luogoScarico;

        if (!userOrigin || !userDestination) {
            alert('Inserisci entrambi gli indirizzi');
            return;
        }

        const directionsService = new google.maps.DirectionsService();

        Promise.all([
            directionsService.route({
                origin: companyAddress,
                destination: userOrigin,
                travelMode: google.maps.TravelMode.DRIVING,
            }),
            directionsService.route({
                origin: userOrigin,
                destination: userDestination,
                travelMode: google.maps.TravelMode.DRIVING,
            }),
            directionsService.route({
                origin: userDestination,
                destination: companyAddress,
                travelMode: google.maps.TravelMode.DRIVING,
            }),
        ]).then(([resultAtoB, resultBtoC, resultCtoA]) => {
            const distanceAtoB = resultAtoB.routes[0].legs[0].distance.value;
            const timeAtoB = resultAtoB.routes[0].legs[0].duration.value;
            const distanceBtoC = resultBtoC.routes[0].legs[0].distance.value;
            const timeBtoC = resultBtoC.routes[0].legs[0].duration.value;
            const distanceCtoA = resultCtoA.routes[0].legs[0].distance.value;
            const timeCtoA = resultCtoA.routes[0].legs[0].duration.value;

            const totalDistance = (distanceAtoB + distanceBtoC + distanceCtoA) / 1000;
            const totalTime = (timeAtoB + timeBtoC + timeCtoA) / 60;

            $wire.distanceCalculated({
                distanza_totale: totalDistance,
                tempo_totale: totalTime,
            });
        }).catch((error) => {
            console.error('Error calculating route:', error);
            alert('Errore nel calcolo del percorso. Verifica gli indirizzi.');
            $wire.set('isLoading', false);
        });
    });
</script>
@endscript
