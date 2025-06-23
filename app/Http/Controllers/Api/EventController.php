<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {

        $events = Event::all();

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

        $event->load('category', "bookings");

        // dd($event);

        return response()->json([
            "success" => true,
            "data" => $event
        ]);
    }
}
