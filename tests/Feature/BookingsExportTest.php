<?php

use App\Http\Controllers\BookingController;

it('can export a bookings xls file', function () {

    // first do the migration
    // $this->artisan('migrate:refresh --seed');

    $response = (new BookingController)->bookingsXlsx();
    $this->assertEquals($response->getStatusCode(), 200);

    $this->assertStringContainsString('Content-Disposition: attachment; filename=bookings.xlsx', (string)$response);
})->group('export');
