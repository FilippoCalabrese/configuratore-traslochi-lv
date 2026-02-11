@php
    $levels = $selection['levels'] ?? [];
    $firstLevel = $levels[0] ?? ['name' => '', 'quantity' => 1];
@endphp

<div
    class="flex w-full flex-col gap-2"
    x-data="searchableSelect({
        index: {{ $index }},
        selectedName: @js($firstLevel['name'] ?? ''),
        selectedDisplay: @js(!empty($firstLevel['name']) ? ($firstLevel['name'] . (isset($firstLevel['source_room']) ? ' (' . $firstLevel['source_room'] . ')' : '')) : ''),
        allOptions: @js($allFurnitureOptions),
    })"
>
    {{-- Level 0: Searchable Select --}}
    <div class="flex items-center gap-4">
        @if(!empty($firstLevel['image']))
            <span class="text-gray-500 font-bold text-lg pointer-events-none">
                <img src="{{ asset('images/' . $firstLevel['image']) }}" alt="{{ $firstLevel['name'] }}" class="w-[50px] h-auto" />
            </span>
        @endif

        <div class="flex flex-col w-full">
            <div class="relative w-full" @click.outside="isOpen = false">
                <div
                    class="select select-bordered w-full rounded-2xl h-12 cursor-pointer flex items-center"
                    @click="isOpen = !isOpen"
                >
                    <div class="flex-1 flex items-center gap-2">
                        <svg class="icon-sm text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <span :class="selectedName ? 'text-gray-900' : 'text-gray-400'">
                            <template x-if="selectedName">
                                <span x-text="selectedDisplay"></span>
                            </template>
                            <template x-if="!selectedName">
                                <span>Cerca e seleziona un mobile...</span>
                            </template>
                        </span>
                    </div>
                    <svg class="icon-sm text-gray-400 transition-transform" :class="{ 'rotate-90': isOpen }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </div>

                <div x-show="isOpen" x-cloak class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-hidden">
                    <div class="p-2 border-b border-gray-200 sticky top-0 bg-white">
                        <div class="relative">
                            <svg class="absolute left-2 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            <input
                                type="text"
                                class="input input-bordered input-soft h-10 w-full pl-8"
                                placeholder="Cerca mobile..."
                                x-model="searchTerm"
                                @click.stop
                                x-ref="searchInput"
                            />
                        </div>
                    </div>
                    <div class="overflow-y-auto max-h-48">
                        <template x-for="(option, optIdx) in filteredOptions" :key="optIdx">
                            <div
                                class="px-4 py-2 hover:bg-gray-100 cursor-pointer flex items-center gap-2"
                                @click="selectOption(option)"
                            >
                                <template x-if="option.image">
                                    <img :src="'/images/' + option.image" :alt="option.name" class="icon-xl object-contain" />
                                </template>
                                <div class="flex-1">
                                    <div class="font-medium text-sm" x-text="option.displayName"></div>
                                    <div class="text-xs text-gray-500" x-text="option.room"></div>
                                </div>
                            </div>
                        </template>
                        <template x-if="filteredOptions.length === 0">
                            <div class="px-4 py-2 text-gray-500 text-sm text-center">
                                Nessun risultato trovato
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <button
            type="button"
            wire:click="removeSelection({{ $index }})"
            class="btn btn-outline border-black/20 hover:bg-gray-100 hover:border-black/20 hover:text-black"
        >
            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
        </button>
    </div>

    {{-- Sub-levels (properties) --}}
    @if(!empty($firstLevel['properties']) && !empty($firstLevel['name']))
        @if(!empty($firstLevel['label']))
            <label class="font-bold mt-2">{{ $firstLevel['label'] }}</label>
        @endif

        @for($level = 1; $level < count($levels); $level++)
            @php
                $currentLevel = $levels[$level] ?? ['name' => ''];
                $parentLevel = $levels[$level - 1] ?? [];
                $options = $parentLevel['properties'] ?? [];
                $parentLabel = $parentLevel['label'] ?? ($level === 1 ? ($firstLevel['label'] ?? null) : null);
            @endphp

            @if(!empty($options))
                <div class="flex items-center gap-4">
                    @if($level > 0)
                        <span class="text-gray-500 sm:flex hidden opacity-0 pointer-events-none">------</span>
                    @endif
                    <div class="flex flex-col w-full">
                        <select
                            class="select select-bordered w-full rounded-2xl h-11"
                            wire:change="updateSelection({{ $index }}, {{ $level }}, $event.target.value)"
                        >
                            <option value="">Seleziona...</option>
                            @foreach($options as $option)
                                <option value="{{ $option['name'] }}" {{ ($currentLevel['name'] ?? '') === $option['name'] ? 'selected' : '' }}>
                                    {{ $option['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if(!empty($currentLevel['label']) && $currentLevel['label'] !== $parentLabel)
                    <label class="font-bold">
                        <span class="text-gray-500 opacity-0 sm:flex hidden pointer-events-none">--------</span>
                        {{ $currentLevel['label'] }}
                    </label>
                @endif
            @endif
        @endfor

        {{-- Show next level if current last level has properties --}}
        @php
            $lastLevel = end($levels);
            $beforeLast = prev($levels) ?: null;
            $beforeLastLabel = $beforeLast['label'] ?? ($firstLevel['label'] ?? null);
        @endphp
        @if(!empty($lastLevel['properties']) && !empty($lastLevel['name']))
            @if(!empty($lastLevel['label']) && $lastLevel['label'] !== $beforeLastLabel)
                <label class="font-bold">
                    <span class="text-gray-500 opacity-0 sm:flex hidden pointer-events-none">--------</span>
                    {{ $lastLevel['label'] }}
                </label>
            @endif
            <div class="flex items-center gap-4">
                <span class="text-gray-500 sm:flex hidden opacity-0 pointer-events-none">------</span>
                <div class="flex flex-col w-full">
                    <select
                        class="select select-bordered w-full rounded-2xl h-11"
                        wire:change="updateSelection({{ $index }}, {{ count($levels) }}, $event.target.value)"
                    >
                        <option value="">Seleziona...</option>
                        @foreach($lastLevel['properties'] as $option)
                            <option value="{{ $option['name'] }}">{{ $option['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
    @endif
</div>

