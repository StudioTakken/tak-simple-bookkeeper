<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $casts = [
        'originals' => 'array'
    ];


    protected $fillable = [
        'date',
        'account',
        'contra_account',
        'description',
        'plus_min',
        'plus_min_int',
        'invoice_nr',
        'bank_code',
        'amount',
        'btw',
        'amount_inc',
        'remarks',
        'tag',
        'mutation_type',
        'category',
        'originals',
    ];



    public function getAmountIncAttribute($value)
    {
        return $value;
    }


    public function getAmountAttribute($value)
    {
        //   $value = (float)$this->amount_inc - $this->btw;
        return $value;
    }



    public function splitAmountBtw()
    {
        $this->btw = ($this->amount_inc / 121) * 0.21;
        $this->amount = (int)$this->amount_inc - (int)$this->btw;
        return $this->save();
    }


    // CalcAmountIncAndBtw
    public function CalcAmountIncAndBtw()
    {
        $this->btw = $this->amount * 0.21;
        $this->amount_inc = $this->amount + $this->btw;
        return $this->save();
    }

    public function NoBTW()
    {
        $this->btw = 0;
        if ($this->amount_inc == 0) {
            $this->amount_inc = $this->amount;
        } else {
            $this->amount = $this->amount_inc;
        }
        return $this->save();
    }


    public static function insertData($insertData)
    {



        $booking = new Booking;
        $booking->date              = $insertData['date'];
        $booking->account           = $insertData['account'];
        $booking->contra_account    = $insertData['contra_account'];
        $booking->description       = $insertData['description'];
        $booking->plus_min          = $insertData['plus_min'];
        $booking->plus_min_int      = $insertData['plus_min_int'];
        $booking->invoice_nr        = $insertData['invoice_nr'];
        $booking->bank_code          = $insertData['bank_code'];
        $booking->amount            = $insertData['amount'];
        $booking->btw               = $insertData['btw'];
        $booking->amount_inc        = $insertData['amount_inc'];
        $booking->remarks           = $insertData['remarks'];
        $booking->tag               = $insertData['tag'];
        $booking->mutation_type     = $insertData['mutation_type'];
        $booking->category          = $insertData['category'];


        $booking->originals = $insertData['originals'];


        $booking->save();
    }

    public static function checkIfAllreadyImported($insertData)
    {
        $booking = Booking::where('date', $insertData['date'])
            ->where('account', $insertData['account'])
            ->where('contra_account', $insertData['contra_account'])
            ->where('description', $insertData['description'])
            ->where('plus_min',    $insertData['plus_min'])
            ->where('plus_min_int', $insertData['plus_min_int'])
            //  ->where('invoice_nr', $invoice_nr)
            // ->where('category', $category)
            //  ->where('amount', $insertData['amount'])
            //  ->where('btw', $btw)
            ->where('amount_inc', $insertData['amount_inc'])
            //  ->where('remarks', $remarks)
            //  ->where('tag', $tag)
            //  ->where('mutation_type', $mutation_type)
            ->first();
        if ($booking) {
            return true;
        } else {
            return false;
        }
    }



    public function resetBooking()
    {


        $insertData = $this->originals;

        $this->date              = $insertData['date'];
        $this->account           = $insertData['account'];
        $this->contra_account    = $insertData['contra_account'];
        $this->description       = $insertData['description'];
        $this->plus_min          = $insertData['plus_min'];
        $this->plus_min_int      = $insertData['plus_min_int'];
        $this->invoice_nr        = $insertData['invoice_nr'];
        $this->bank_code         = $insertData['bank_code'];
        $this->amount            = $insertData['amount'];
        $this->btw               = $insertData['btw'];
        $this->amount_inc        = $insertData['amount_inc'];
        $this->remarks           = $insertData['remarks'];
        $this->tag               = $insertData['tag'];
        $this->mutation_type     = $insertData['mutation_type'];
        $this->category          = $insertData['category'];

        return $this->save();
    }


    public function scopeDebiteuren($query)
    {
        return $query->where('category', 'debiteuren');
    }

    public function scopePeriod($query)
    {
        return $query->where('date', '>=', session('startDate'))->where('date', '<=', session('stopDate'));
    }
}
