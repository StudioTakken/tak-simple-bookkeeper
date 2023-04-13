<?php


namespace App\Http\Traits;

use App\Models\Booking;
use App\Models\BookingAccount;

trait BookingTrait
{


    public function getBookings()
    {

        // ddl(session('viewscope'));
        // get the session variable viewscope
        $this->viewscope = session('viewscope');

        // get the sesion variable ordering
        if (session('dateordering') == null) {
            session(['dateordering' => 'asc']);
        }
        $this->dateordering = session('dateordering');


        if ($this->method == 'account.onaccount') {

            // $this->search is not empty then filter the bookings on the search term
            if ($this->search != '') {
                $this->bookings = Booking::period()->ofAccount($this->viewscope)
                    ->orderBy('date', $this->dateordering)->orderBy('id')
                    ->where('parent_id', NULL)
                    ->where(
                        function ($query) {
                            $query->where('description', 'like', '%' . $this->search . '%')
                                ->orWhere('remarks', 'like', '%' . $this->search . '%')
                                ->orWhere('invoice_nr', 'like', '%' . $this->search . '%');
                        }
                    )
                    ->get();
            } else {

                if ($this->include_children) {
                    $this->bookings = Booking::period()->ofAccount($this->viewscope)->orderBy('date', $this->dateordering)->orderBy('hashed')->orderBy('id')->get();
                } else {
                    $this->bookings = Booking::period()->ofAccount($this->viewscope)->orderBy('date', $this->dateordering)->orderBy('hashed')->orderBy('id')->where('parent_id', NULL)->get();
                }
            }


            $this->debetStart      = Booking::getDebetOrCredit($this->viewscope, 'debet', 'start');
            $this->creditStart     = Booking::getDebetOrCredit($this->viewscope, 'credit', 'start');

            $this->debet      = Booking::getDebetOrCredit($this->viewscope, 'debet');
            $this->credit     = Booking::getDebetOrCredit($this->viewscope, 'credit');
        } elseif ($this->viewscope != 'bookings') {

            // no children in category!
            $category = $this->viewscope;

            // $this->search is not empty then filter the bookings on the search term
            if ($this->search != '') {
                $this->bookings     = Booking::period()
                    ->where('category', $category)->orderBy('date', $this->dateordering)->orderBy('id')
                    ->where(
                        function ($query) {
                            $query->where('description', 'like', '%' . $this->search . '%')
                                ->orWhere('remarks', 'like', '%' . $this->search . '%')
                                ->orWhere('invoice_nr', 'like', '%' . $this->search . '%');
                        }
                    )
                    ->get();
            } else {
                $this->bookings     = Booking::period()->where('category', $category)->orderBy('date', $this->dateordering)->orderBy('id')->get();
            }

            $this->debet        = Booking::period()->where('category', $category)->orderBy('date', $this->dateordering)->orderBy('id')->where('polarity', '1')->sum('amount');
            $this->credit       = Booking::period()->where('category', $category)->orderBy('date', $this->dateordering)->orderBy('id')->where('polarity', '-1')->sum('amount');
        }

        $this->debet = number_format($this->debet / 100, 2, ',', '.');
        $this->credit = number_format($this->credit / 100, 2, ',', '.');
    }




    public function getBookingAccountTotals()
    {

        // get the account from the BookingAccount model
        $bookingAccount = BookingAccount::where('named_id', $this->viewscope)->first();

        if (isset($bookingAccount->start_balance)) {

            $bookingAccount->start_balance =  BookingAccount::getBalance($this->viewscope, 'start');
            $bookingAccount->end_balance =  BookingAccount::getBalance($this->viewscope, 'end');
            //    $bookingAccount->start_balance = number_format($bookingAccount->start_balance / 100, 2, ',', '.');
            //   $bookingAccount->end_balance = number_format($bookingAccount->end_balance / 100, 2, ',', '.');
        } else {
            $bookingAccount = new BookingAccount;
            $bookingAccount->start_balance = 0;
            $bookingAccount->end_balance = 0;
            // ddl($this->viewscope);
            $bookingAccount->end_balance =  0 + (int)$this->debet - (int)$this->credit;
            //   $bookingAccount->end_balance = number_format($bookingAccount->end_balance / 100, 2, ',', '.');
        }

        return $bookingAccount;
    }
}
