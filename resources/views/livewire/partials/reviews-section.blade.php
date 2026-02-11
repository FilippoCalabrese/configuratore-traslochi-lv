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
