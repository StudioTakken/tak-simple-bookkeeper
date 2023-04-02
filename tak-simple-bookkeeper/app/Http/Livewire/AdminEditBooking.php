<?php

namespace App\Http\Livewire;

use App\Models\BookingAccount;
use App\Models\BookingProve;

class AdminEditBooking extends AdminRowBooking
{

    public $booking;
    public $freshnow;
    public $splitOffAmount;
    public $amount_inc;
    public $description;
    public $date;
    public $polarity;
    public $invoice_nr;
    public $delete_confirm = false;
    public $open_dropzone = false;
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
        $account = $this->booking->booking_account;
        ddl($account);


        $this->booking->delete();
        return redirect()->route('account.onaccount', ['account' => $account->slug]);
    }

    public function removeBookingCancel()
    {
        $this->delete_confirm = false;
    }



    function removeProve($proveId)
    {
        $prove = BookingProve::find($proveId);
        $prove->delete();
        $this->emit('refreshBookings');
    }


    public function openDropzone()
    {
        $this->open_dropzone = true;
    }
}
