<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use Livewire\Component;

class AdminBookings extends Component
{

    public $scope;
    public $bookings;
    public $freshnow;

    protected $listeners = ['refreshBookings' => 'refreshThis'];


    public function render()
    {

        if ($this->scope == 'debiteuren') {

            $this->bookings = Booking::period()->debiteuren()->orderBy('date')->orderBy('id')->where('parent_id', NULL)->get();
            // we moeten de debiteuren categorie omkeren van +  naar -

        } elseif ($this->scope != 'bookings') {

            $this->bookings = Booking::period()->where('category', $this->scope)->orderBy('date')->orderBy('id')->get();
        } else {

            $this->bookings = Booking::period()->bookings()->orderBy('date')->orderBy('id')->where('parent_id', NULL)->get();
        }

        return view('livewire.admin-bookings', ['bookings' => $this->bookings]);
    }


    public function refreshThis()
    {
        $this->freshnow = now();
    }
}
