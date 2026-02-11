@props(['currentStep' => 1, 'totalSteps' => 7])

@php
    $progress = ($currentStep / $totalSteps) * 100;
@endphp

<div class="w-full px-2 md:px-4">
    <div class="flex items-center justify-between mb-2">
        <span class="text-xs md:text-sm font-medium text-gray-600">
            Step {{ $currentStep }} di {{ $totalSteps }}
        </span>
        <span class="text-xs md:text-sm font-semibold text-primary">
            {{ round($progress) }}%
        </span>
    </div>
    <div class="w-full bg-gray-200 h-2 md:h-3 rounded-full overflow-hidden shadow-inner">
        <div
            class="bg-primary h-full rounded-full transition-all duration-700 ease-out relative overflow-hidden"
            style="width: {{ $progress }}%"
        >
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-shimmer"></div>
        </div>
    </div>
</div>
