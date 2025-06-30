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
                                <div>{{$booking->event->title}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                              <div class="fw-semibold small text-muted">Stato della prenotazione</div>
                                    <div class="
                                        @if($booking->status == 'confirmed') text-success
                                        @elseif($booking->status == 'cancelled') text-danger
                                        @else text-warning @endif">

                                        @if($booking->status == 'pending')
                                            <i class="fas fa-clock me-1"></i> In attesa
                                        @elseif($booking->status == 'confirmed')
                                            <i class="fas fa-check-circle me-1"></i> Confermato
                                        @else
                                            <i class="fas fa-times-circle me-1"></i> Cancellato
                                        @endif
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="fw-semibold small text-muted">Numero di telefono</div>
                                <div>{{ $booking->user_phone }} </div>
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
                                <div class="fw-semibold small text-muted">Check-in</div>
                                  <div class="{{ $booking->check_in ? 'text-success' : 'text-danger' }}">
                                                {{ $booking->check_in ? 'Completato' : 'In attesa' }}
                                  </div>
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
                        <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-warning" aria-disabled="true">
                            Modifica
                        </a>
                        
            <button type="submit" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-danger btn-delete">
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
                    <p class="mb-2"><strong>Creato il:</strong> {{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y H:i') }}</p>
                    <p class="mb-0"><strong>Ultima modifica:</strong> {{ \Carbon\Carbon::parse($booking->updated_at)->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">STAI ELIMINADO LA PRENOTAZIONE</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Eliminare definitivamente la prenotazione?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
        <form method="POST" action="{{ route('bookings.destroy', $booking) }}" class="d-grid gap-2">
            @csrf
            @method('DELETE')
            <input type="submit" class="btn btn-danger" value="Elimina">
        </form>
      </div>
    </div>
  </div>
</div>
@endsection