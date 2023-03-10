<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use App\Models\BookingAccount;
use Livewire\Component;

class AdminBookings extends Component
{

    public $viewscope;
    public $bookings;
    public $freshnow;
    public $debet;
    public $credit;
    public $include_children = true;
    public $method;

    protected $listeners = ['refreshBookings' => 'refreshThis'];


    public function render()
    {


        // get the session variable viewscope
        $this->viewscope = session('viewscope');

        // if viewscope starts with cat: the remove :cat and set viewscope to the rest
        if (substr($this->viewscope, 0, 4) == 'cat:') {
            $this->viewscope = substr($this->viewscope, 4);
            // set teh session variable viewscope to the rest
            session(['viewscope' => $this->viewscope]);
        }


        // get the account from the BookingAccount model
        $bookingAccount = BookingAccount::where('key', $this->viewscope)->first();

        // ddl($this->method);
        // ddl($this->viewscope);
        if ($this->method == 'account.onaccount') {

            // hier moeten we verschillend reageren obv account settings
            $this->include_children = $bookingAccount->include_children;

            //    if ($this->viewscope == 'NL94INGB0007001049') {
            if ($bookingAccount->include_children == true) {

                ddl('a');
                $this->bookings     = Booking::period()->ofAccount($this->viewscope)->orderBy('date')->orderBy('id')->where('parent_id', NULL)->get();
                $this->debet        = Booking::period()->ofAccount($this->viewscope)->orderBy('date')->orderBy('id')->where('plus_min_int', '1')->sum('amount_inc');
                $this->credit       = Booking::period()->ofAccount($this->viewscope)->orderBy('date')->orderBy('id')->where('plus_min_int', '-1')->sum('amount_inc');
            } else {

                $this->bookings     = Booking::period()->ofAccount($this->viewscope)->orderBy('date')->orderBy('id')->where('parent_id', NULL)->get();
                $this->debet        = Booking::period()->ofAccount($this->viewscope)->orderBy('date')->orderBy('id')->where('category', '=', $this->viewscope)->sum('amount_inc');
                $this->credit       = Booking::period()->ofAccount($this->viewscope)->orderBy('date')->orderBy('id')->where('category', '!=', $this->viewscope)->sum('amount_inc');
            }
        } elseif ($this->viewscope == 'debiteuren' and $this->method != 'oncategory') {

            $this->bookings     = Booking::period()->debiteuren()->orderBy('date')->orderBy('id')->where('parent_id', NULL)->get();
            $this->debet        = Booking::period()->debiteuren()->orderBy('date')->orderBy('id')->where('parent_id', NULL)->where('account', 'Debiteuren')->sum('amount_inc');
            $this->credit       = Booking::period()->debiteuren()->orderBy('date')->orderBy('id')->where('parent_id', NULL)->where('account', '!=', 'Debiteuren')->sum('amount_inc');
        } elseif ($this->viewscope != 'bookings') {

            // no children in category!
            $category = $this->viewscope;

            if ($category == 'debiteuren') {
                session(['viewscope' => 'cat:debiteuren']); // we dont want the booking to act like a negative booking in the category debiteuren
            }


            $this->bookings     = Booking::period()->where('category', $category)->orderBy('date')->orderBy('id')->get();
            $this->debet        = Booking::period()->where('category', $category)->orderBy('date')->orderBy('id')->where('plus_min_int', '1')->sum('amount_inc');
            $this->credit       = Booking::period()->where('category', $category)->orderBy('date')->orderBy('id')->where('plus_min_int', '-1')->sum('amount_inc');
        } else {

            $this->bookings     = Booking::period()->bookings()->orderBy('date')->orderBy('id')->where('parent_id', NULL)->get();
            $this->debet        = Booking::period()->bookings()->orderBy('date')->orderBy('id')->where('parent_id', NULL)->where('plus_min_int', '1')->sum('amount_inc');
            $this->credit       = Booking::period()->bookings()->orderBy('date')->orderBy('id')->where('parent_id', NULL)->where('plus_min_int', '-1')->sum('amount_inc');
        }

        $this->debet = number_format($this->debet / 100, 2, ',', '.');
        $this->credit = number_format($this->credit / 100, 2, ',', '.');



        return view('livewire.admin-bookings', [
            'bookings' => $this->bookings,
            'debet' => $this->debet,
            'credit' => $this->credit,
            'include_children' => $this->include_children

        ]);
    }


    public function refreshThis()
    {
        $this->freshnow = now();
    }
}
