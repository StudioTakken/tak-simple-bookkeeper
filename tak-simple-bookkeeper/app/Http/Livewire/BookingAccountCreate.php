<?php

namespace App\Http\Livewire;

use App\Models\BookingAccount;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;

class BookingAccountCreate extends Component
{

    //  public BookingAccount $account;

    public $name;
    public $slug;
    public $named_id;
    public $start_balance;
    public $plus_min_int = 1;



    protected $messages = [
        'name' => 'Een naam is verplicht, en moet minimaal 3 karakters lang zijn',
        'slug' => 'Een slug is verplicht, en moet uniek zijn',
        'named_id' => 'Een keyname is verplicht, moet uniek zijn',
        'start_balance' => 'Start balance is verplicht',
        'plus_min_int' => 'Een plus_min_int is verplicht',
    ];


    protected function rules()
    {
        return [

            'name' => 'required|string|min:3|max:255|unique:booking_accounts,slug,' . $this->name,
            'slug' => 'required|string|min:3|max:255|unique:booking_accounts,slug,' . $this->slug,
            'named_id' => 'required|string|min:3|max:255|unique:booking_accounts,slug,' . $this->named_id,
            'start_balance' => 'required|string',
            'plus_min_int' => 'required|int',

        ];
    }




    // on change of any of the fields, validate
    public function updated($propertyName)
    {

        // if the property is name, then autofill the slug, and named_id
        if ($propertyName == 'name') {


            // be sure the name is unique



            // if slug is empty, then fill it with the name
            if (empty($this->slug)) {
                $this->slug = Str::slug($this->name);
            }

            // if named_id is empty, then fill it with the name
            if (empty($this->named_id)) {
                $this->named_id = Str::slug($this->name);
            }

            // if start_balance is empty, then fill it with 0
            if (empty($this->start_balance)) {
                $this->start_balance = 0;
            }
        }
    }

    public function render()
    {

        if (is_numeric($this->start_balance)) {
            $this->start_balance = number_format($this->start_balance / 100, 2, ',', '.');
        }
        return view('livewire.booking-account-create');
    }


    public function save()
    {

        $this->validate();

        // centify the start_balance if it is not an integer
        if (!is_int($this->start_balance)) {
            $this->start_balance = Centify($this->start_balance);
        }

        if ($this->plus_min_int != 1) {
            $this->plus_min_int = -1;
        }

        $account = new BookingAccount();
        $account->name = $this->name;
        $account->slug = $this->slug;
        $account->named_id = $this->named_id;
        $account->start_balance = $this->start_balance;
        $account->plus_min_int = $this->plus_min_int;
        $account->intern = 1;
        $account->include_children = 1;
        $account->intern = 1;

        $ok = $account->save();

        Cache::forget('all_the_booking_accounts');
        // redirect to the category edit page
        return redirect()->route('accounts.edit', ['account' => $account->id]);
        //  return redirect()->route('dashboard');
    }
}
