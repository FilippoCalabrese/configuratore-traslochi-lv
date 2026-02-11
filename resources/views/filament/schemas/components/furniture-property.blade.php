@php
    $property = $property ?? [];
@endphp

<span>{{ $property['name'] ?? '' }}</span>
@if(isset($property['selectedProperty']))
    <span class="text-gray-500">→</span>
    @include('filament.schemas.components.furniture-property', ['property' => $property['selectedProperty']])
@endif
