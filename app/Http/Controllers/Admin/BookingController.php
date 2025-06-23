<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::all();

        // dd($bookings);

        return view("bookings.index", compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::all();
        return view('bookings.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $data = $request->all();

        $newBooking = new Booking();

        $newBooking->event_id = $data["event_id"];
        $newBooking->user_name = $data["user_name"];
        $newBooking->user_email = $data["user_email"];
        $newBooking->user_phone = $data["user_phone"];
        $newBooking->tickets = $data["tickets"];
        $newBooking->status = 'pending';
        $newBooking->check_in = false;

        $newBooking->save();

        return redirect()->route("bookings.show", $newBooking);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load('event');
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $events = Event::all();

        return view('bookings.edit', compact('booking', 'events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $data = $request->all();

        $booking = new Booking();

        $booking->event_id = $data["event_id"];
        $booking->user_name = $data["user_name"];
        $booking->user_email = $data["user_email"];
        $booking->user_phone = $data["user_phone"];
        $booking->tickets = $data["tickets"];
        $booking->status = 'pending';
        $booking->check_in = false;

        $booking->save();

        return redirect()->route("bookings.show", $booking);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route("bookings.index");
    }
}
