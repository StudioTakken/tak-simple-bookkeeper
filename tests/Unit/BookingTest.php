<?php

use App\Http\Controllers\BookingController;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

// uses(RefreshDatabase::class);

it('displays debiteuren pagina', function () {
    $user = User::factory()->create();
    $response = $this
        ->actingAs($user)
        ->get('/debiteuren');
    $response->assertSee('debiteuren');
});


it('can import file', function () {
    $user = User::find(1);
    $this->actingAs($user);
    $importer = new BookingController();
    $importer->import();
    $bookingCount = Booking::count();

    $total = (int)Booking::sum('amount');

    $this->assertTrue($bookingCount === 42);
    $this->assertTrue($total === 4916302);
});


// it('can create a booking', function () {

// });
