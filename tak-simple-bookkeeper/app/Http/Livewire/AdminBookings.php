<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use Livewire\Component;

class AdminBookings extends Component
{

    public $bookings;
    public $freshnow;
    protected $listeners = ['refreshBookings' => 'refreshThis'];



    public function render()
    {
        ddl('render');
        $this->freshnow = now();
        $this->bookings = Booking::period()->orderBy('date')->orderBy('id')->get();
        return view('livewire.admin-bookings');
    }


    public function refreshThis()
    {

        $this->freshnow = now();
        ddl('refreshThis');
        // $this->bookings = Booking::period()->get();
        //  $this->bookings = Booking::period()->orderBy('date')->get();
    }
}
