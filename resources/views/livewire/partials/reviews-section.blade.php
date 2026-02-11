@php
use App\Models\Review;
$reviews = Review::active()->ordered()->get();
$avatarColors = ['bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-pink-500', 'bg-indigo-500', 'bg-red-500', 'bg-yellow-500', 'bg-teal-500'];
@endphp

<div class="w-full max-w-6xl mx-auto py-6">
    <h2 class="text-2xl font-bold mb-8 text-center text-gray-900">
        Cosa dicono i nostri clienti
    </h2>
    <div
        x-data="{ isPaused: false }"
        x-init="
            const container = $el.querySelector('.scroll-container');
            let animationFrameId;
            let lastTimestamp = performance.now();
            const scrollSpeed = 1;
            const scrollInterval = 16;

            function scroll(timestamp) {
                if (!isPaused) {
                    const delta = timestamp - lastTimestamp;
                    lastTimestamp = timestamp;
                    container.scrollLeft += (scrollSpeed * delta) / scrollInterval;
                    if (container.scrollLeft >= container.scrollWidth - container.clientWidth) {
                        container.scrollLeft = 0;
                    }
                } else {
                    lastTimestamp = timestamp;
                }
                animationFrameId = requestAnimationFrame(scroll);
            }
            animationFrameId = requestAnimationFrame(scroll);
        "
    >
        <div
            class="scroll-container flex gap-4 overflow-x-hidden scrollbar-hide"
            @mouseenter="isPaused = true"
            @mouseleave="isPaused = false"
            style="scroll-behavior: auto;"
        >
            @foreach(array_merge($reviews->all(), $reviews->all(), $reviews->all()) as $index => $review)
                <div class="bg-white rounded-lg border border-gray-200 p-5 shadow-sm hover:shadow-lg transition-all duration-200 hover:border-gray-300 flex-shrink-0 w-[320px] md:w-[350px]">
                    <div class="flex items-start gap-3 mb-3">
                        <div class="{{ $avatarColors[ord(substr($review->name, 0, 1)) % count($avatarColors)] }} w-10 h-10 rounded-full flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                            {{ $review->avatar }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="font-semibold text-sm text-gray-900 truncate">{{ $review->name }}</h3>
                                <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                </svg>
                            </div>
                            <div class="flex items-center gap-2 mb-1">
                                <div class="flex items-center gap-0.5">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="icon-sm {{ $i < $review->rating ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $review->date }}</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-700 leading-relaxed mt-3">{{ $review->text }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
