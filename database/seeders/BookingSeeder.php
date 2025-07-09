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

        $paymentStatuses = ['pending', 'completed', 'failed', 'refunded'];
        $paymentMethods = ['credit_card', 'paypal', 'bank_transfer'];

        // Per ogni evento...
        foreach ($events as $event) {
            // Creo da 5 a 15 prenotazioni per ogni evento
            $bookingsCount = rand(5, 15);

            for ($i = 0; $i < $bookingsCount; $i++) {
                $tickets = rand(1, 4);
                $paymentStatus = $faker->randomElement($paymentStatuses);
                $isCompleted = $paymentStatus === 'completed';

                Booking::create([
                    'event_id' => $event->id,
                    'user_name' => $faker->name,
                    'user_email' => $faker->unique()->safeEmail,
                    'user_phone' => $faker->phoneNumber,
                    'tickets' => $tickets,
                    'payment_method' => $isCompleted ? $faker->randomElement($paymentMethods) : null,
                    'total_price' => $event->price * $tickets,
                    'payment_status' => $paymentStatus,
                ]);
            }
        }
    }
}
