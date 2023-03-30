<?php

namespace App\Http\Livewire;

use App\Models\BookingCategory;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class BookingCategoryEdit extends Component
{
    public BookingCategory $category;
    public $delete_confirm = false;
    public $nr_of_bookings_in_category;

    protected $rules = [
        'category.name' => 'required|string|min:3',
        'category.slug' => 'required|string|min:3',
        'category.named_id' => 'required|string|min:3',
        'category.polarity' => 'required|int',
        'category.loss_and_provit' => 'required|int',
        'category.vat_overview' => 'required|int',

    ];

    public function render()
    {
        $this->getNrOfBookingsInCategory();
        return view('livewire.booking-category-edit');
    }


    public function save()
    {
        $this->validate();

        if ($this->category->polarity != 1) {
            $this->category->polarity = -1;
        }

        $ok = $this->category->save();

        $this->blink($ok);
        Cache::forget('all_the_booking_categories');
    }


    public function blink($saved)
    {

        if ($saved) {
            session()->flash('message', 'success');
        } else {
            ddl('some wrong');
            session()->flash('message', 'error');
        }
    }

    public function getNrOfBookingsInCategory()
    {
        $this->nr_of_bookings_in_category = $this->category->bookings->count();
    }

    public function showDeleteConfirm()
    {
        $this->delete_confirm  = true;
    }

    public function removeCategoryCancel()
    {
        $this->delete_confirm = false;
    }


    public function removeCategory()
    {
        $this->category->delete();
        Cache::forget('all_the_booking_categories');
        return redirect()->route('dashboard');
    }
}
