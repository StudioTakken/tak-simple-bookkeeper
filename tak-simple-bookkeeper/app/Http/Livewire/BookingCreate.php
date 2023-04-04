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
    public $polarity = 1;
    public $hashed;

    protected $rules = [
        'date' => 'required|date',
        'description' => 'required|min:3',
        'account' => 'required|min:3',
        'amount_inc' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
        'polarity' => 'required|int',
    ];
    protected $messages = [
        'date' => 'Een datum is verplicht',
        'description' => 'Een omschrijving is verplicht',
        'account' => 'required|min:3',
        'amount_inc' => 'Een bedrag is verplicht, en moet een nummer zijn, met maximaal 2 decimalen',
        'polarity' => 'Standaard is plus',
    ];

    public function submit()
    {

        // ddl($this->date);
        // ddl($this->description);
        // ddl($this->amount_inc);
        // ddl($this->polarity);
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
            'polarity' => $this->polarity,
            'hashed' => '',
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

        return view('livewire.booking-create');
    }
}
