<?php

namespace App\Http\Livewire;

use App\Models\BookingAccount;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class BookingAccountEdit extends Component
{

    public BookingAccount $account;
    public $delete_confirm = false;
    public $nr_of_bookings_in_account = 0;
    public $nr_of_cross_bookings_in_account = 0;


    protected $messages = [
        'account.name' => 'Een naam is verplicht, en moet uniek en minimaal 3 karakters lang zijn',
        'account.slug' => 'Een slug is verplicht, en moet uniek zijn',
        'account.named_id' => 'Een keyname is verplicht, en moet uniek zijn',
        'account.start_balance' => 'Start balance is verplicht',
        'account.polarity' => 'Een polarity is verplicht',
    ];


    protected function rules()
    {
        return [

            'account.name' => 'required|string|min:3|max:255',
            'account.slug' => 'required|string|min:3|max:255',
            'account.named_id' => 'required|string|min:3|max:255',
            'account.start_balance' => 'required|string',
            'account.polarity' => 'required|int',
            // 'account.name' => 'required|string|min:3|max:255|unique:booking_accounts,name,' . $this->account->name,
            // 'account.slug' => 'required|string|min:3|max:255|unique:booking_accounts,slug,' . $this->account->slug,
            // 'account.named_id' => 'required|string|min:3|max:255|unique:booking_accounts,named_id,' . $this->account->named_id,
            // 'account.start_balance' => 'required|string',
            // 'account.polarity' => 'required|int',

        ];
    }


    // mount
    public function mount()
    {
        $this->delete_confirm = false;
    }


    public function getNrOfBookingsInAccount()
    {
        $this->nr_of_bookings_in_account = $this->account->bookings->count();
    }

    // function to get the count of all bookings that have this account named_id as cross_account
    public function getNrOfCrossBookingsInAccount()
    {
        $this->nr_of_cross_bookings_in_account = $this->account->cross_bookings->count();
    }



    public function render()
    {


        $this->getNrOfBookingsInAccount();
        $this->getNrOfCrossBookingsInAccount();

        if (is_numeric($this->account->start_balance)) {
            // $this->account->start_balance = Centify($this->account->start_balance);
            $this->account->start_balance = number_format($this->account->start_balance / 100, 2, ',', '.');
        }
        return view('livewire.booking-account-edit');
    }


    public function save()
    {
        $this->validate();

        // centify the start_balance if it is not an integer
        if (!is_int($this->account->start_balance)) {
            $this->account->start_balance = Centify($this->account->start_balance);
        }

        if ($this->account->polarity != 1) {
            $this->account->polarity = -1;
        }

        $ok = $this->account->save();

        $this->blink($ok);
        Cache::forget('all_the_booking_accounts');

        return redirect()->route('accounts.edit', ['account' => $this->account->slug]);
    }


    public function blink($saved)
    {

        if ($saved) {
            session()->flash('message', 'success');
        } else {
            session()->flash('message', 'error');
        }
    }

    public function showDeleteConfirm()
    {
        $this->delete_confirm  = true;
    }

    public function removeAccountCancel()
    {
        $this->delete_confirm = false;
    }


    public function removeAccount()
    {
        $this->account->delete();
        Cache::forget('all_the_booking_accounts');
        return redirect()->route('dashboard');
    }
}
