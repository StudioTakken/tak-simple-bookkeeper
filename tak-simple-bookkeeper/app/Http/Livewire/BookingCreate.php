<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use Livewire\Component;

class BookingCreate extends Component
{

    public $date;
    public $description;
    public $amount_inc;
    public $account;
    public $plus_min_int = 1;

    protected $rules = [
        'date' => 'required|date',
        'description' => 'required|min:3',
        'account' => 'required|min:3',
        'amount_inc' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
        'plus_min_int' => 'required|int',
    ];
    protected $messages = [
        'date' => 'Een datum is verplicht',
        'description' => 'Een omschrijving is verplicht',
        'account' => 'required|min:3',
        'amount_inc' => 'Een bedrag is verplicht, en moet een nummer zijn, met maximaal 2 decimalen',
        'plus_min_int' => 'Standaard is plus',
    ];

    public function submit()
    {

        // ddl($this->date);
        // ddl($this->description);
        // ddl($this->amount_inc);
        // ddl($this->plus_min_int);
        // ddl($this->account);

        // centify the amount_inc
        $this->amount_inc = Centify($this->amount_inc);


        $this->validate();

        // ddl('no valdidation errors');
        // Execution doesn't reach here if validation fails.

        Booking::create([
            'date' => $this->date,
            'description' => $this->description,
            'amount_inc' => $this->amount_inc,
            'account' => $this->account->named_id,
            'plus_min_int' => $this->plus_min_int,
        ]);

        // after submit, clear the form
        $this->date = '';
        $this->description = '';
        $this->amount_inc = '';
        //  $this->account = '';

        // refresh the bookingslist
        $this->emit('refreshBookings');
    }





    public function updateAmountInc()
    {
        $this->amount_inc = Centify($this->amount_inc);
    }

    public function render()
    {

        // only if the amount_inc is numeric, then format it
        if (is_numeric($this->amount_inc)) {
            $this->amount_inc = number_format($this->amount_inc / 100, 2, ',', '.');
        }
        // else {
        //     $this->amount_inc = $this->amount_inc;
        // }

        return view('livewire.booking-create');
    }
}
