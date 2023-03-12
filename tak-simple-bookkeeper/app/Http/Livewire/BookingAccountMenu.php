<?php

namespace App\Http\Livewire;

use App\Models\BookingAccount;
use Livewire\Component;

class BookingAccountMenu extends Component
{
    public function render()
    {
        $accounts = BookingAccount::getAll();
        return view('livewire.booking-account-menu', compact('accounts'));
    }
}
