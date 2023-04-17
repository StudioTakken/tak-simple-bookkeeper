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
})->group('invoice');



it('can update a resource', function () {
    $this->withoutMiddleware();

    // Create a resource to update
    $invoice = Invoice::factory()->create();

    // Define the updated data
    $updatedData = Invoice::factory()->make()->toArray();

    // Send the update request
    $response = $this->put(route('invoices.update', ['invoice' => $invoice->id]), $updatedData);

    // Assert that the resource was updated successfully
    $response->assertRedirect(route('invoices.edit', $invoice->id))
        ->assertSessionHas('success', 'Invoice updated successfully');

    // Refresh the model from the database to get the updated data
    // $resource->refresh();


})->group('invoice1');




it('can delete an invoice', function () {
    $this->withoutMiddleware();
    $this->actingAs(User::find(1));

    $invoice = invoice::factory()->create();

    $response = $this->delete(route('invoices.destroy', $invoice->id));

    $response->assertRedirect(route('invoices.index'));

    $this->assertDatabaseMissing('invoices', ['id' => $invoice->id]);
})->group('invoice1');




it('can show an invoice', function () {

    // act as user 1
    $this->actingAs(User::find(1));

    $this->get(route('invoices.show', Invoice::latest()->first()))
        ->assertStatus(200);
})->group('invoice1');



it('can list invoices', function () {
    // act as user 1
    $this->actingAs(User::find(1));

    $this->get(route('invoices.index'))
        ->assertStatus(200);
})->group('invoice1');
