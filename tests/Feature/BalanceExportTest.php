<?php

use App\Http\Controllers\BookingAccountController;

it('can export a balance xls file', function () {

    // first do the migration
    // $this->artisan('migrate:refresh --seed');

    $response = (new BookingAccountController)->balanceXlsx();
    $this->assertEquals($response->getStatusCode(), 200);

    $this->assertStringContainsString('Content-Disposition: attachment; filename=balance.xlsx', (string)$response);
});
