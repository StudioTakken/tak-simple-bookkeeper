<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DropzoneProve extends Component
{
    public $booking;

    protected $listeners = ['refresh'];




    public function render()
    {
        return view('livewire.dropzone-prove', ['key' => random_int(-999, 999)]);
    }
}
