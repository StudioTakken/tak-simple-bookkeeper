<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // belongs to account
    public function booking_account()
    {
        return $this->belongsTo(BookingAccount::class, 'account', 'named_id');
    }

    public function booking_cross_account()
    {
        return $this->belongsTo(BookingAccount::class, 'cross_account', 'named_id');
    }

    public function booking_category()
    {
        return $this->belongsTo(BookingCategory::class, 'category', 'id');
    }


    // has many booking_proves
    public function booking_proves()
    {
        return $this->hasMany(BookingProve::class);
    }



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
        'polarity',
        'invoice_nr',
        'bank_code',
        'amount',
        'remarks',
        'tag',
        'mutation_type',
        'hashed',
        'category',
        'cross_account',
        'originals'
    ];


    protected $attributes = array(
        'contra_account' => '',
        'plus_min' => '',
        'invoice_nr' => '',
        'bank_code' => '',
        'amount' => '',
        'remarks' => '',
        'tag' => '',
        'mutation_type' => '',
        'hashed' => '',
        'polarity' => 1,
        'cross_account' => ''
    );

    public static function insertData($insertData)
    {

        $booking = new Booking();

        $booking->date              = $insertData['date'];
        $booking->account           = $insertData['account'];
        $booking->contra_account    = $insertData['contra_account'];
        $booking->description       = $insertData['description'];
        $booking->plus_min          = $insertData['plus_min'];
        $booking->polarity      = $insertData['polarity'];
        $booking->invoice_nr        = $insertData['invoice_nr'];
        $booking->bank_code         = $insertData['bank_code'];
        $booking->amount        = $insertData['amount'];
        $booking->remarks           = $insertData['remarks'];
        $booking->tag               = $insertData['tag'];
        $booking->mutation_type     = $insertData['mutation_type'];
        $booking->hashed          = $insertData['hashed'];
        $booking->category          = $insertData['category'];
        $booking->cross_account     = '';

        $booking->originals = $insertData['originals'];


        $ok = $booking->save();


        return $booking->id;
    }



    // @TODO beter cecken op dubbele boekingen. Dire bijna identieke gaan fout.
    // wellicht met een hash van de data?
    public static function checkIfAllreadyImported($hashed)
    {
        $booking = Booking::where('hashed', $hashed)

            // not changing fields
            // ->where('account', $insertData['account'])
            // ->where('description', $insertData['description'])
            // ->where('plus_min',    $insertData['plus_min'])
            // ->where('polarity', $insertData['polarity'])
            // ->where('mutation_type', $insertData['mutation_type'])

            // // changing fields
            // ->whereJsonContains('originals->contra_account', $insertData['contra_account'])
            // ->whereJsonContains('originals->amount', $insertData['amount'])

            //  ->where('invoice_nr', $invoice_nr)
            // ->where('category', $category)
            //  ->where('amount', $insertData['amount'])
            //  ->where('btw', $btw)
            //   ->where('amount', $insertData['amount'])
            //   ->where('remarks', $insertData['amount'])
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
        $this->polarity          = $insertData['polarity'];
        $this->invoice_nr        = $insertData['invoice_nr'];
        $this->bank_code         = $insertData['bank_code'];
        $this->amount        = $insertData['amount'];
        $this->remarks           = $insertData['remarks'];
        $this->tag               = $insertData['tag'];
        $this->mutation_type     = $insertData['mutation_type'];
        $this->hashed     = $insertData['hashed'];
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
        $newBooking = new Booking();
        $newBooking->parent_id = $this->id;
        $newBooking->date = $this->date;
        $newBooking->account = $this->account;
        $newBooking->contra_account = $this->contra_account;
        $newBooking->description = $this->description . ' (split off)';
        $newBooking->plus_min = $this->plus_min;
        $newBooking->polarity = $this->polarity;
        $newBooking->invoice_nr = $this->invoice_nr;
        $newBooking->bank_code = $this->bank_code;
        $newBooking->amount = $splitOffCents;
        $newBooking->remarks = $this->remarks . ' (split off)';
        $newBooking->tag = $this->tag;
        $newBooking->mutation_type = $this->mutation_type;
        $newBooking->hashed = $this->hashed;
        $newBooking->category = $this->category;
        $newBooking->cross_account = $this->cross_account;


        $this->amount = $this->amount - $splitOffCents;
        $this->save();

        return $newBooking->save();
    }

    public function splitBookingBtw($inorout = 'in')
    {

        $original_amount = $this->amount;
        $this->amount = $this->amount / 121 * 100;
        $btw = (int)$this->amount * 0.21;

        // format $original_amount to 2 decimals
        $original_amount = number_format($original_amount / 100, 2, '.', '');

        $this->remarks = $this->remarks  . ' (inc: ' . $original_amount . ')';
        $this->save();

        // create a new booking for the btw

        // get the bookingCategory named btw or btw-uit
        if ($inorout == 'in') {

            $bookingCategory = BookingCategory::where('slug', 'btw')->first();
        } else {
            $bookingCategory = BookingCategory::where('slug', 'btw-uit')->first();
        }

        $newBooking = new Booking();
        $newBooking->parent_id = $this->id;
        $newBooking->date = $this->date;
        $newBooking->account = $this->account;
        $newBooking->contra_account = $this->contra_account;
        $newBooking->description = $this->description . ' 21% btw';
        $newBooking->plus_min = $this->plus_min;
        $newBooking->polarity = $this->polarity;
        $newBooking->invoice_nr = $this->invoice_nr;
        $newBooking->bank_code = $this->bank_code;
        $newBooking->amount = $btw;
        $newBooking->remarks = $this->remarks;
        $newBooking->tag = $this->tag;
        $newBooking->mutation_type = $this->mutation_type;
        $newBooking->hashed = $this->hashed;
        $newBooking->category = $bookingCategory->id;

        return $newBooking->save();
    }


    public function addBookingBtw($inorout = 'in', $perc = 21)
    {
        $multiplier = 1 + ($perc / 100);

        $inc_amount = $this->amount * $multiplier;

        // format $original_amount to 2 decimals
        $inc_amount = number_format($inc_amount / 100, 2, '.', '');

        $this->remarks = $this->remarks  . ' (inc: ' . $inc_amount . ')';
        $this->save();

        // create a new booking
        $btw = $this->amount * $perc / 100;

        // get the bookingCategory named btw or btw-uit
        if ($inorout == 'in') {
            $bookingCategory = BookingCategory::where('slug', 'btw')->first();
        } else {
            $bookingCategory = BookingCategory::where('slug', 'btw-uit')->first();
        }

        $newBooking = new Booking();
        $newBooking->parent_id = $this->id;
        $newBooking->date = $this->date;
        $newBooking->account = $this->account;
        $newBooking->contra_account = $this->contra_account;
        $newBooking->description = $this->description . ' 21% btw';
        $newBooking->plus_min = $this->plus_min;
        $newBooking->polarity = $this->polarity;
        $newBooking->invoice_nr = $this->invoice_nr;
        $newBooking->bank_code = $this->bank_code;
        $newBooking->amount = $btw;
        $newBooking->remarks = $this->remarks;
        $newBooking->tag = $this->tag;
        $newBooking->mutation_type = $this->mutation_type;
        $newBooking->hashed = $this->hashed;
        $newBooking->category = $bookingCategory->id;

        return $newBooking->save();
    }



    // public function scopeBookings($query)
    // {
    //     return $query
    //         ->where('account', 'NL12INGB1234567890');
    // }


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


        return $query
            ->where('date', '>=', session('startDate'))
            ->where('date', '<=', session('stopDate'));
    }


    public function scopePeriodBefore($query)
    {

        if (session('startDate') == null) {
            session(['startDate' => date('Y-m-d', strtotime('-1 year'))]);
        }

        // one day before startdate
        //   $startDate = session('startDate');
        $startDate = date('Y-m-d', strtotime(session('startDate') . ' -1 day'));

        return $query->where('date', '<=', $startDate);
    }


    public function scopePeriodEnd($query)
    {

        if (session('stopDate') == null) {
            session(['stopDate' => date('Y-m-d')]);
        }
        $stopDate = session('stopDate');
        //  $stopDate = date('Y-m-d', strtotime(session('stopDate') . ' -1 day'));


        return $query->where('date', '<=', $stopDate);
    }


    public function getPolarityAttribute($value)
    {

        $viewscope = session('viewscope');
        if ($this->cross_account) {
            // new
            $cacheKey = 'booking_cross_account_' .$this->cross_account;
            $bookingCrossAccount = cache()->remember($cacheKey, 60, function () {
                return BookingAccount::where('named_id', $this->cross_account)
                ->select('named_id')
                ->first();
            });

            // old
            // $bookingCrossAccount =  BookingAccount::where('named_id', $this->cross_account)
            // ->select('named_id')
            // ->first();
        }





        if (
            isset($bookingCrossAccount)
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

        //        ddl($pAccount);

        if ($debetOrCredit == 'debet') {
            $plusMin = '1';
        } else {
            $plusMin = '-1';
        }

        //   $bookingAccount = BookingAccount::where('named_id', $pAccount)->first();

        if ($period === 'start') {

            $periodSum        = self::periodBefore()->ofAccount($pAccount)->orderBy('date')->orderBy('id')->where('account', '=', $pAccount)->where('polarity', $plusMin)->sum('amount');
            $periodSum        += self::periodBefore()->ofAccount($pAccount)->orderBy('date')->orderBy('id')->where('cross_account', '=', $pAccount)->where('polarity', -$plusMin)->sum('amount');
        } elseif ($period === 'end') {

            $periodSum        = self::periodEnd()->ofAccount($pAccount)->orderBy('date')->orderBy('id')->where('account', '=', $pAccount)->where('polarity', $plusMin)->sum('amount');
            $periodSum        += self::periodEnd()->ofAccount($pAccount)->orderBy('date')->orderBy('id')->where('cross_account', '=', $pAccount)->where('polarity', -$plusMin)->sum('amount');
        } else {

            $periodSum        = self::period()->ofAccount($pAccount)->orderBy('date')->orderBy('id')->where('account', '=', $pAccount)->where('polarity', $plusMin)->sum('amount');
            $periodSum        += self::period()->ofAccount($pAccount)->orderBy('date')->orderBy('id')->where('cross_account', '=', $pAccount)->where('polarity', -$plusMin)->sum('amount');
        }


        return $periodSum;
    }
}
