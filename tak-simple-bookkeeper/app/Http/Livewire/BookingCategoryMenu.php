<?php

namespace App\Http\Livewire;

use App\Models\BookingCategory;
use Livewire\Component;

class BookingCategoryMenu extends Component
{
    public function render()
    {
        $categories = BookingCategory::getAll();
        return view('livewire.booking-category-menu', compact('categories'));
    }
}
