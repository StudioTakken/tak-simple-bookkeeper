<?php

namespace App\Http\Livewire;

use App\Models\BookingCategory;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class BookingCategoryEdit extends Component
{
    public BookingCategory $category;

    protected $rules = [
        'category.name' => 'required|string|min:3',
        'category.slug' => 'required|string|min:3',
        'category.named_id' => 'required|string|min:3',
        'category.plus_min_int' => 'required|int',
        'category.remarks' => 'string',
    ];

    public function render()
    {
        return view('livewire.booking-category-edit');
    }


    public function save()
    {
        $this->validate();

        if ($this->category->plus_min_int != 1) {
            $this->category->plus_min_int = -1;
        }

        $ok = $this->category->save();

        $this->blink($ok);
        Cache::forget('all_the_booking_categories');
    }


    public function blink($saved)
    {
        ddl('b');

        if ($saved) {
            session()->flash('message', 'success');
        } else {
            session()->flash('message', 'error');
        }
    }
}