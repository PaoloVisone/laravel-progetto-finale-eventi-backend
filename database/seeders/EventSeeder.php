<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Category;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'Concerto di Jazz al Tramonto',
                'description' => 'Una serata magica con i migliori musicisti jazz italiani. Atmosfera intima e suggestiva con vista panoramica sulla città.',
                'date_time' => Carbon::now()->addDays(15)->setTime(20, 30),
                'location' => 'Stadio San Siro, Milano',
                'price' => 45.00,
                'capacity' => 150,
                'category_id' => Category::where('slug', 'concerti')->first()->id
            ],
            [
                'title' => 'Partita di Calcio Serie A',
                'description' => 'Match emozionante tra due squadre della massima serie. Atmosfera da stadio garantita!',
                'date_time' => Carbon::now()->addDays(8)->setTime(18, 00),
                'location' => 'Stadio Olimpico, Roma',
                'price' => 25.00,
                'capacity' => 500,
                'category_id' => Category::where('slug', 'sport')->first()->id
            ],
            [
                'title' => 'Spettacolo Teatrale: "La Tempesta"',
                'description' => 'Adattamento moderno del capolavoro di Shakespeare. Regia di Marco Rossi con scenografie innovative.',
                'date_time' => Carbon::now()->addDays(12)->setTime(21, 00),
                'location' => 'Teatro alla Scala, Milano',
                'price' => 35.00,
                'capacity' => 200,
                'category_id' => Category::where('slug', 'teatro')->first()->id
            ],
            [
                'title' => 'Conferenza: "Il Futuro del Lavoro"',
                'description' => 'Esperti internazionali discutono l\'evoluzione del mondo del lavoro nell\'era digitale.',
                'date_time' => Carbon::now()->addDays(5)->setTime(14, 30),
                'location' => 'MiCo - Milano Congressi, Milano',
                'price' => 15.00,
                'capacity' => 300,
                'category_id' => Category::where('slug', 'conferenze')->first()->id
            ],
            [
                'title' => 'Festival della Musica Elettronica',
                'description' => 'Due giorni di musica elettronica con DJ internazionali. Food truck e area relax inclusi.',
                'date_time' => Carbon::now()->addDays(20)->setTime(16, 00),
                'location' => 'Fortezza da Basso, Firenze',
                'price' => 60.00,
                'capacity' => 1000,
                'category_id' => Category::where('slug', 'festival')->first()->id
            ],
            [
                'title' => 'Mostra: "Arte Contemporanea Italiana"',
                'description' => 'Esposizione delle opere più significative dell\'arte italiana contemporanea.',
                'date_time' => Carbon::now()->addDays(3)->setTime(10, 00),
                'location' => 'MAXXI, Torino',
                'price' => 12.00,
                'capacity' => 80,
                'category_id' => Category::where('slug', 'arte')->first()->id
            ],
            [
                'title' => 'Concerto Rock: "The Italian Legends"',
                'description' => 'Tributo alle migliori band rock italiane degli anni \'80 e \'90.',
                'date_time' => Carbon::now()->addDays(18)->setTime(21, 30),
                'location' => 'Arena di Verona, Verona',
                'price' => 30.00,
                'capacity' => 400,
                'category_id' => Category::where('slug', 'concerti')->first()->id
            ],
            [
                'title' => 'Torneo di Tennis Amatoriale',
                'description' => 'Competizione aperta a tutti i livelli. Premi per i vincitori e buffet finale.',
                'date_time' => Carbon::now()->addDays(10)->setTime(9, 00),
                'location' => 'PalaLottomatica, Roma',
                'price' => 20.00,
                'capacity' => 64,
                'category_id' => Category::where('slug', 'sport')->first()->id
            ]
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
