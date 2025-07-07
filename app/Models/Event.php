<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Metodo per verificare la disponibilità
    public function getAvailableSeatsAttribute()
    {
        return $this->capacity - $this->booked_seats;
    }

    // Metodo per prenotare posti
    public function bookSeats($quantity)
    {
        $this->increment('booked_seats', $quantity);
        return $this;
    }
}
