@extends("layouts.layout")

@section('content')
<div class="container-fluid my-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Crea Prenotazione</h1>
        <a href="{{ route('bookings.index') }}" class="btn btn-primary">
            Torna indietro
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Nuova Prenotazione</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    
                    <!-- Evento -->
                    <div class="mb-3">
                        <label for="event_id" class="form-label">Evento</label>
                        <select class="form-select @error('event_id') is-invalid @enderror" 
                                id="event_id" 
                                name="event_id" 
                                required>
                            <option value="">Seleziona un evento</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }} (€{{ number_format($event->price, 2) }})
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
                               value="{{ old('user_phone') }}">
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
                               value="{{ old('tickets', 1) }}" 
                               min="1" 
                               max="10"
                               required>
                        @error('tickets')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Metodo di Pagamento (nascosto inizialmente) -->
                    <div class="mb-3 d-none payment-method-field">
                        <label for="payment_method" class="form-label">Metodo di Pagamento</label>
                        <select class="form-select @error('payment_method') is-invalid @enderror" 
                                id="payment_method" 
                                name="payment_method">
                            <option value="">Seleziona metodo</option>
                            <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Carta di Credito</option>
                            <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bonifico Bancario</option>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Contanti</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Stato Pagamento (nascosto, impostato automaticamente a 'pending') -->
                    <input type="hidden" name="payment_status" value="pending">

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

@section('scripts')
<script>
    // Mostra/nascondi il metodo di pagamento in base alla selezione
    document.addEventListener('DOMContentLoaded', function() {
        const eventSelect = document.getElementById('event_id');
        const paymentMethodField = document.querySelector('.payment-method-field');
    
    });
</script>
@endsection

@endsection