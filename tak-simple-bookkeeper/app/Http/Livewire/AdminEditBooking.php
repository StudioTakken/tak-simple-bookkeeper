<?php

namespace App\Http\Livewire;




class AdminEditBooking extends AdminRowBooking
{

    public $booking;
    public $freshnow;
    public $splitOffAmount;
    public $amount_inc;
    public $description;
    public $date;
    // public $remarks;

    protected $listeners = ['refreshBookings' => 'refreshThis'];

    public function render()
    {

        $this->beforeRender();
        return view('livewire.admin-edit-booking');
    }



    public function refreshThis()
    {
        $this->freshnow = now();
    }
}
