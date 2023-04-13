<?php

namespace App\Http\Livewire;

use App\Http\Traits\BookingTrait;
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

    use BookingTrait;

    public function render()
    {
        // from the trait
        $this->getBookings();
        $bookingAccount = $this->getBookingAccount();

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
