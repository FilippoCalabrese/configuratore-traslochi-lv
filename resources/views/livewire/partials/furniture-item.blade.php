@php
    $totalItemPrice = $this->calculateItemTotalPrice($item);
    $quantity = $item['quantity'] ?? 0;
    $image = $item['image'] ?? null;
@endphp

<div class="bg-white border border-gray-200 rounded-2xl shadow-sm px-4 py-3 my-2 flex flex-col gap-3">
    <div class="flex items-start gap-3">
        @if($image)
            <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-center overflow-hidden">
                <img
                    src="{{ asset('images/' . $image) }}"
                    alt="{{ $item['name'] ?? '' }}"
                    class="max-w-full max-h-full object-contain"
                />
            </div>
        @endif

        <div class="flex-1">
            <div class="flex items-start justify-between gap-2">
                <div class="flex-1">
                    <div class="font-semibold text-sm md:text-base text-gray-900">
                        {{ $item['name'] ?? '' }}
                    </div>

                    @if(isset($item['selectedProperty']))
                        <div class="mt-1 text-xs text-gray-600">
                            @include('livewire.partials.furniture-sub-properties', ['nestedItem' => $item])
                        </div>
                    @endif
                </div>

                <button
                    type="button"
                    wire:click="removeFurnitureItem('{{ $room }}', {{ $itemIndex }})"
                    wire:confirm="Sei sicuro di voler rimuovere questo mobile?"
                    class="btn btn-xs btn-ghost text-red-500 hover:text-red-600 hover:bg-red-50"
                    title="Rimuovi mobile"
                >
                    <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between pt-1 border-t border-gray-100 mt-1">
        <div class="flex items-center gap-3">
            <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Quantità</span>
            <div class="inline-flex items-center gap-1.5 rounded-full border border-gray-200 bg-gray-50 px-1.5 py-0.5">
                <button
                    type="button"
                    wire:click="updateFurnitureQuantity('{{ $room }}', {{ $itemIndex }}, {{ max(1, $quantity - 1) }})"
                    class="btn btn-xs btn-ghost text-gray-600 hover:bg-gray-100"
                    {{ $quantity <= 1 ? 'disabled' : '' }}
                >
                    <svg class="icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                </button>
                <span class="min-w-[1.75rem] text-center text-sm font-semibold text-gray-900">
                    {{ $quantity }}
                </span>
                <button
                    type="button"
                    wire:click="updateFurnitureQuantity('{{ $room }}', {{ $itemIndex }}, {{ $quantity + 1 }})"
                    class="btn btn-xs btn-ghost text-gray-600 hover:bg-gray-100"
                >
                    <svg class="icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                </button>
            </div>
        </div>

        <div class="flex flex-col items-end text-right">
            <div class="text-sm md:text-base font-bold text-gray-900">
                €{{ number_format($totalItemPrice, 2) }}
            </div>
            @if($quantity > 1)
                <div class="text-[11px] text-gray-500">
                    €{{ number_format($totalItemPrice / $quantity, 2) }} cad.
                </div>
            @endif
        </div>
    </div>
</div>
