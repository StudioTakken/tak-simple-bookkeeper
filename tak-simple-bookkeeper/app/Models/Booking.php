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
        'parent_id',
        'date',
        'account',
        'contra_account',
        'description',
        'plus_min',
        'plus_min_int',
        'invoice_nr',
        'bank_code',
        'amount_inc',
        'remarks',
        'tag',
        'mutation_type',
        'category',
        'cross_account',
        'originals'
    ];


    protected $attributes = array(
        'contra_account' => '',
        'plus_min' => '',
        'invoice_nr' => '',
        'bank_code' => '',
        'amount_inc' => '',
        'remarks' => '',
        'tag' => '',
        'mutation_type' => '',
        'plus_min_int' => 1,
        'cross_account' => ''
    );

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
        $booking->bank_code         = $insertData['bank_code'];
        $booking->amount_inc        = $insertData['amount_inc'];
        $booking->remarks           = $insertData['remarks'];
        $booking->tag               = $insertData['tag'];
        $booking->mutation_type     = $insertData['mutation_type'];
        $booking->category          = $insertData['category'];
        $booking->cross_account     = '';

        $booking->originals = $insertData['originals'];


        $ok = $booking->save();


        return $booking->id;
    }



    public static function checkIfAllreadyImported($insertData)
    {
        $booking = Booking::where('date', $insertData['date'])

            // not changing fields
            ->where('account', $insertData['account'])
            ->where('description', $insertData['description'])
            ->where('plus_min',    $insertData['plus_min'])
            ->where('plus_min_int', $insertData['plus_min_int'])
            ->where('mutation_type', $insertData['mutation_type'])

            // changing fields
            ->whereJsonContains('originals->contra_account', $insertData['contra_account'])
            ->whereJsonContains('originals->amount_inc', $insertData['amount_inc'])

            //  ->where('invoice_nr', $invoice_nr)
            // ->where('category', $category)
            //  ->where('amount', $insertData['amount'])
            //  ->where('btw', $btw)
            //   ->where('amount_inc', $insertData['amount_inc'])
            //  ->where('remarks', $remarks)
            //  ->where('tag', $tag)
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

        if ($insertData == null) {
            return false;
        }

        $this->date              = $insertData['date'];
        $this->account           = $insertData['account'];
        $this->contra_account    = $insertData['contra_account'];
        $this->description       = $insertData['description'];
        $this->plus_min          = $insertData['plus_min'];
        $this->plus_min_int      = $insertData['plus_min_int'];
        $this->invoice_nr        = $insertData['invoice_nr'];
        $this->bank_code         = $insertData['bank_code'];
        $this->amount_inc        = $insertData['amount_inc'];
        $this->remarks           = $insertData['remarks'];
        $this->tag               = $insertData['tag'];
        $this->mutation_type     = $insertData['mutation_type'];
        $this->category          = $insertData['category'];
        $this->cross_account     = '';


        // delete children
        $children = Booking::where('parent_id', $this->id)->get();
        foreach ($children as $child) {
            $child->delete();
        }

        return $this->save();
    }



    public function splitBooking($splitOffCents)
    {

        if ($splitOffCents == 0) {
            return false;
        }


        // create a new booking
        $newBooking = new Booking;
        $newBooking->parent_id = $this->id;
        $newBooking->date = $this->date;
        $newBooking->account = $this->account;
        $newBooking->contra_account = $this->contra_account;
        $newBooking->description = $this->description . ' (split off)';
        $newBooking->plus_min = $this->plus_min;
        $newBooking->plus_min_int = $this->plus_min_int;
        $newBooking->invoice_nr = $this->invoice_nr;
        $newBooking->bank_code = $this->bank_code;
        $newBooking->amount_inc = $splitOffCents;
        $newBooking->remarks = $this->remarks . ' (split off)';
        $newBooking->tag = $this->tag;
        $newBooking->mutation_type = $this->mutation_type;
        $newBooking->category = $this->category;
        $newBooking->cross_account = $this->cross_account;


        $this->amount_inc = $this->amount_inc - $splitOffCents;
        $this->save();

        return $newBooking->save();
    }

    public function splitBookingBtw()
    {

        $btw = $this->amount_inc / 121 * 21;
        $this->amount_inc = $this->amount_inc - $btw;
        $this->save();

        // create a new booking 

        // get the bookingCategory named btw
        $bookingCategory = BookingCategory::where('slug', 'btw')->first();

        $newBooking = new Booking;
        $newBooking->parent_id = $this->id;
        $newBooking->date = $this->date;
        $newBooking->account = $this->account;
        $newBooking->contra_account = $this->contra_account;
        $newBooking->description = $this->description . ' 21% btw';
        $newBooking->plus_min = $this->plus_min;
        $newBooking->plus_min_int = $this->plus_min_int;
        $newBooking->invoice_nr = $this->invoice_nr;
        $newBooking->bank_code = $this->bank_code;
        $newBooking->amount_inc = $btw;
        $newBooking->remarks = $this->remarks;
        $newBooking->tag = $this->tag;
        $newBooking->mutation_type = $this->mutation_type;
        $newBooking->category = $bookingCategory->id;

        return $newBooking->save();
    }



    public function scopeBookings($query)
    {
        return $query
            ->where('account', 'NL94INGB0007001049');
    }


    // https://laravel.com/docs/9.x/eloquent#dynamic-scopes
    public function scopeOfAccount($query, $type)
    {


        return $query
            ->where('account', $type)
            ->orWhere('cross_account', $type);
    }



    public function scopeDebiteuren($query)
    {

        return $query
            ->where('category', 'debiteuren')
            ->orWhere('account', 'debiteuren');
    }

    public function scopePeriod($query)
    {

        if (session('startDate') == null) {
            session(['startDate' => date('Y-m-d', strtotime('-1 year'))]);
        }
        if (session('stopDate') == null) {
            session(['stopDate' => date('Y-m-d')]);
        }


        return $query->where('date', '>=', session('startDate'))->where('date', '<=', session('stopDate'));
    }


    public function scopePeriodBefore($query)
    {

        if (session('startDate') == null) {
            session(['startDate' => date('Y-m-d', strtotime('-1 year'))]);
        }

        return $query->where('date', '<', session('startDate'));
    }


    public function scopePeriodEnd($query)
    {

        // if (session('startDate') == null) {
        //     session(['startDate' => date('Y-m-d', strtotime('-1 year'))]);
        // }
        if (session('stopDate') == null) {
            session(['stopDate' => date('Y-m-d')]);
        }


        return $query->where('date', '<=', session('stopDate'));
    }


    public function getPlusMinIntAttribute($value)
    {

        $viewscope = session('viewscope');

        if ($this->cross_account) {
            $bookingCrossAccount = BookingAccount::where('named_id', $this->cross_account)->first();
        }

        if (
            isset($bookingCrossAccount)
            // and $bookingCrossAccount->intern  == 1
            and
            $viewscope == $bookingCrossAccount->named_id
        ) {
            return -$value;
        } else {
            return $value;
        }
        return $value;
    }



    /**
     * 
     * @param string $pAccount 
     * @param string $debetOrCredit 
     * @param string $period    start or end
     * @return mixed 
     * 
     */
    public static function getDebetOrCredit($pAccount, $debetOrCredit, $period = '')
    {

        if ($debetOrCredit == 'debet') {
            $plusMin = '1';
        } else {
            $plusMin = '-1';
        }

        //   $bookingAccount = BookingAccount::where('named_id', $pAccount)->first();

        if ($period === 'start') {

            $periodSum        = self::periodBefore()->ofAccount($pAccount)->orderBy('date')->orderBy('id')->where('account', '=', $pAccount)->where('plus_min_int', $plusMin)->sum('amount_inc');
            $periodSum        += self::periodBefore()->ofAccount($pAccount)->orderBy('date')->orderBy('id')->where('cross_account', '=', $pAccount)->where('plus_min_int', -$plusMin)->sum('amount_inc');
        } elseif ($period === 'end') {

            $periodSum        = self::periodEnd()->ofAccount($pAccount)->orderBy('date')->orderBy('id')->where('account', '=', $pAccount)->where('plus_min_int', $plusMin)->sum('amount_inc');
            $periodSum        += self::periodEnd()->ofAccount($pAccount)->orderBy('date')->orderBy('id')->where('cross_account', '=', $pAccount)->where('plus_min_int', -$plusMin)->sum('amount_inc');
        } else {

            $periodSum        = self::period()->ofAccount($pAccount)->orderBy('date')->orderBy('id')->where('account', '=', $pAccount)->where('plus_min_int', $plusMin)->sum('amount_inc');
            $periodSum        += self::period()->ofAccount($pAccount)->orderBy('date')->orderBy('id')->where('cross_account', '=', $pAccount)->where('plus_min_int', -$plusMin)->sum('amount_inc');
        }


        return $periodSum;
    }
}
