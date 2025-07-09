@extends("layouts.layout")

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0">
            Dettaglio Prenotazione
        </h2>
        <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
            Torna indietro
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $booking->user_name }}</h4>
                    <span class="badge bg-light text-primary fs-6">#{{ $booking->id }}</span>
                </div>
                <div class="card-body">
                    <p class="card-text fs-5">{{ $booking->user_email }}</p>
                    <div class="row g-3 mt-4">
                        <div class="col-md-6">
                            <div>
                                <div class="fw-semibold small text-muted">Evento</div>
                                <div>{{ $booking->event->title }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="fw-semibold small text-muted">Stato del pagamento</div>
                                <div class="
                                    @if($booking->payment_status == 'completed') text-success
                                    @elseif($booking->payment_status == 'failed') text-danger
                                    @elseif($booking->payment_status == 'refunded') text-info
                                    @else text-warning @endif">
                                    
                                    @if($booking->payment_status == 'pending')
                                        <i class="fas fa-clock me-1"></i> In attesa
                                    @elseif($booking->payment_status == 'completed')
                                        <i class="fas fa-check-circle me-1"></i> Completato
                                    @elseif($booking->payment_status == 'failed')
                                        <i class="fas fa-times-circle me-1"></i> Fallito
                                    @else
                                        <i class="fas fa-undo me-1"></i> Rimborsato
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="fw-semibold small text-muted">Numero di telefono</div>
                                <div>{{ $booking->user_phone ?? 'N/D' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="fw-semibold small text-muted">Tickets</div>
                                <div>{{ $booking->tickets }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="fw-semibold small text-muted">Metodo di pagamento</div>
                                <div>
                                    @if($booking->payment_method)
                                        {{ ucfirst(str_replace('_', ' ', $booking->payment_method)) }}
                                    @else
                                        Non specificato
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="fw-semibold small text-muted">Prezzo totale</div>
                                <div>€ {{ number_format($booking->total_price, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Azioni</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-warning">
                            Modifica
                        </a>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn btn-danger">
                            Elimina
                        </button>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informazioni</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Creato il:</strong> {{ $booking->created_at->format('d/m/Y H:i') }}</p>
                    <p class="mb-0"><strong>Ultima modifica:</strong> {{ $booking->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eliminazione -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Conferma eliminazione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Sei sicuro di voler eliminare definitivamente questa prenotazione?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                <form method="POST" action="{{ route('bookings.destroy', $booking) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Conferma eliminazione</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection