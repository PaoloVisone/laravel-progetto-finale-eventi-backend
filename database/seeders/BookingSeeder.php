<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Event;
use Faker\Generator as Faker;

class BookingSeeder extends Seeder
{
    public function run(Faker $faker): void
    {

        // Recupero tutti i record dalla tabella events
        $events = Event::all();

        $statuses = ['pending', 'confirmed', 'cancelled'];

        // Per ogni evento...
        foreach ($events as $event) {
            // Creo da 5 a 15 prenotazioni per ogni evento
            $bookingsCount = rand(5, 15);

            for ($i = 0; $i < $bookingsCount; $i++) {
                $status = $faker->randomElement($statuses);

                Booking::create([
                    // Creo una prenotazione per un evento specifico
                    'event_id' => $event->id,
                    'user_name' => $faker->name,
                    'user_email' => $faker->unique()->safeEmail,
                    'user_phone' => $faker->phoneNumber,
                    'tickets' => rand(1, 4),
                    'status' => $status,
                    'check_in' => $status === 'confirmed' ? $faker->boolean(30) : false,
                ]);
            }
        }
    }
}
