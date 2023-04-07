<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\SidePanel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

// php artisan test --filter SidePanelTest tests/Feature/Livewire/SidePanelTest.php

class SidePanelTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(SidePanel::class);

        $component->assertStatus(200);
    }
}
