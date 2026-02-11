@php
    $statePath = $getStatePath() ?? 'furniture_config';
    $record = $getRecord();
    
    // Prova prima a leggere dal record (modifica/visualizzazione)
    if ($record) {
        $furnitureConfig = $record->furniture_config ?? [];
    } else {
        // Se non c'è record (creazione), prova a leggere dal form state usando $get()
        try {
            $furnitureConfig = $get($statePath) ?? [];
        } catch (\Exception $e) {
            $furnitureConfig = [];
        }
    }
@endphp

<div class="space-y-4">
    @if(empty($furnitureConfig))
        <p class="text-sm text-gray-500 italic">Nessun mobile selezionato</p>
    @else
        @foreach($furnitureConfig as $roomName => $items)
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                <h4 class="font-semibold text-lg mb-3 text-gray-800">
                    {{ strtoupper(str_replace('_', ' ', $roomName)) }}
                </h4>
                <div class="space-y-3">
                    @foreach($items as $item)
                        <div class="bg-white rounded-lg p-3 border border-gray-200">
                            <div class="flex items-start gap-3">
                                @if(!empty($item['image']))
                                    <div class="flex-shrink-0">
                                        <img 
                                            src="{{ asset('images/' . $item['image']) }}" 
                                            alt="{{ $item['name'] ?? '' }}" 
                                            class="w-12 h-12 object-contain"
                                        />
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900">
                                        {{ $item['name'] ?? 'N/A' }}
                                    </div>
                                    @if(isset($item['selectedProperty']))
                                        <div class="text-sm text-gray-600 mt-1">
                                            <span class="font-medium">Proprietà:</span>
                                            @include('filament.schemas.components.furniture-property', ['property' => $item['selectedProperty']])
                                        </div>
                                    @endif
                                    <div class="flex gap-4 mt-2 text-sm text-gray-600">
                                        <span><strong>Quantità:</strong> {{ $item['quantity'] ?? 0 }}</span>
                                        @if(!empty($item['price']))
                                            <span><strong>Prezzo:</strong> €{{ number_format($item['price'] ?? 0, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</div>
