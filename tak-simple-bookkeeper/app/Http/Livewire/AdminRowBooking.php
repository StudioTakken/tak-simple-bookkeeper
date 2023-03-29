<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use App\Models\BookingAccount;
use App\Models\BookingCategory;
use Livewire\Component;

class AdminRowBooking extends Component
{
    public $booking;
    public $category = '';
    public $hasChildren = false;
    public $amount_inc;
    public $description;
    public $date;
    public $polarity;
    public $remarks;
    public $cross_account = '';
    public $listOfCategories = [];
    public $listOfCrossCategoryAccounts = [];




    public $splitOffAmount;

    protected $listeners = [
        'openSidePanel'
    ];


    public function mount()
    {

        if ($this->booking->category) {
            $this->category = $this->booking->category;
        }
        if ($this->booking->cross_account) {
            $this->cross_account = $this->booking->cross_account;
        }
    }


    public function listOfCrossCategorieForPulldown()
    {

        $this->listOfCategories = BookingCategory::getAll();

        // adding the accounts as links to accounts and category cross-posting
        $bookingAccounts = BookingAccount::getAll();
        // get the bookingCategory cross-posting
        $crossCategory = BookingCategory::where('slug', 'cross-posting')->first();

        foreach ($bookingAccounts as $bookingAccount) {
            $bookingAccount->category = $crossCategory->id;
        }
        $this->listOfCrossCategoryAccounts = $bookingAccounts;
    }

    public function calculateChildren()
    {
        $this->hasChildren = Booking::where('parent_id', $this->booking->id)->exists();
        if ($this->hasChildren) {
            $this->booking->children = Booking::period()->orderBy('date')->orderBy('id')->where('parent_id', $this->booking->id)->get();
        }
    }

    public function render()
    {
        $this->beforeRender();
        return view('livewire.admin-row-booking');
    }

    public function beforeRender()
    {
        $this->calculateChildren();
        $this->amount_inc = number_format($this->booking->amount_inc / 100, 2, ',', '.');
        $this->description = $this->booking->description;
        $this->remarks = $this->booking->remarks;
        $this->date = $this->booking->date;
        $this->polarity = $this->booking->polarity;
        $this->listOfCrossCategorieForPulldown();
    }

    public function CalcAmountIncAndBtw()
    {
        $ok = $this->booking->CalcAmountIncAndBtw();
        $this->blink($ok);
    }

    public function updateAmountInc()
    {
        $this->booking->amount_inc = Centify($this->amount_inc);
        $ok = $this->booking->save();
        $this->blink($ok);
        $this->emit('refreshBookings');
    }

    public function updatePolarity()
    {

        $this->booking->polarity = $this->polarity;
        $ok = $this->booking->save();
        $this->blink($ok);
        $this->emit('refreshBookings');
    }


    public function updateDescription()
    {
        $this->booking->description = $this->description;
        $ok = $this->booking->save();
        $this->blink($ok);
        $this->emit('refreshBookings');
    }

    public function updateRemarks()
    {
        $this->booking->remarks = $this->remarks;
        $ok = $this->booking->save();
        $this->blink($ok);
        $this->emit('refreshBookings');
    }

    public function updateDate()
    {
        $this->booking->date = $this->date;
        $ok = $this->booking->save();
        $this->blink($ok);
        $this->emit('refreshBookings');
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
    }


    public function splitBooking()
    {
        $ok = $this->booking->splitBooking();
        $this->blink($ok);
        $this->emit('refreshBookings');
    }

    public function splitBookingBtw()
    {
        $ok = $this->booking->splitBookingBtw();
        $this->blink($ok);
        $this->emit('refreshBookings');
    }


    public function updatedCategory()
    {

        // get the booking category cross-posting
        $crossCategory = BookingCategory::where('slug', 'cross-posting')->first();

        // divide $this->category in two parts on ::
        $parts = explode('::', $this->category);

        if (count($parts) == 2) {
            $this->category = $parts[0];
            $this->booking->cross_account = $parts[1];
        }





        // get this category
        if ($this->category != '') {
            $category = BookingCategory::where('id', $this->category)->first();
        }

        if (!isset($category) or $category->id != $crossCategory->id) {
            $this->booking->cross_account = ''; // reset cross account
        }


        $this->booking->category = $this->category;



        $ok = $this->booking->save();

        $this->blink($ok);
        $this->emit('refreshBookings');
    }

    public function updatedCrossAccount()
    {

        $this->booking->cross_account = $this->cross_account;
        $ok = $this->booking->save();
        $this->blink($ok);
        $this->emit('refreshBookings');
    }

    public function blink($saved)
    {

        if ($saved) {
            session()->flash('message', 'success');
        } else {
            session()->flash('message', 'error');
        }
    }

    public function openSidePanel()
    {
        $this->emit('openRightPanel', $this->booking->description, 'admin-edit-booking', $this->booking, key(now()));
    }

    public function splitOffAction()
    {

        $splitOffCents = Centify($this->splitOffAmount);
        $ok = $this->booking->splitBooking($splitOffCents);
        $this->blink($ok);
        $this->splitOffAmount = '';
        $this->emit('refreshBookings');
    }
}
