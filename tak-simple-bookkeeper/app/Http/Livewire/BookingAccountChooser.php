<?php

namespace App\Http\Livewire;

use App\Models\BookingAccount;
use Livewire\Component;

class BookingAccountChooser extends AdminRowBooking
{

    public $booking;

    public function render()
    {
        $accounts = BookingAccount::all()->sortBy('id');
        return view('livewire.booking-account-chooser', compact('accounts'));
    }
}
