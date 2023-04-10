<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\SidePanel;
use Livewire\Livewire;

it('displays the side panel', function () {
    $component = Livewire::test(SidePanel::class);
    $component->assertStatus(200);
});
