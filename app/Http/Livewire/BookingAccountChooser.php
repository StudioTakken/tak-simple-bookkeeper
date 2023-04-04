<?php

namespace App\Http\Livewire;

use App\Models\BookingAccount;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class BookingAccountChooser extends AdminRowBooking
{

    public $booking;

    public function render()
    {
        $booking_accounts = BookingAccount::getAll();
        return view('livewire.booking-account-chooser', compact('booking_accounts'));
    }
}
