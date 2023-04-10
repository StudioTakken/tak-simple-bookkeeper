<?php

use App\Http\Controllers\BookingAccountController;

it('can export a balance xls file', function () {

    // first do the migration
    $this->artisan('migrate:refresh --seed');

    (new BookingAccountController)->balanceXlsx();
})->group('only')->skip('not ready yet');
