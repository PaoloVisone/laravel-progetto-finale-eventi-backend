<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('category')->orderBy('date_time', 'asc')->get();

        // dd($events);

        return response()->json(
            [
                "success" => true,
                "data" => $events
            ]
        );
    }

    public function show(Event $event)
    {

        $event = Event::with('category', 'bookings')->find($event->id);

        // dd($event);

        return response()->json([
            "success" => true,
            "data" => $event,
        ]);
    }
}
