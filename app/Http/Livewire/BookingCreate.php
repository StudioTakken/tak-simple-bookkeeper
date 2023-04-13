<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use Livewire\Component;

class BookingCreate extends Component
{

    public $date;
    public $description;
    public $amount;
    public $account;
    public $polarity = 1;
    public $hashed;

    protected $rules = [
        'date' => 'required|date',
        'description' => 'required|min:3',
        'account' => 'required|min:3',
        'amount' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
        'polarity' => 'required|int',
    ];
    protected $messages = [
        'date' => 'Een datum is verplicht',
        'description' => 'Een omschrijving is verplicht',
        'account' => 'required|min:3',
        'amount' => 'Een bedrag is verplicht, en moet een nummer zijn, met maximaal 2 decimalen',
        'polarity' => 'Standaard is plus',
    ];

    public function submit()
    {

        // ddl($this->date);
        // ddl($this->description);
        // ddl($this->amount);
        // ddl($this->polarity);
        // ddl($this->account);

        // centify the amount
        $this->amount = Centify($this->amount);


        $this->validate();

        // ddl('no valdidation errors');
        // Execution doesn't reach here if validation fails.

        // hash the booking
        $this->hashed = md5(serialize([
            'date' => $this->date,
            'description' => $this->description,
            'amount' => $this->amount,
            'account' => $this->account->named_id,
            'polarity' => $this->polarity,
        ]));


        Booking::create([
            'date' => $this->date,
            'description' => $this->description,
            'amount' => $this->amount,
            'account' => $this->account->named_id,
            'polarity' => $this->polarity,
            'hashed' => $this->hashed,
        ]);

        // after submit, clear the form
        $this->date = '';
        $this->description = '';
        $this->amount = '';
        //  $this->account = '';

        // refresh the bookingslist
        $this->emit('refreshBookings');
    }





    public function updateAmountInc()
    {
        $this->amount = Centify($this->amount);
    }

    public function render()
    {

        // only if the amount is numeric, then format it
        if (is_numeric($this->amount)) {
            $this->amount = number_format($this->amount / 100, 2, ',', '.');
        }

        return view('livewire.booking-create');
    }
}
