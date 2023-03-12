<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Booking;
use Illuminate\Support\Facades\View;
use Livewire\Component;

final class SidePanel extends Component
{
    public bool $open = false;
    public string $title = 'Default Panel';
    public string $component = '';
    public $booking;

    protected $listeners = [
        'openRightPanel'
    ];

    public function openRightPanel(string $title, string $component, Booking $booking): void
    {

        if ($this->open == true) {
            $this->open = false;
        } else {
            $this->open = true;
        }

        $this->title = $title;
        $this->component = $component;
        $this->booking = $booking;
    }

    public function render()
    {
        return View::make('livewire.side-panel');
    }
}
