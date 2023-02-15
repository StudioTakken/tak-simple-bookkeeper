<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AdminRowBooking extends Component
{
    public $booking;

    public function render()
    {
        return view('livewire.admin-row-booking');
    }

    /**
     * Split the amount_inc into amount and btw
     * @return void 
     */
    public function splitAmountBtw()
    {
        $this->booking->splitAmountBtw();
    }


    public function CalcAmountIncAndBtw()
    {
        $this->booking->CalcAmountIncAndBtw();
    }

    public function NoBTW()
    {
        $this->booking->NoBTW();
    }
}
