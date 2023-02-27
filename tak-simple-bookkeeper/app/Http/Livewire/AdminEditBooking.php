<?php

namespace App\Http\Livewire;




class AdminEditBooking extends AdminRowBooking
{

    public $booking;
    public $freshnow;
    public $splitOffAmount;

    protected $listeners = ['refreshBookings' => 'refreshThis'];

    public function render()
    {
        $this->amount_inc = number_format($this->booking->amount_inc / 100, 2, ',', '.');
        return view('livewire.admin-edit-booking');
    }


    // public function updateAmountInc()
    // {
    //     parent::updateAmountInc();
    //     $this->blink(1);
    //     $this->emit('refreshBookings');
    // }

    public function refreshThis()
    {
        $this->freshnow = now();
    }
}
