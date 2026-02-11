@php
$reviews = [
    ['id' => 1, 'name' => 'Martina Rossi', 'avatar' => 'MR', 'rating' => 5, 'date' => '2 settimane fa', 'text' => "Ho acquistato un trasloco da 20m3 e sono rimasta molto soddisfatta del servizio. Il prezzo è stato molto competitivo e il servizio impeccabile. Consigliato!"],
    ['id' => 2, 'name' => 'Luca Bianchi', 'avatar' => 'LB', 'rating' => 5, 'date' => '1 mese fa', 'text' => "Servizio eccellente! Il team è stato puntuale, professionale e molto attento nel trasporto dei mobili. Prezzo onesto e trasparente fin dall'inizio."],
    ['id' => 3, 'name' => 'Sofia Verdi', 'avatar' => 'SV', 'rating' => 5, 'date' => '3 settimane fa', 'text' => "Trasloco perfetto! Hanno gestito tutto con cura, anche gli oggetti più fragili sono arrivati intatti. Consiglio vivamente questa azienda."],
    ['id' => 4, 'name' => 'Marco Neri', 'avatar' => 'MN', 'rating' => 5, 'date' => '1 settimana fa', 'text' => "Ottima esperienza. Personale cortese e competente. Il preventivo online è stato preciso e non ci sono state sorprese. Molto soddisfatto!"],
    ['id' => 5, 'name' => 'Giulia Ferrari', 'avatar' => 'GF', 'rating' => 5, 'date' => '2 mesi fa', 'text' => "Servizio top! Hanno rispettato tutti gli orari e i mobili sono stati imballati con cura. Prezzo competitivo rispetto ad altre aziende. Raccomandato!"],
    ['id' => 6, 'name' => 'Andrea Romano', 'avatar' => 'AR', 'rating' => 5, 'date' => '3 settimane fa', 'text' => "Trasloco da Firenze a Milano senza problemi. Il team è stato professionale e attento. Tutto è arrivato puntuale e in perfette condizioni."],
    ['id' => 7, 'name' => 'Elena Conti', 'avatar' => 'EC', 'rating' => 5, 'date' => '1 mese fa', 'text' => "Fantastico! Hanno gestito il trasloco della mia cucina con estrema cura. Nessun graffio, tutto perfetto. Prezzo onesto e servizio eccellente."],
    ['id' => 8, 'name' => 'Davide Moretti', 'avatar' => 'DM', 'rating' => 5, 'date' => '2 settimane fa', 'text' => "Servizio impeccabile dall'inizio alla fine. Preventivo chiaro, personale professionale e puntuale. Consiglio a tutti!"],
    ['id' => 9, 'name' => 'Chiara Esposito', 'avatar' => 'CE', 'rating' => 5, 'date' => '1 settimana fa', 'text' => "Ottima azienda! Hanno trasportato i miei mobili antichi con la massima cura. Personale esperto e attento ai dettagli. Molto soddisfatta!"],
    ['id' => 10, 'name' => 'Francesco Ricci', 'avatar' => 'FR', 'rating' => 5, 'date' => '3 settimane fa', 'text' => "Trasloco perfetto! Prezzo competitivo, servizio veloce e professionale. Hanno rispettato tutti gli accordi. Consigliatissimo!"],
    ['id' => 11, 'name' => 'Alessia Marchetti', 'avatar' => 'AM', 'rating' => 5, 'date' => '1 mese fa', 'text' => "Servizio eccellente! Il team è stato molto attento e professionale. Tutto è arrivato intatto e nei tempi previsti. Prezzo onesto."],
    ['id' => 12, 'name' => 'Roberto Lombardi', 'avatar' => 'RL', 'rating' => 5, 'date' => '2 settimane fa', 'text' => "Trasloco da sogno! Personale cortese, puntuale e competente. Hanno gestito tutto con cura, anche gli oggetti più delicati. Top!"],
];

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
            @foreach(array_merge($reviews, $reviews, $reviews) as $index => $review)
                <div class="bg-white rounded-lg border border-gray-200 p-5 shadow-sm hover:shadow-lg transition-all duration-200 hover:border-gray-300 flex-shrink-0 w-[320px] md:w-[350px]">
                    <div class="flex items-start gap-3 mb-3">
                        <div class="{{ $avatarColors[ord($review['avatar'][0]) % count($avatarColors)] }} w-10 h-10 rounded-full flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                            {{ $review['avatar'] }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="font-semibold text-sm text-gray-900 truncate">{{ $review['name'] }}</h3>
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
                                        <svg class="icon-sm {{ $i < $review['rating'] ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $review['date'] }}</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-700 leading-relaxed mt-3">{{ $review['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
