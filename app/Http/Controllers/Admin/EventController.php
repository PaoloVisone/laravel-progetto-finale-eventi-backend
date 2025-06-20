<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $events = Event::all();
        $events = Event::orderBy('created_at', 'desc')->paginate(10);
        // dd($events);
        return view("events.index", compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Recupera tutte le categorie dal database
        $categories = Category::all();

        // Passa le categorie alla view
        return view('events.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $newEvent = new Event();

        $newEvent->title = $data["title"];
        $newEvent->description = $data["description"];
        $newEvent->date_time = $data["date_time"];
        $newEvent->location = $data["location"];
        $newEvent->price = $data["price"];
        $newEvent->capacity = $data["capacity"];
        $newEvent->category_id = $data["category_id"];

        $newEvent->save();

        return redirect()->route("events.show", $newEvent);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('category');
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
