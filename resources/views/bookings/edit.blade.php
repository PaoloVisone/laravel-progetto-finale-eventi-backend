@extends("layouts.layout")

@section('content')
<div class="container-fluid my-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Modifica Prenotazioe</h1>
        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-primary">
            Torna indietro
        </a>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Modifica Prenotazione</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('bookings.update', $booking) }}" method="POST">
                        @csrf
                        @method("PUT")

                    <!-- Booking -->
                    <div class="mb-3">
                        <label for="event_id" class="form-label">Evento</label>
                        <select class="form-select @error('event_id') is-invalid @enderror" 
                                id="event_id" 
                                name="event_id" 
                                required>
                            <option value="">Seleziona un evento</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('event_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Nome Utente -->
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Nome</label>
                        <input type="text" 
                               class="form-control @error('user_name') is-invalid @enderror" 
                               id="user_name" 
                               name="user_name" 
                               value="{{ old('user_name') }}" 
                               required>
                        @error('user_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Email Utente -->
                    <div class="mb-3">
                        <label for="user_email" class="form-label">Email</label>
                        <input type="email" 
                               class="form-control @error('user_email') is-invalid @enderror" 
                               id="user_email" 
                               name="user_email" 
                               value="{{ old('user_email') }}" 
                               required>
                        @error('user_email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Telefono Utente -->
                    <div class="mb-3">
                        <label for="user_phone" class="form-label">Telefono</label>
                        <input type="tel" 
                               class="form-control @error('user_phone') is-invalid @enderror" 
                               id="user_phone" 
                               name="user_phone" 
                               value="{{ old('user_phone') }}" 
                               required>
                        @error('user_phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Numero Biglietti -->
                    <div class="mb-3">
                        <label for="tickets" class="form-label">Numero Biglietti</label>
                        <input type="number" 
                               class="form-control @error('tickets') is-invalid @enderror" 
                               id="tickets" 
                               name="tickets" 
                               value="{{ old('tickets') }}" 
                               min="1" 
                               required>
                        @error('tickets')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Campo Status (select) -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Stato Prenotazione</label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status">
                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>In attesa</option>
                            <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confermato</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancellato</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Campo Check-in (checkbox) -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" 
                               class="form-check-input @error('check_in') is-invalid @enderror" 
                               id="check_in" 
                               name="check_in" 
                               value="1" 
                               {{ old('check_in') ? 'checked' : '' }}>
                        <label class="form-check-label" for="check_in">Check-in effettuato</label>
                        @error('check_in')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                            Annulla
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Conferma Prenotazione
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection