<?php

namespace App\Http\Livewire;

use App\Models\BookingAccount;

class AdminEditBooking extends AdminRowBooking
{

    public $booking;
    public $freshnow;
    public $splitOffAmount;
    public $amount_inc;
    public $description;
    public $date;
    public $plus_min_int;
    public $delete_confirm = false;
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


    public function showDeleteConfirm()
    {
        $this->delete_confirm = true;
    }


    public function removeBooking()
    {
        $account = $this->booking->account;
        $this->booking->delete();
        return redirect()->route('account.onaccount', ['account' => $account]);
    }

    public function removeBookingCancel()
    {
        $this->delete_confirm = false;
    }
}
