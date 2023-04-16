<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Client') }}
        </h2>
    </x-slot>
    <form action="{{ route('clients.update', $client) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="{{ $client->name }}">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ $client->email }}">
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" value="{{ $client->phone }}">
        <label for="company_name">Company Name:</label>
        <input type="text" name="company_name" id="company_name" value="{{ $client->company_name }}">
        <label for="tav">t.a.v.:</label>
        <input type="text" name="tav" id="tav" value="{{ $client->tav }}">
        <label for="address">Address:</label>
        <input type="text" name="address" id="address" value="{{ $client->address }}">
        <label for="zip_code">Zip Code:</label>
        <input type="text" name="zip_code" id="zip_code" value="{{ $client->zip_code }}">
        <label for="city">City:</label>
        <input type="text" name="city" id="city" value="{{ $client->city }}">
        <button type="submit">Update</button>
    </form>

</x-app-layout>
