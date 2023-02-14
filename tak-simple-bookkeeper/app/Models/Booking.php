<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;


    protected $fillable = [
        'date',
        'account',
        'contra_account',
        'description',
        'plus_min',
        'plus_min_int',
        'invoice_nr',
        'category',
        'amount',
        'btw',
        'amount_inc',
        'remarks',
        'tag',
        'mutation_type',
    ];

    //In Laravel, the get[FieldName]Attribute() function is a naming convention used to define an accessor method for a model attribute. 
    // The accessor method is used to get the value of the attribute from the model.
    // https://laravel.com/docs/8.x/eloquent-mutators#accessors-and-mutators


    // public function getPlusMinAttribute($value)
    // {
    //     return $value === 'plus' ? 'plus' : 'min';
    // }

    // public function getPlusMinIntAttribute($value)
    // {
    //     return $value === 'plus' ? 1 : -1;
    // }

    // public function setPlusMinAttribute($value)
    // {
    //     $this->attributes['plus_min'] = $value === 'plus' ? 'plus' : 'min';
    // }

    // public function setPlusMinIntAttribute($value)
    // {
    //     $this->attributes['plus_min_int'] = $value === 'plus' ? 1 : -1;
    // }

    public function getAmountIncAttribute($value)
    {
        return $value;
    }



    // public function setAmountIncAttribute($value)
    // {
    //     //     dd($this->btw);
    //     $this->attributes['amount_inc'] = (float)$this->amount + $this->btw;
    // }

    public function getAmountAttribute($value)
    {
        $value = (float)$this->amount_inc - $this->btw;
        return $value;
    }

    public function setAmountAttribute($value)
    {


        // strip the currency symbol
        $value = str_replace('€', '', $value);

        // strip the spaces
        $value = str_replace(' ', '', $value);

        // check if the value is a valid dutch format

        if (preg_match('/^\d{1,3}(\.\d{3})*,\d{2}$/', $value)) {
            // make it a european format, with a dot as decimal separator and no thousands separator
            $value = str_replace('.', '', $value); // remove the thousands separators
            $value = str_replace(',', '.', $value); // replace the decimal separator comma with a dot
        }
        // remove the thousands separators if they are there
        $value = str_replace(',', '', $value); // replace the decimal separator comma with a dot


        // make it a amount in cents
        $value = (int)round($value * 100);

        $this->attributes['amount'] = $value;
    }

    public function setAmountIncAttribute($value)
    {


        // strip the currency symbol
        $value = str_replace('€', '', $value);

        // strip the spaces
        $value = str_replace(' ', '', $value);

        // check if the value is a valid dutch format

        if (preg_match('/^\d{1,3}(\.\d{3})*,\d{2}$/', $value)) {
            // make it a european format, with a dot as decimal separator and no thousands separator
            $value = str_replace('.', '', $value); // remove the thousands separators
            $value = str_replace(',', '.', $value); // replace the decimal separator comma with a dot
        }
        // remove the thousands separators if they are there
        $value = str_replace(',', '', $value); // replace the decimal separator comma with a dot


        // make it a amount in cents
        $value = (int)round($value * 100);

        $this->attributes['amount_inc'] = $value;
    }

    // public function getBtwAttribute($value)
    // {
    //     return $value * $this->plus_min_int;
    // }

    // public function setBtwAttribute($value)
    // {
    //     $this->attributes['btw'] = $value * $this->plus_min_int;
    // }


    public static function insertData($insertData)
    {

        // ddl($insertData);
        $booking = new Booking;
        $booking->date              = $insertData['date'];
        $booking->account           = $insertData['account'];
        $booking->contra_account    = $insertData['contra_account'];
        $booking->description       = $insertData['description'];
        $booking->plus_min          = $insertData['plus_min'];
        $booking->plus_min_int      = $insertData['plus_min_int'];
        $booking->invoice_nr        = $insertData['invoice_nr'];
        $booking->category          = $insertData['category'];
        $booking->amount            = $insertData['amount'];
        $booking->btw               = $insertData['btw'];
        $booking->amount_inc        = $insertData['amount_inc'];
        $booking->remarks           = $insertData['remarks'];
        $booking->tag               = $insertData['tag'];
        $booking->mutation_type     = $insertData['mutation_type'];
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
}
