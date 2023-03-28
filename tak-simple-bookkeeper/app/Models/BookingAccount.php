<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class BookingAccount extends Model
{
    use HasFactory;

    // has many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'account', 'named_id');
    }

    // has many cross bookings
    public function crossBookings()
    {
        return $this->hasMany(Booking::class, 'cross_account', 'named_id');
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

        // Cache::forget('all_the_booking_accounts');
        $booking_accounts = Cache::rememberForever('all_the_booking_accounts', function () {
            return self::all()->sortBy('name');
        });
        return $booking_accounts;
    }


    /**
     * 
     * @param string $period    start or end
     * @return mixed 
     * 
     */
    public function balance($period)
    {
        $debet = Booking::getDebetOrCredit($this->named_id, 'debet', $period);
        $credit = Booking::getDebetOrCredit($this->named_id, 'credit', $period);
        $this->balance = $this->start_balance + $debet - $credit;

        return $this->balance;
    }




    /**
     * 
     * @param string $period    start or end
     * @return mixed 
     * 
     */
    public static function getBalance($named_id, $period)
    {
        $bookingAccount = self::where('named_id', $named_id)->first();
        return $bookingAccount->balance($period);
    }


    public function updateStartBalance($start_balance)
    {
        $this->start_balance = Centify($start_balance);
        $this->save();
    }



    // public function getStartBalanceAttribute($value)
    // {

    //     // only if it is  an integer
    //     //  if (!is_int((int)$value)) {
    //     //  $value = Centify($value);
    //     $value = number_format($value / 100, 2, ',', '.');
    //     // }

    //     return $value;
    // }
}
