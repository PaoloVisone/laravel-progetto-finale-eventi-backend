@extends("layouts.events")

@section("title", "Gestione Eventi")

@section("content")

{{-- @dd($events); --}}

<div style="width: 90%; margin: 0 auto;">
    <table style="width: 100%; border-collapse: collapse; text-align: center; margin: 20px 0;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 10px; border: 1px solid #ddd;">ID</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Evento</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Descrizione</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Giorno</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Posizione</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Prezzo</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Posti</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding: 10px;">{{ $event->id }}</td>
                <td style="padding: 10px;">{{ $event->title }}</td>
                <td style="padding: 10px;">{{ $event->description }}</td>
                <td style="padding: 10px;">{{ $event->date_time }}</td>
                <td style="padding: 10px;">{{ $event->location }}</td>
                <td style="padding: 10px;">{{ $event->price }} €</td>
                <td style="padding: 10px;">{{ $event->capacity }}</td>
                <td style="padding: 10px;"><a href="{{ route('events.show', $event) }}" class="btn btn-outline-secondary">
            Dettagli
        </a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection