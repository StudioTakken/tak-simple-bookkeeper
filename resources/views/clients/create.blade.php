<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create Clients') }}
        </h2>
    </x-slot>
    <form action="{{ route('clients.store') }}" method="POST">
        @csrf
        <label for="email">Email:</label>
        <input type="email" name="email" id="email">
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone">
        <label for="company_name">Company Name:</label>
        <input type="text" name="company_name" id="company_name">
        <label for="tav">t.a.v.:</label>
        <input type="text" name="tav" id="tav">
        <label for="address">Address:</label>
        <input type="text" name="address" id="address">
        <label for="zip_code">Zip Code:</label>
        <input type="text" name="zip_code" id="zip_code">
        <label for="city">City:</label>
        <input type="text" name="city" id="city">
        <button type="submit">Create</button>
    </form>

</x-app-layout>
