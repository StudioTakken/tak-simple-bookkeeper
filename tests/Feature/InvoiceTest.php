<?php

use App\Models\Invoice;
use App\Models\User;


it('can create an other invoice', function () {

    $this->withoutMiddleware();

    $invoiceData = Invoice::factory()->make()->toArray();

    $response = $this->post(route('invoices.store'), $invoiceData);

    $response->assertRedirect(route('invoices.edit', Invoice::latest()->first()));

    $this->assertDatabaseHas('invoices', [
        'invoice_nr'    => $invoiceData['invoice_nr'],
        'client_id'     => $invoiceData['client_id'],
        'date'          => $invoiceData['date'],
        'description'   => $invoiceData['description'],
        'amount'        => $invoiceData['amount'],

    ]);
})->group('invoice1');




it('can update an invoice', function () {
    $this->withoutMiddleware();

    $invoice = Invoice::factory()->create();
    $invoiceData = Invoice::factory()->make()->toArray();

    $response = $this->put(route('invoices.update', $invoice), $invoiceData);

    $response->assertRedirect(route('invoices.edit', $invoice->id));

    $this->assertDatabaseHas('invoices', [
        'invoice_nr'    => $invoiceData['invoice_nr'],
        'client_id'     => $invoiceData['client_id'],
        'date'          => $invoiceData['date'],
        'description'   => $invoiceData['description'],
        'amount'        => $invoiceData['amount'],
    ]);
})->group('invoice2');

it('can delete an invoice', function () {
    $this->withoutMiddleware();
    $this->actingAs(User::find(1));

    $invoice = invoice::factory()->create();

    $response = $this->delete(route('invoices.destroy', $invoice->id));

    $response->assertRedirect(route('invoices.index'));

    $this->assertDatabaseMissing('invoices', ['id' => $invoice->id]);
})->group('invoice2');




it('can show an invoice', function () {

    // act as user 1
    $this->actingAs(User::find(1));

    $this->get(route('invoices.show', Invoice::latest()->first()))
        ->assertStatus(200);
})->group('invoice2');



it('can list invoices', function () {
    // act as user 1
    $this->actingAs(User::find(1));

    $this->get(route('invoices.index'))
        ->assertStatus(200);
})->group('invoice2');
