<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingProve extends Model
{
    use HasFactory;


    // belongs to a booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
