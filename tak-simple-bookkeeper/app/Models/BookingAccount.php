<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class BookingAccount extends Model
{
    use HasFactory;


    /**
     * 
     * Return the full list of accounts from database and cache it  
     * Cache the database results that are often accessed but seldom changed
     * 
     * @return array 
     */
    public static function getAll()
    {

        // Cache::forget('all_the_booking_accounts');

        $booking_accounts = Cache::rememberForever('all_the_booking_accounts', function () {
            return self::all()->sortBy('id');
        });
        return $booking_accounts;
    }







    // on every udate we need to clear the cache
    // public static function boot()
    // {
    //     parent::boot();

    //     static::updated(function ($booking_account) {
    //         Cache::forget('all_the_booking_accounts');
    //     });
    // }



    public static function getBalance($named_id, $period)
    {

        $debet = Booking::getDebetOrCredit($named_id, 'debet', $period);
        $credit = Booking::getDebetOrCredit($named_id, 'credit', $period);

        $bookingAccount = self::where('named_id', $named_id)->first();
        $bookingAccount->balance = $bookingAccount->start_balance + $debet - $credit;

        return $bookingAccount->balance;
    }
}
