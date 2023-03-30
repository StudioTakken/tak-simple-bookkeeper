<?php

namespace App\Http\Livewire;

use App\Models\BookingCategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;

class BookingCategoryCreate extends Component
{

    public $name;
    public $slug;
    public $named_id;
    public $remarks;
    public $polarity = 1;
    public $loss_and_provit = 1;


    protected $messages = [
        'name' => 'Een naam is verplicht, en moet minimaal 3 karakters lang zijn',
        'slug' => 'Een slug is verplicht, en moet uniek zijn',
        'named_id' => 'Een keyname is verplicht, moet uniek zijn',
        'polarity' => 'Een polarity is verplicht',
        'remarks' => 'moet een string zijn',
    ];


    protected function rules()
    {
        return [

            'name' => 'required|string|min:3|max:255|unique:booking_accounts,slug,' . $this->name,
            'slug' => 'required|string|min:3|max:255|unique:booking_accounts,slug,' . $this->slug,
            'named_id' => 'required|string|min:3|max:255|unique:booking_accounts,slug,' . $this->named_id,
            'polarity' => 'required|int',

        ];
    }







    // on change of any of the fields, validate
    public function updated($propertyName)
    {

        // if the property is name, then autofill the slug, and named_id
        if ($propertyName == 'name') {

            // if slug is empty, then fill it with the name
            if (empty($this->slug)) {
                $this->slug = Str::slug($this->name);
            }

            // if named_id is empty, then fill it with the name
            if (empty($this->named_id)) {
                $this->named_id = Str::slug($this->name);
            }
        }
    }

    public function render()
    {
        return view('livewire.booking-category-create');
    }


    public function save()
    {
        $this->validate();

        $category = new BookingCategory();
        $category->name = $this->name;
        $category->slug = $this->slug;
        $category->named_id = $this->named_id;
        $category->polarity = $this->polarity;
        $category->remarks = $this->remarks;
        $category->loss_and_provit = 1;
        $category->vat_overview = 1;
        $ok = $category->save();

        Cache::forget('all_the_booking_categories');

        return redirect()->route('categories.edit', ['category' => $category->id]);
    }
}
