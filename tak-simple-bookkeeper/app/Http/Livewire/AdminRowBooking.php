<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use Livewire\Component;

class AdminRowBooking extends Component
{
    public $booking;
    public $category = '';
    public $hasChildren = false;
    public $amount_inc;


    public function mount()
    {




        if ($this->booking->category) {
            $this->category = $this->booking->category;
        }
        if ($this->booking->amount_inc) {
            $this->amount_inc = $this->booking->amount_inc;
        }

        // // if there is a booking with this id as parent_id, then there are children
        // $this->hasChildren = Booking::where('parent_id', $this->booking->id)->exists();

        // if ($this->hasChildren) {
        //     $this->booking->children = Booking::period()->orderBy('date')->orderBy('id')->where('parent_id', $this->booking->id)->get();


        //     // $this->calculateChildren();
        // }
    }



    public function calculateChildren()
    {
        $this->hasChildren = Booking::where('parent_id', $this->booking->id)->exists();

        if ($this->hasChildren) {
            $this->booking->children = Booking::period()->orderBy('date')->orderBy('id')->where('parent_id', $this->booking->id)->get();

            foreach ($this->booking->children as $child) {

                //  $this->booking->amount = $this->booking->amount - $child->amount;
                //   $this->booking->btw = $this->booking->btw - $child->btw;
                $this->booking->amount_inc = $this->booking->amount_inc - $child->amount_inc;
            }
        }
    }




    public function render()
    {
        $this->calculateChildren();
        $this->amount_inc = number_format($this->booking->amount_inc / 100, 2, ',', '.');
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



    public function updateAmountInc()
    {
        $this->booking->amount_inc       = Centify($this->amount_inc);
        $ok = $this->booking->save();
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
        $this->emit('refreshBookings');
        //$this->redirect(url()->previous());
    }


    public function splitBooking()
    {
        $ok = $this->booking->splitBooking();
        $this->blink($ok);
        $this->emit('refreshBookings');
        // $this->redirect(url()->previous());
    }

    public function splitBookingBtw()
    {
        $ok = $this->booking->splitBookingBtw();
        $this->blink($ok);
        $this->emit('refreshBookings');
        // $this->redirect(url()->previous());
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
