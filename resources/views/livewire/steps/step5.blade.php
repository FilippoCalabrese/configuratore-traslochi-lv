
<div
    class="w-full bg-center bg-opacity-30 bg-repeat flex flex-col h-screen"
    style="background-image: url('{{ asset('images/bg.svg') }}')"
>
    @include('livewire.partials.header')


    <div class="bg-base-100 border-b px-4 py-2">
        @include('livewire.partials.progress-bar', ['currentStep' => 5])
    </div>

    <main class="flex-1 w-full px-4 pb-24 pt-6">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-6">
            {{-- Left Panel: Furniture Summary --}}
            <section class="flex-1 bg-white/90 border border-gray-200 rounded-3xl shadow-[0_18px_40px_rgba(15,23,42,0.08)] p-6 md:p-8 flex flex-col">
                <header class="mb-5 flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-900">
                            Riepilogo della configurazione
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Controlla i mobili selezionati per ogni stanza prima di procedere.
                        </p>
                    </div>
                </header>

                <div class="mt-2 flex-1 min-h-0">
                    <div class="h-full overflow-y-auto pr-1 space-y-5">
                        @foreach($furnitureConfig as $room => $items)
                            @if(count($items) > 0)
                                <section class="border border-gray-100 rounded-2xl bg-gray-50/70 px-4 py-4 md:px-5 md:py-5">
                                    <h3 class="text-sm font-semibold tracking-wide text-gray-600 uppercase mb-3">
                                        {{ strtoupper(str_replace('_', ' ', $room)) }}
                                    </h3>
                                    <div class="space-y-3">
                                        @foreach($items as $itemIndex => $item)
                                            @include('livewire.partials.furniture-item', [
                                                'item' => $item,
                                                'room' => $room,
                                                'itemIndex' => $itemIndex,
                                            ])
                                        @endforeach
                                    </div>
                                </section>
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- Right Panel: Totals --}}
            <aside class="w-full lg:w-[420px] space-y-4 lg:sticky lg:top-[120px]">
                <div class="bg-white/90 border border-gray-200 rounded-3xl shadow-[0_18px_40px_rgba(15,23,42,0.08)] p-6 space-y-4">
                    <h2 class="text-xl font-bold text-gray-900">
                        Dettagli del trasloco
                    </h2>

                    {{-- Cliente --}}
                    <div class="space-y-2 text-sm">
                        <div class="flex items-start gap-2">
                            <svg class="icon-sm mt-0.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <div class="flex-1">
                                <div class="text-xs font-semibold uppercase text-gray-500">Nome cliente</div>
                                <div class="text-sm text-gray-900">{{ $firstName }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Percorso --}}
                    <div class="space-y-2 text-sm">
                        <div class="flex items-start gap-2">
                            <svg class="icon-sm mt-0.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <div class="flex-1">
                                <div class="text-xs font-semibold uppercase text-gray-500">Indirizzo di carico</div>
                                <div class="text-sm text-gray-900">{{ $luogoCarico }}</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="icon-sm mt-0.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <div class="flex-1">
                                <div class="text-xs font-semibold uppercase text-gray-500">Indirizzo di scarico</div>
                                <div class="text-sm text-gray-900">{{ $luogoScarico }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Opzioni --}}
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="rounded-2xl border border-gray-200 px-3 py-2">
                            <div class="flex items-center gap-1.5 text-gray-500">
                                <svg class="icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21 16-4 4-4-4"/><path d="M17 20V4"/><path d="m3 8 4-4 4 4"/><path d="M7 4v16"/></svg>
                                <span class="font-semibold uppercase tracking-wide">Ascensore</span>
                            </div>
                            <div class="mt-1 text-sm font-semibold {{ $ascensore ? 'text-emerald-600' : 'text-red-500' }}">
                                {{ $ascensore ? 'Sì' : 'No' }}
                            </div>
                        </div>
                        <div class="rounded-2xl border border-gray-200 px-3 py-2">
                            <div class="flex items-center gap-1.5 text-gray-500">
                                <svg class="icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/></svg>
                                <span class="font-semibold uppercase tracking-wide">ZTL</span>
                            </div>
                            <div class="mt-1 text-sm font-semibold {{ $ztl ? 'text-emerald-600' : 'text-red-500' }}">
                                {{ $ztl ? 'Sì' : 'No' }}
                            </div>
                        </div>
                    </div>

                    {{-- Imballaggio & tipo trasporto --}}
                    <div class="space-y-3 pt-1">
                        <div class="text-xs flex flex-col gap-1">
                            <div class="flex items-center gap-2 text-gray-500 font-semibold uppercase">
                                <svg class="icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                                Imballaggio
                            </div>
                            <select
                                wire:change="updateImballaggio($event.target.value)"
                                class="select select-sm select-bordered rounded-2xl h-10 mt-0.5"
                            >
                                <option value="1" {{ $imballaggio ? 'selected' : '' }}>Si</option>
                                <option value="0" {{ !$imballaggio ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div class="text-xs flex flex-col gap-1">
                            <div class="flex items-center gap-2 text-gray-500 font-semibold uppercase">
                                <svg class="icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
                                Tipo trasporto
                            </div>
                            <select
                                wire:change="updateTipoTrasporto($event.target.value)"
                                class="select select-sm select-bordered rounded-2xl h-10 mt-0.5"
                            >
                                <option value="solo_trasporto" {{ $tipoTrasporto === 'solo_trasporto' ? 'selected' : '' }}>Solo Trasporto</option>
                                <option value="trasporto_parziale" {{ $tipoTrasporto === 'trasporto_parziale' ? 'selected' : '' }}>Trasporto + Montaggio o Smontaggio</option>
                                <option value="trasporto_totale" {{ $tipoTrasporto === 'trasporto_totale' ? 'selected' : '' }}>Trasporto + Montaggio + Smontaggio</option>
                            </select>
                        </div>
                    </div>

                    {{-- Costo Trasporto --}}
                    <div class="mt-3 rounded-2xl bg-gray-50 border border-dashed border-gray-300 px-4 py-3 text-xs">
                        <div class="flex items-center gap-2 text-gray-500 font-semibold uppercase">
                            <svg class="icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>
                            Costo trasporto
                        </div>
                        <div class="mt-1 text-sm font-mono text-gray-900">
                            €{{ round($transportCost) }} <span class="text-gray-500">({{ round($distanzaTotale) }} km)</span>
                        </div>
                    </div>
                </div>

                {{-- Final Total --}}
                <div class="bg-amber-100 border border-amber-200 rounded-3xl px-5 py-4 flex items-center justify-between gap-6">
                    <div class="flex flex-col gap-0.5 flex-1">
                        <span class="text-xs font-semibold tracking-wide text-amber-700 uppercase">Totale stimato</span>
                        <span class="text-[11px] text-amber-800">
                            IVA inclusa, potrebbero esserci piccole variazioni dopo il sopralluogo.
                        </span>
                    </div>
                    <div class="text-right flex-shrink-0 min-w-[140px]">
                        <div class="text-3xl font-extrabold text-gray-900 font-mono whitespace-nowrap">
                            € {{ $this->finalTotal }}
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    {{-- Bottom Navigation --}}
    <div class="flex fixed bottom-0 bg-base-100 border-t p-4 w-full justify-between">
        <button
            wire:click="goToStep(4)"
            class="btn bg-gray-300 hover:bg-gray-400 text-gray-800 border-gray-300"
        >
            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            INDIETRO
        </button>
        <button
            wire:click="submitStep5"
            {{ $totalPrice < 1 ? 'disabled' : '' }}
            class="btn btn-primary"
            wire:loading.attr="disabled"
        >
            <span wire:loading wire:target="submitStep5" class="loading loading-spinner mx-[24px]"></span>
            <span wire:loading.remove wire:target="submitStep5" class="flex gap-1.5">
                AVANTI
                <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </span>
        </button>
    </div>
</div>
