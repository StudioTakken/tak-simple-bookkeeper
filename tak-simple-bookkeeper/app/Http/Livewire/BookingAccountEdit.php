<?php

namespace App\Http\Livewire;

use App\Models\BookingAccount;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class BookingAccountEdit extends Component
{

    public BookingAccount $account;

    protected $rules = [
        'account.name' => 'required|string|min:3',
        'account.slug' => 'required|string|min:3',
        'account.named_id' => 'required|string|min:3',
        'account.start_balance' => 'required|string',
        'account.plus_min_int' => 'required|int',
    ];


    //      'slug' => 'debiteuren',
    //     'named_id' => 'debiteuren',
    //     'name' => 'Debiteuren',
    //     'include_children' => 1,
    //     'intern' => 0,
    //     'plus_min_int' => 1,
    //     'start_balance' => 0,

    // mount
    public function mount()
    {
    }



    public function render()
    {

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

        if ($this->account->plus_min_int != 1) {
            $this->account->plus_min_int = -1;
        }

        $ok = $this->account->save();

        $this->blink($ok);
        Cache::forget('all_the_booking_accounts');
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
