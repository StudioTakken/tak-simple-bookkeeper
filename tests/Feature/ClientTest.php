<?php

use App\Models\Client;
use App\Models\User;

it('can create a client', function () {


    // act as user 1
    $this->actingAs(User::find(1));

    $clientData = Client::factory()->make()->toArray();

    $response = $this->post(route('clients.store'), $clientData);

    $response->assertRedirect(route('clients.index'));

    $this->assertDatabaseHas('clients', $clientData);
})->group('clients');



it('can update a client', function () {

    $this->actingAs(User::find(1));

    $client = Client::factory()->create();

    $clientData = Client::factory()->make()->toArray();

    $response = $this->put(route('clients.update', $client), $clientData);
    // dd($client);

    $response->assertRedirect(route('clients.edit', $client->id));

    $this->assertDatabaseHas('clients', $clientData);
})->group('clients');


it('can delete a client', function () {

    $this->actingAs(User::find(1));

    $client = Client::factory()->create();

    $response = $this->delete(route('clients.destroy', $client));

    $response->assertRedirect(route('clients.index'));

    $this->assertDatabaseMissing('clients', ['id' => $client->id]);
})->group('clients');

it('can list clients', function () {

    $this->actingAs(User::find(1));

    $clients = Client::factory()->count(5)->create();

    $response = $this->get(route('clients.index'));

    foreach ($clients as $client) {
        $response->assertSee($client->name);
    }
})->group('clients');

it('can view a client', function () {
    $this->actingAs(User::find(1));

    $client = Client::factory()->create();

    $response = $this->get(route('clients.show', $client));

    $response->assertSee($client->name)
        ->assertSee($client->email)
        ->assertSee($client->phone)
        ->assertSee($client->company_name)
        ->assertSee($client->tav)
        ->assertSee($client->address)
        ->assertSee($client->zip_code)
        ->assertSee($client->city)
        ->assertSee($client->created_at)
        ->assertSee($client->updated_at);
})->group('clients');

it('can view the create client form', function () {

    $this->actingAs(User::find(1));

    $response = $this->get(route('clients.create'));

    $response->assertSee('Create Client')
        ->assertSee('Name:')
        ->assertSee('Email:')
        ->assertSee('Phone:')
        ->assertSee('Company Name:')
        ->assertSee('t.a.v.:')
        ->assertSee('Address:')
        ->assertSee('Zip Code:')
        ->assertSee('City:');
})->group('clients');

it('can view the edit client form', function () {

    $this->actingAs(User::find(1));

    $client = Client::factory()->create();

    $response = $this->get(route('clients.edit', $client));

    $response->assertSee('Edit Client')
        ->assertSee('Name:')
        ->assertSee('Email:')
        ->assertSee('Phone:')
        ->assertSee('Company Name:')
        ->assertSee('t.a.v.:')
        ->assertSee('Address:')
        ->assertSee('Zip Code:')
        ->assertSee('City:');
})->group('clients');
