<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use App\Models\BookingAccount;
use App\Models\BookingCategory;
use Illuminate\Support\Str;
use Livewire\Component;

class AdminRowBooking extends Component
{
    public $booking;
    public $category = '';
    public $hasChildren = false;
    public $amount;
    public $description;
    public $date;
    public $polarity;
    public $remarks;
    public $cross_account = '';
    public $invoice_nr;
    public $balance;
    public $listOfCategories;
    public $listOfCrossCategoryAccounts = [];
    public $active;




    public $splitOffAmount;

    protected $listeners = [
        'openSidePanel'
    ];


    public function mount()
    {
        $this->active = false;

        if ($this->booking->category) {
            $this->category = $this->booking->category;
        }
        if ($this->booking->cross_account) {
            $this->cross_account = $this->booking->cross_account;
        }
    }


    public function listOfCrossCategorieForPulldown()
    {

        $this->listOfCategories = cache()->remember('booking_categories', 60, function () {
            return BookingCategory::getAll();
        });

        $this->listOfCrossCategoryAccounts = cache()->remember('booking_accounts', 60, function () {
            // adding the accounts as links to accounts and category cross-posting
            $bookingAccounts = BookingAccount::getAll();
            // get the bookingCategory cross-posting
            $crossCategory = BookingCategory::where('slug', 'cross-posting')->first();

            foreach ($bookingAccounts as $bookingAccount) {
                $bookingAccount->category = $crossCategory->id;
            }

            return $bookingAccounts;
        });
    }


    // niet meer nodig?
    public function calculateChildren()
    {
        // TODO optimaliseren
        $this->hasChildren = Booking::where('parent_id', $this->booking->id)
            ->select('id')
            ->exists();
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

        // TODO optimaliseren
        $this->checkBalance();
        // TODO optimaliseren? Is niet meer nodig denk ik
        // $this->calculateChildren();

        $this->amount = number_format($this->booking->amount / 100, 2, ',', '.');
        $this->description = $this->booking->description;
        $this->remarks = $this->booking->remarks;
        $this->date = $this->booking->date;
        $this->polarity = $this->booking->polarity;
        $this->invoice_nr = $this->booking->invoice_nr;
        $this->listOfCrossCategorieForPulldown();
    }

    /**
     *
     * check the balance of the bookings with the same invoice_nr
     *
     * @return void
     */
    public function checkBalance()
    {


        $this->balance = false;
        // is there an invoice_nr?
        if ($this->booking->invoice_nr != '') {

            // get all bookings with this invoice_nr
            $bookings = Booking::where('invoice_nr', $this->booking->invoice_nr)
                ->select('amount', 'cross_account', 'account')
                ->get();

            $balance = 0;

            foreach ($bookings as $booking) {

                if ($booking->cross_account != '' and $booking->account != $booking->cross_account) {
                    $booking->amount = $booking->amount * -1;
                }

                $balance += $booking->amount;
            }

            if ($balance == 0) {
                $this->balance = true;
            }
        }
    }

    public function CalcAmountIncAndBtw()
    {
        $ok = $this->booking->CalcAmountIncAndBtw();
        $this->blink($ok);
    }

    public function updateAmountInc()
    {
        $this->booking->amount = Centify($this->amount);
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

    public function updateInvoiceNr()
    {
        $this->booking->invoice_nr = $this->invoice_nr;
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

        if ($this->date != '') {
            $this->booking->date = $this->date;
            $ok = $this->booking->save();
            $this->blink($ok);
            $this->emit('refreshBookings');
        }
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

        if ($this->booking->polarity == '1') {
            $ok = $this->booking->splitBookingBtw('in', 21);
        } else {
            $ok = $this->booking->splitBookingBtw('out', 21);
        }
        $this->blink($ok);
        $this->emit('refreshBookings');
    }

    public function splitBookingBtw9perc()
    {

        if ($this->booking->polarity == '1') {
            $ok = $this->booking->splitBookingBtw('in', 9);
        } else {
            $ok = $this->booking->splitBookingBtw('out', 9);
        }
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
        session()->flash('booking', $this->booking->id);
        $this->emit('openRightPanel', $this->booking->description, 'admin-edit-booking', $this->booking, key(now()) . '-' . Str::random());
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
