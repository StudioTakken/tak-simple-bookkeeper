<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'invoice_nr',
        'client_id',
        'date',
        'description',
        'amount',
        'vat',
        'amount_vat',
        'amount_inc',
        'details',
        'exported'
    ];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function scopePeriod($query)
    {

        if (session('startDate') == null) {
            session(['startDate' => date('Y-m-d', strtotime('-1 year'))]);
        }
        if (session('stopDate') == null) {
            session(['stopDate' => date('Y-m-d')]);
        }


        return $query
            ->where('date', '>=', session('startDate'))
            ->where('date', '<=', session('stopDate'));
    }


    public function getNrOfDebiteurenBookingsAttribute()
    {

        $bookingCount = Booking::where('invoice_nr', $this->invoice_nr)
                    ->select('account')
                    ->where('account', 'debiteuren')
                    ->count();

        return $bookingCount > 0 ? $bookingCount : false;

    }




}
