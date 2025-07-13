<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|integer|exists:events,id',
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255',
            'user_phone' => 'nullable|string|max:20',
            'tickets' => 'required|integer|min:1|max:80',
            'payment_method' => 'nullable|in:credit_card,paypal,bank_transfer'
        ]);
        // Se l'azione non va a buon fine blocca 
        $event = Event::findOrFail($request->event_id);

        // Verifica disponibilità
        if ($request->tickets > $event->available_seats) {
            return response()->json([
                'success' => false,
                'message' => "Solo {$event->available_seats} posti disponibili",
                'available_seats' => $event->available_seats
            ], 422);
        }

        // Crea prenotazione
        $booking = new Booking();
        $booking->event_id = $request->event_id;
        $booking->user_name = $request->user_name;
        $booking->user_email = $request->user_email;
        $booking->user_phone = $request->user_phone;
        $booking->tickets = $request->tickets;
        $booking->total_price = $event->price * $request->tickets;
        $booking->payment_status = 'pending';
        $booking->payment_method = $request->payment_method;
        $booking->save();

        // Aggiorna posti prenotati
        $event->bookSeats($request->tickets);

        return response()->json([
            'success' => true,
            'message' => 'Prenotazione confermata con successo!',
            'data' => $booking->load('event')
        ], 201);
    }

    public function index()
    {
        // Prendi Prenotazioni con eventi e ordinate dall'ultima e restituisci collation
        $bookings = Booking::with('event')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }

    public function show(Booking $booking)
    {
        return response()->json([
            'success' => true,
            'data' => $booking->load('event')
        ]);
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'payment_status' => 'sometimes|in:pending,completed,failed,refunded',
            'payment_method' => 'sometimes|in:credit_card,paypal,bank_transfer'
        ]);

        $booking->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Prenotazione aggiornata con successo',
            'data' => $booking
        ]);
    }
    // Eventualità di cancellazione prenotazione
    public function destroy(Booking $booking)
    {
        // Aggiorna i posti rimasti se pagamento completato
        if ($booking->payment_status === 'completed') {
            $booking->event->decrement('booked_seats', $booking->tickets);
        }

        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Prenotazione eliminata con successo'
        ]);
    }
}
