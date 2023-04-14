<?php

use App\Models\Invoice;
use App\Models\User;

it('can create an invoice', function () {

    // act as user 1
    $this->actingAs(User::find(1));

    $this->get(route('invoices.create'))
        ->assertStatus(200);

    // act as user 1
    $this->actingAs(User::find(1));

    $unique = md5(now());

    $this->post(route('invoices.store'), [
        'invoice_nr' => '123',
        'date' => '2023-04-14',
        'description' => 'Test invoice',
        'amount' => 100,
    ])->assertRedirect(route(
        'invoices.edit',
        // get the latest invoice
        Invoice::latest()->first()
    ));

    $this->assertDatabaseHas('invoices', [
        'invoice_nr' => '123',
        'date' => '2023-04-14',
        'description' => 'Test invoice',
        'amount' => 100,
    ]);
})->group('invoice');

it('can update an invoice', function () {

    // act as user 1
    $this->actingAs(User::find(1));

    $this->get(route('invoices.edit',   Invoice::latest()->first()))
        ->assertStatus(200);

    $this->put(route('invoices.update',  Invoice::latest()->first()), [
        'invoice_nr' => '1234',
        'date' => '2023-04-14',
        'description' => 'Test invoice',
        'amount' => 100,
    ])->assertRedirect(route('invoices.edit',  Invoice::latest()->first()));

    $this->assertDatabaseHas('invoices', [
        'invoice_nr' => '1234',
        'date' => '2023-04-14',
        'description' => 'Test invoice',
        'amount' => 100,
    ]);
})->group('invoice');

it('can delete an invoice', function () {

    // act as user 1
    $this->actingAs(User::find(1));

    $unique = md5(now());

    // first create an invoice
    $this->post(route('invoices.store'), [
        'invoice_nr' => $unique,
        'date' => '2023-04-15',
        'description' => 'Test delete invoice',
        'amount' => 100,
    ]);

    $this->delete(route('invoices.destroy', Invoice::latest()->first()))
        ->assertRedirect(route('invoices.index'));

    $this->assertDatabaseMissing('invoices', [
        'invoice_nr' => $unique,
        'date' => '2023-04-15',
        'description' => 'Test delete invoice',
        'amount' => 100,
    ]);
})->group('invoice');



it('can show an invoice', function () {

    // act as user 1
    $this->actingAs(User::find(1));

    $this->get(route('invoices.show', Invoice::latest()->first()))
        ->assertStatus(200);
})->group('invoice');



it('can list invoices', function () {
    // act as user 1
    $this->actingAs(User::find(1));

    $this->get(route('invoices.index'))
        ->assertStatus(200);
})->group('invoice');
