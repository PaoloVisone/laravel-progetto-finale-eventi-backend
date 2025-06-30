@extends("layouts.layout")

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0">
            Dettaglio Evento
        </h2>
        <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
            Torna indietro
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $event->title }}</h4>
                    <span class="badge bg-light text-primary fs-6">#{{ $event->id }}</span>
                </div>
                <div class="card-body">
                    <p class="card-text fs-5">{{ $event->description }}</p>
                    <div class="row g-3 mt-4">
                        <div class="col-md-6">
                            <div>
                                <div class="fw-semibold small text-muted">Data e Ora</div>
                                <div>{{$event->date_time}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="fw-semibold small text-muted">Posizione</div>
                                <div>{{ $event->location }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="fw-semibold small text-muted">Prezzo</div>
                                <div>{{ number_format($event->price, 2) }} €</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="fw-semibold small text-muted">Posti disponibili</div>
                                <div>{{ $event->capacity }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div>
                                <div class="fw-semibold small text-muted">Categoria</div>
                                <div>{{ $event->category->name }}</div>
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
                        <a href="{{ route('events.edit', $event) }}" class="btn btn-warning" aria-disabled="true">
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
                    <p class="mb-2"><strong>Creato il:</strong> {{ \Carbon\Carbon::parse($event->created_at)->format('d/m/Y H:i') }}</p>
                    <p class="mb-0"><strong>Ultima modifica:</strong> {{ \Carbon\Carbon::parse($event->updated_at)->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
    
    @if($event->image)
    <div class="row g-4">
        <img src="{{ asset("storage/". $event->image) }}" alt="{{ $event->title }}">
    </div>
    @endif
    
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">STAI ELIMINADO L'EVENTO</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Eliminare definitivamente l'evento?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
        <form method="POST" action="{{ route('events.destroy', $event) }}" class="d-grid gap-2">
            @csrf
            @method('DELETE')
            <input type="submit" class="btn btn-danger" value="Elimina">
        </form>
      </div>
    </div>
  </div>
</div>
@endsection