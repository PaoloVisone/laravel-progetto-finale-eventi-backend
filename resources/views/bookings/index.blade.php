@extends("layouts.layout")

@section("content")

{{-- NAVBAR --}}
<div class="container-fluid my-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Gestione Prenotazioni</h1>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary">
            Aggiungi Prenotazione
        </a>
    </div>
</div>

{{-- TABLE --}}
<div style="width: 100%; margin: 0 auto;">
    <table style="width: 100%; border-collapse: collapse; text-align: center; margin: 20px 0;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 10px; border: 1px solid #ddd;">ID</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Username</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Email</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Telefono</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Tickets</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Prezzo Totale</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Metodo Pagamento</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Stato Pagamento</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Azioni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $booking)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding: 10px;">{{ $booking->id }}</td>
                <td style="padding: 10px;">{{ $booking->user_name }}</td>
                <td style="padding: 10px;">{{ $booking->user_email }}</td>
                <td style="padding: 10px;">{{ $booking->user_phone }}</td>
                <td style="padding: 10px;">{{ $booking->tickets }}</td>
                <td style="padding: 10px;">€ {{ number_format($booking->total_price, 2) }}</td>
                <td style="padding: 10px;">
                    @if($booking->payment_method)
                        {{ ucfirst(str_replace('_', ' ', $booking->payment_method)) }}
                    @else
                        Non specificato
                    @endif
                </td>
                <td style="padding: 10px;" class="
                    @if($booking->payment_status == 'completed') text-success
                    @elseif($booking->payment_status == 'failed') text-danger
                    @elseif($booking->payment_status == 'refunded') text-info
                    @else text-warning @endif">
                    
                    @if($booking->payment_status == 'pending')
                        In attesa
                    @elseif($booking->payment_status == 'completed')
                        Completato
                    @elseif($booking->payment_status == 'failed')
                        Fallito
                    @else
                        Rimborsato
                    @endif
                </td>
                <td style="padding: 10px;">
                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-secondary">
                        Dettagli
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection