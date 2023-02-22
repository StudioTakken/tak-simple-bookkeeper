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
        $ok = $this->booking->splitAmountBtw();
        $this->blink($ok);
    }


    public function CalcAmountIncAndBtw()
    {
        $ok = $this->booking->CalcAmountIncAndBtw();
        $this->blink($ok);
    }

    public function NoBTW()
    {
        $ok = $this->booking->NoBTW();
        $this->blink($ok);
    }

    public function resetBooking()
    {
        $ok = $this->booking->resetBooking();
        $this->blink($ok);
    }



    public function updatedCategory()
    {
        $this->booking->category = $this->category;
        $ok = $this->booking->save();
        $this->blink($ok);
    }



    public function blink($saved)
    {

        if ($saved) {
            session()->flash('message', 'success');
        } else {
            session()->flash('message', 'error');
        }
    }
}
