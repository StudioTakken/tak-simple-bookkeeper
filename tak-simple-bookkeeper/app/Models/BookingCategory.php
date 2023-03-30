<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class BookingCategory extends Model
{
    use HasFactory;


    // has many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'category', 'id');
    }



    /**
     * 
     * Return the full list of accounts from database and cache it  
     * Cache the database results that are often accessed but seldom changed
     * 
     * @return array 
     */
    public static function getAll()
    {

        Cache::forget('all_the_booking_categories');

        $booking_categories = Cache::rememberForever('all_the_booking_categories', function () {
            return self::all()->sortBy('name');
        });
        return $booking_categories;
    }
}
