<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AdminRowBooking extends Component
{
    public $booking;
    public $category = '';



    public function mount()
    {

        if ($this->booking->category) {
            $this->category = $this->booking->category;
        }
    }



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

    public function resetBooking()
    {
        $this->booking->resetBooking();
    }



    public function updatedCategory()
    {
        $this->booking->category = $this->category;
        //  ddl($this->booking->category);
        $this->booking->save();
    }
}
