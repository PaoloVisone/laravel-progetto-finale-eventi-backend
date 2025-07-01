<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            // 1. Validazione
            $validated = $request->validate([
                'event_id' => 'required|integer|exists:events,id',
                'user_name' => 'required|string|max:255',
                'user_email' => 'required|email|max:255',
                'user_phone' => 'nullable|string|max:20',
                'tickets' => 'required|integer|min:1|max:10'
            ]);

            // 2. Transazione per consistenza dati
            return DB::transaction(function () use ($validated) {
                $event = Event::lockForUpdate()->findOrFail($validated['event_id']);

                // 3. Verifica disponibilità
                $availableSeats = $event->capacity - $event->booked_seats;
                if ($validated['tickets'] > $availableSeats) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Solo $availableSeats posti disponibili",
                        'available_seats' => $availableSeats
                    ], 422);
                }

                // 4. Calcola prezzo totale
                $totalPrice = $event->price * $validated['tickets'];

                // 5. Crea prenotazione
                $booking = new Booking();
                $booking->event_id = $validated['event_id'];
                $booking->user_name = $validated['user_name'];
                $booking->user_email = $validated['user_email'];
                $booking->user_phone = $validated['user_phone'] ?? null;
                $booking->tickets = $validated['tickets'];
                $booking->save();


                // 6. Aggiorna posti prenotati
                $event->increment('booked_seats', $validated['tickets']);

                // 7. Risposta al frontend (formato compatibile con React)
                return response()->json([
                    'success' => true,
                    'message' => 'Prenotazione confermata con successo!',
                    'data' => [
                        'booking' => [
                            'id' => $booking->id,
                            'user_name' => $booking->user_name,
                            'user_email' => $booking->user_email,
                            'tickets' => $booking->tickets,
                            'status' => $booking->status,
                            'total_price' => $totalPrice,
                            'created_at' => $booking->created_at
                        ],
                        'event' => [
                            'id' => $event->id,
                            'title' => $event->title,
                            'date' => $event->date,
                            'price' => $event->price,
                            'available_seats' => $event->capacity - $event->booked_seats,
                            'capacity' => $event->capacity
                        ]
                    ]
                ], 201);
            });
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dati non validi',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Errore creazione booking: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Log::error('Request data: ' . json_encode($request->all()));

            return response()->json([
                'success' => false,
                'message' => 'Errore durante la creazione della prenotazione. Riprova più tardi.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function index(): JsonResponse
    {
        try {
            $bookings = Booking::with(['event:id,title,date,price'])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $bookings
            ]);
        } catch (\Exception $e) {
            Log::error('Errore recupero bookings: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Errore nel recupero delle prenotazioni'
            ], 500);
        }
    }

    public function show(Booking $booking): JsonResponse
    {
        try {
            $booking->load(['event:id,title,date,price,capacity,booked_seats']);

            return response()->json([
                'success' => true,
                'data' => $booking
            ]);
        } catch (\Exception $e) {
            Log::error('Errore show booking: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Prenotazione non trovata'
            ], 404);
        }
    }

    public function update(Request $request, Booking $booking): JsonResponse
    {
        try {
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
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dati non validi',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Errore update booking: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Errore durante l\'aggiornamento'
            ], 500);
        }
    }

    public function destroy(Booking $booking): JsonResponse
    {
        try {
            DB::transaction(function () use ($booking) {
                // Ripristina i posti disponibili
                if ($booking->status === 'confirmed') {
                    $booking->event->decrement('booked_seats', $booking->tickets);
                }

                $booking->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Prenotazione eliminata con successo'
            ]);
        } catch (\Exception $e) {
            Log::error('Errore delete booking: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Errore durante l\'eliminazione'
            ], 500);
        }
    }
}
