<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use App\Models\BookingAccount;
use Livewire\Component;

class AdminBookings extends Component
{

    public $viewscope;
    public $bookings;
    public $freshnow;

    public $debetStart; // saldo voor periode
    public $creditStart; // saldo voor periode

    public $debet;
    public $credit;

    public $include_children = true;
    public $method;
    public $bookingAccount;

    public $dateordering = 'asc';
    public $search;

    protected $listeners = ['refreshBookings' => 'refreshThis'];


    public function render()
    {

        // ddl(session('viewscope'));
        // get the session variable viewscope
        $this->viewscope = session('viewscope');

        // get the sesion variable ordering
        if (session('dateordering') == null) {
            session(['dateordering' => 'asc']);
        }
        $this->dateordering = session('dateordering');


        // get the account from the BookingAccount model
        $bookingAccount = BookingAccount::where('named_id', $this->viewscope)->first();

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
                $this->bookings = Booking::period()->ofAccount($this->viewscope)->orderBy('date', $this->dateordering)->orderBy('id')->where('parent_id', NULL)->get();
            }

            //    $this->bookings     = Booking::period()->ofAccount($this->viewscope)->orderBy('date', $this->dateordering)->orderBy('id')->where('parent_id', NULL)->get();

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



        if (isset($bookingAccount->start_balance)) {

            $bookingAccount->start_balance =  BookingAccount::getBalance($this->viewscope, 'start');
            $bookingAccount->end_balance =  BookingAccount::getBalance($this->viewscope, 'end');
            $bookingAccount->start_balance = number_format($bookingAccount->start_balance / 100, 2, ',', '.');
            $bookingAccount->end_balance = number_format($bookingAccount->end_balance / 100, 2, ',', '.');
        } else {
            $bookingAccount = new BookingAccount;
            $bookingAccount->start_balance = 0;
            $bookingAccount->end_balance = 0;
            // ddl($this->viewscope);
            $bookingAccount->end_balance =  0 + $this->debet - $this->credit;
            $bookingAccount->end_balance = number_format($bookingAccount->end_balance / 100, 2, ',', '.');
        }




        $this->debet = number_format($this->debet / 100, 2, ',', '.');
        $this->credit = number_format($this->credit / 100, 2, ',', '.');


        return view('livewire.admin-bookings', [
            'bookings' => $this->bookings,
            'debet' => $this->debet,
            'credit' => $this->credit,
            'start_balance' => $bookingAccount->start_balance,
            'end_balance' => $bookingAccount->end_balance,
            'include_children' => $this->include_children

        ]);
    }


    public function refreshThis()
    {
        $this->freshnow = now();
    }


    public function changeOrder()
    {
        // set the session variable dateordering to the opposite of what it is now
        session(['dateordering' => session('dateordering') == 'asc' ? 'desc' : 'asc']);
        // refresh the page
        $this->refreshThis();
    }
}
