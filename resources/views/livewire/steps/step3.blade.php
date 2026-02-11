@php
$roomButtons = [
    ['key' => 'Soggiorno', 'label' => 'Soggiorno', 'image' => 'soggiorno.svg'],
    ['key' => 'Giardino e Garage', 'label' => 'Giardino e Garage', 'image' => 'giardino.svg'],
    ['key' => 'Cucina', 'label' => 'Cucina', 'image' => 'cucina-select.svg'],
    ['key' => 'Camera', 'label' => 'Camera', 'image' => 'camera.svg'],
    ['key' => 'Bagno', 'label' => 'Bagno', 'image' => 'bagno.svg'],
    ['key' => 'Palestra e Altro', 'label' => 'Palestra e Altro', 'image' => 'palestra.svg'],
];
@endphp

<div
    class="w-full bg-center bg-opacity-30 bg-repeat flex flex-col h-screen"
    style="background-image: url('{{ asset('images/bg.svg') }}')"
>
    @include('livewire.partials.header', ['currentStep' => 3])

    <div class="flex w-full flex-col items-center justify-center pb-20 flex-1">
        <div class="p-4 w-full bg-gray-50 max-w-4xl rounded-lg shadow-xl">
            <h2 class="text-2xl font-bold mb-4">Seleziona le stanze :</h2>

            <div class="sm:grid flex flex-col gap-4 sm:grid-cols-2 grid-cols-1">
                @foreach($roomButtons as $room)
                    <button
                        wire:click="toggleRoom('{{ $room['key'] }}')"
                        class="room-selection-btn flex w-full relative items-center justify-center gap-3 py-4 flex-col {{ ($selectedRooms[$room['key']] ?? false) ? 'btn-primary text-black' : 'btn-primary opacity-50' }}"
                    >
                        @if($selectedRooms[$room['key']] ?? false)
                            <span class="absolute top-2 right-2 inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500 text-white shadow-md">
                                <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            </span>
                        @endif
                        <img src="{{ asset('images/' . $room['image']) }}" class="max-w-[56px] max-h-[56px] text-black" alt="{{ $room['label'] }}" />
                        <span class="font-semibold text-lg">{{ $room['label'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Bottom Navigation --}}
    <div class="flex fixed bottom-0 bg-base-100 border-t p-4 w-full justify-between">
        <button wire:click="goToStep(2)"
            class="btn bg-gray-300 hover:bg-gray-400 text-gray-800 border-gray-300">
            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            INDIETRO
        </button>
        <button wire:click="submitStep3" class="btn btn-primary" wire:loading.attr="disabled">
            <span wire:loading wire:target="submitStep3" class="loading loading-spinner mx-[24px]"></span>
            <span wire:loading.remove wire:target="submitStep3" class="flex gap-1.5">
                AVANTI
                <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </span>
        </button>
    </div>
</div>
