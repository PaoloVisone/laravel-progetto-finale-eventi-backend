<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|integer|exists:events,id',
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255',
            'user_phone' => 'nullable|string|max:20',
            'tickets' => 'required|integer|min:1|max:80'
        ]);

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
        $booking->save();

        // Aggiorna posti prenotati
        $event->bookSeats($request->tickets);

        return response()->json([
            'success' => true,
            'message' => 'Prenotazione confermata con successo!',
            'data' => [
                'booking' => $booking,
                'event' => $event->fresh()
            ]
        ], 201);
    }

    public function index()
    {
        $bookings = Booking::with('event')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }

    public function show(Booking $booking)
    {
        $booking->load('event');

        return response()->json([
            'success' => true,
            'data' => $booking
        ]);
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'sometimes|in:pending,confirmed,cancelled',
            'check_in' => 'sometimes|boolean'
        ]);

        $booking->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Prenotazione aggiornata con successo',
            'data' => $booking->load('event')
        ]);
    }

    public function destroy(Booking $booking)
    {
        // Ripristina posti se confermata
        if ($booking->status === 'confirmed') {
            $booking->event->decrement('booked_seats', $booking->tickets);
        }

        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Prenotazione eliminata con successo'
        ]);
    }
}
