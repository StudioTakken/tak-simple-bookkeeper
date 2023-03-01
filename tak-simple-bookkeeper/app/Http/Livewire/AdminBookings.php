<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use Livewire\Component;

class AdminBookings extends Component
{

    public $scope;
    public $bookings;
    public $freshnow;
    public $debet;
    public $credit;

    protected $listeners = ['refreshBookings' => 'refreshThis'];


    public function render()
    {

        if ($this->scope == 'debiteuren') {

            $this->bookings     = Booking::period()->debiteuren()->orderBy('date')->orderBy('id')->where('parent_id', NULL)->get();
            $this->debet        = Booking::period()->debiteuren()->orderBy('date')->orderBy('id')->where('parent_id', NULL)->where('account', 'Debiteuren')->sum('amount_inc');
            $this->credit       = Booking::period()->debiteuren()->orderBy('date')->orderBy('id')->where('parent_id', NULL)->where('account', '!=', 'Debiteuren')->sum('amount_inc');
        } elseif ($this->scope != 'bookings') {

            $this->bookings     = Booking::period()->where('category', $this->scope)->orderBy('date')->orderBy('id')->get();
            $this->debet        = Booking::period()->where('category', $this->scope)->orderBy('date')->orderBy('id')->where('plus_min_int', '1')->sum('amount_inc');
            $this->credit       = Booking::period()->where('category', $this->scope)->orderBy('date')->orderBy('id')->where('plus_min_int', '-1')->sum('amount_inc');
        } else {

            $this->bookings     = Booking::period()->bookings()->orderBy('date')->orderBy('id')->where('parent_id', NULL)->get();
            $this->debet        = Booking::period()->bookings()->orderBy('date')->orderBy('id')->where('parent_id', NULL)->where('plus_min_int', '1')->sum('amount_inc');
            $this->credit       = Booking::period()->bookings()->orderBy('date')->orderBy('id')->where('parent_id', NULL)->where('plus_min_int', '-1')->sum('amount_inc');
        }

        $this->debet = number_format($this->debet / 100, 2, ',', '.');
        $this->credit = number_format($this->credit / 100, 2, ',', '.');



        return view('livewire.admin-bookings', ['bookings' => $this->bookings, 'scope' => $this->scope, 'debet' => $this->debet, 'credit' => $this->credit]);
    }


    public function refreshThis()
    {
        $this->freshnow = now();
    }
}
