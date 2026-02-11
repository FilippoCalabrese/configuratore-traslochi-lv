@if(isset($nestedItem['selectedProperty']))
    <ul class="list-disc md:pl-8 pl-2 mt-1">
        <li>
            <div class="font-semibold text-sm md:text-base">
                {{ $nestedItem['selectedProperty']['name'] ?? '' }}
            </div>
            @include('livewire.partials.furniture-sub-properties', ['nestedItem' => $nestedItem['selectedProperty']])
        </li>
    </ul>
@endif
