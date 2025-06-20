@extends("layouts.events")

{{-- @section('title', 'Dettaglio Evento') --}}

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
                        <button class="btn btn-danger disabled" aria-disabled="true">
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
@endsection