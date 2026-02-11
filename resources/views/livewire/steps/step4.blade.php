@php
    $furnishData = $this->getFurnishData();
    $allFurnitureOptions = $this->getAllFurnitureOptions();
    $currentRoomOptions = $furnishData[$currentRoom] ?? [];
@endphp

<div
     class="w-full bg-center bg-opacity-30 bg-base-100 h-screen flex flex-col gap-4"
     style="background-image: url('{{ asset('images/bg.svg') }}')"
     x-data="step4Handler()"
>
    <form wire:submit="submitStep4" class="h-screen flex flex-col">
        {{-- Header with room selector --}}
        <div class="flex relative gap-10 bg-base-100 border-b p-4 w-full justify-between">
            <div class="flex items-center gap-2 w-[70px]">
                <img src="{{ asset('logo.png') }}" class="w-full h-auto" alt="Logo" />
            </div>
            <div class="flex flex-col md:flex-row md:items-center w-full md:w-max justify-center md:gap-4">
                <p class="text-sm md:text-lg font-medium text-gray-700 mb-1">
                    Cambia stanza:
                </p>
                @if(count($roomNames) > 0)
                    <select
                        wire:model.live="currentRoom"
                        wire:change="changeRoom($event.target.value)"
                        class="select font-bold bg-yellow-200 uppercase relative select-bordered"
                    >
                        @foreach($roomNames as $room)
                            <option value="{{ $room }}">{{ $room }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>



        <div class="bg-base-100 border-b px-4 py-2">
            @include('livewire.partials.progress-bar', ['currentStep' => 4])
        </div>

        <div class="flex-1 pb-20">
            <div class="flex md:flex-wrap flex-col gap-4">
                <div class="flex flex-col px-4 py-4 gap-4">
                    {{-- Add Mobile Button --}}
                    <div
                        class="border min-w-full sticky top-5 flex-col sm:min-w-[400px] flex-1 border-dashed border-black/30 font-bold bg-green-300 hover:bg-green-300/50 text-black/80 hover:text-black/80 p-4 rounded-lg mb-4 cursor-pointer flex justify-center items-center"
                        style="max-height: 90px"
                        wire:click="addSelection"
                    >
                        <span class="flex text-xl items-center">
                            AGGIUNGI MOBILE
                            <svg class="icon-lg ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        </span>
                    </div>

                    {{-- Selections --}}
                    @foreach($selections as $index => $selection)
                        <div class="selection-div-{{ $index }} border flex min-w-full sm:min-w-[400px] flex-1 flex-col justify-between border-black/20 bg-white shadow-lg shadow-black/5 rounded-lg mb-4">
                            <div class="p-4">
                                @include('livewire.partials.furniture-selector', [
                                    'selection' => $selection,
                                    'index' => $index,
                                    'allFurnitureOptions' => $allFurnitureOptions,
                                    'currentRoomOptions' => $currentRoomOptions,
                                    'furnishData' => $furnishData,
                                ])
                            </div>

                            @php
                                $quantity = $selection['levels'][0]['quantity'] ?? 0;
                            @endphp

                            @if($quantity > 0 && !empty($selection['levels'][0]['name']))
                                <div class="flex p-4 w-full mt-4 border-t border-black/20 items-center justify-between">
                                    <label class="flex gap-2 text-sm font-medium text-gray-700">
                                        Quantità:
                                        <span>{{ $quantity }}</span>
                                    </label>
                                    <div class="flex gap-3">
                                        <button
                                            type="button"
                                            wire:click="decrementQuantity({{ $index }})"
                                            class="btn btn-outline border-black/20 hover:bg-gray-100 hover:border-black/20 hover:text-black"
                                        >
                                            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="incrementQuantity({{ $index }})"
                                            class="btn btn-outline border-black/20 hover:bg-gray-100 hover:border-black/20 hover:text-black"
                                        >
                                            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Bottom Navigation --}}
        <div class="flex fixed bottom-0 bg-base-100 border-t p-4 w-full justify-between">
            <button
                type="button"
                wire:click="goToStep(3)"
                class="btn bg-gray-300 hover:bg-gray-400 text-gray-800 border-gray-300"
            >
                <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                INDIETRO
            </button>
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <span wire:loading wire:target="submitStep4" class="loading loading-spinner mx-[24px]"></span>
                <span wire:loading.remove wire:target="submitStep4" class="flex gap-1.5">
                    AVANTI
                    <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </span>
            </button>
        </div>
    </form>
</div>

<script>
function step4Handler() {
    return {}
}
</script>
