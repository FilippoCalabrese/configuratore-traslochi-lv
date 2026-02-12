@props(['currentStep' => 1, 'totalSteps' => 6])

@php
    $progress = ($currentStep / $totalSteps) * 100;
@endphp

<div class="bg-base-100 border-b w-full">
    <div class="flex items-center gap-6 md:gap-8 p-4">
        <div class="flex items-center gap-2 w-[70px] flex-shrink-0">
            <img src="{{ asset('logo.png') }}" class="w-full h-auto" alt="Logo" />
        </div>
        <div class="flex-1 min-w-0">
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
    </div>
</div>
