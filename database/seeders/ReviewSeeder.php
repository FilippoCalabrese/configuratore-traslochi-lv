<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            ['name' => 'Martina Rossi', 'rating' => 5, 'review_date' => now()->subWeeks(2), 'text' => "Ho acquistato un trasloco da 20m3 e sono rimasta molto soddisfatta del servizio. Il prezzo è stato molto competitivo e il servizio impeccabile. Consigliato!", 'order' => 1],
            ['name' => 'Luca Bianchi', 'rating' => 5, 'review_date' => now()->subMonth(), 'text' => "Servizio eccellente! Il team è stato puntuale, professionale e molto attento nel trasporto dei mobili. Prezzo onesto e trasparente fin dall'inizio.", 'order' => 2],
            ['name' => 'Sofia Verdi', 'rating' => 5, 'review_date' => now()->subWeeks(3), 'text' => "Trasloco perfetto! Hanno gestito tutto con cura, anche gli oggetti più fragili sono arrivati intatti. Consiglio vivamente questa azienda.", 'order' => 3],
            ['name' => 'Marco Neri', 'rating' => 5, 'review_date' => now()->subWeek(), 'text' => "Ottima esperienza. Personale cortese e competente. Il preventivo online è stato preciso e non ci sono state sorprese. Molto soddisfatto!", 'order' => 4],
            ['name' => 'Giulia Ferrari', 'rating' => 5, 'review_date' => now()->subMonths(2), 'text' => "Servizio top! Hanno rispettato tutti gli orari e i mobili sono stati imballati con cura. Prezzo competitivo rispetto ad altre aziende. Raccomandato!", 'order' => 5],
            ['name' => 'Andrea Romano', 'rating' => 5, 'review_date' => now()->subWeeks(3), 'text' => "Trasloco da Firenze a Milano senza problemi. Il team è stato professionale e attento. Tutto è arrivato puntuale e in perfette condizioni.", 'order' => 6],
            ['name' => 'Elena Conti', 'rating' => 5, 'review_date' => now()->subMonth(), 'text' => "Fantastico! Hanno gestito il trasloco della mia cucina con estrema cura. Nessun graffio, tutto perfetto. Prezzo onesto e servizio eccellente.", 'order' => 7],
            ['name' => 'Davide Moretti', 'rating' => 5, 'review_date' => now()->subWeeks(2), 'text' => "Servizio impeccabile dall'inizio alla fine. Preventivo chiaro, personale professionale e puntuale. Consiglio a tutti!", 'order' => 8],
            ['name' => 'Chiara Esposito', 'rating' => 5, 'review_date' => now()->subWeek(), 'text' => "Ottima azienda! Hanno trasportato i miei mobili antichi con la massima cura. Personale esperto e attento ai dettagli. Molto soddisfatta!", 'order' => 9],
            ['name' => 'Francesco Ricci', 'rating' => 5, 'review_date' => now()->subWeeks(3), 'text' => "Trasloco perfetto! Prezzo competitivo, servizio veloce e professionale. Hanno rispettato tutti gli accordi. Consigliatissimo!", 'order' => 10],
            ['name' => 'Alessia Marchetti', 'rating' => 5, 'review_date' => now()->subMonth(), 'text' => "Servizio eccellente! Il team è stato molto attento e professionale. Tutto è arrivato intatto e nei tempi previsti. Prezzo onesto.", 'order' => 11],
            ['name' => 'Roberto Lombardi', 'rating' => 5, 'review_date' => now()->subWeeks(2), 'text' => "Trasloco da sogno! Personale cortese, puntuale e competente. Hanno gestito tutto con cura, anche gli oggetti più delicati. Top!", 'order' => 12],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
