<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        if (array_key_exists("image", $data)) {
            $img_url = Storage::putFile("imgEvents", $data['image']);

            $newEvent->image = $img_url;
        }

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
    public function edit(event $event)
    {

        $categories = Category::all();

        return view('events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $data = $request->all();

        $event->title = $data["title"];
        $event->description = $data["description"];
        $event->date_time = $data["date_time"];
        $event->location = $data["location"];
        $event->price = $data["price"];
        $event->capacity = $data["capacity"];
        $event->category_id = $data["category_id"];

        if ($request->hasFile('image')) {
            // Elimina l'immagine precedente se esiste
            if ($event->image && Storage::exists($event->image)) {
                Storage::delete($event->image);
            }

            // Sovrascrivi con la nuova immagine
            $event->image = $request->file('image')->store('imgEvents');
        }

        $event->update();

        return redirect()->route("events.show", $event);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {

        if (!empty($event->image)) {
            Storage::delete($event->image);
        }

        $event->delete();

        return redirect()->route("events.index");
    }
}
