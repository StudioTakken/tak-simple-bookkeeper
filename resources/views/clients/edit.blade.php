<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Client') }}
        </h2>
    </x-slot>
    <form action="{{ route('clients.update', $client) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="email">Email:</label><br />
        <input class="w-5/6" type="email" name="email" id="email" value="{{ $client->email }}"><br />
        <label for="phone">Phone:</label><br />
        <input class="w-5/6" type="text" name="phone" id="phone" value="{{ $client->phone }}"><br />
        <label for="company_name">Company Name:</label><br />
        <input class="w-5/6" type="text" name="company_name" id="company_name"
            value="{{ $client->company_name }}"><br />
        <label for="tav">t.a.v.:</label><br />
        <input class="w-5/6" type="text" name="tav" id="tav" value="{{ $client->tav }}"><br />
        <label for="address">Address:</label><br />
        <input class="w-5/6" type="text" name="address" id="address" value="{{ $client->address }}"><br />
        <label for="zip_code">Zip Code:</label><br />
        <input class="w-5/6" type="text" name="zip_code" id="zip_code" value="{{ $client->zip_code }}"><br />
        <label for="city">City:</label><br />
        <input class="w-5/6" type="text" name="city" id="city" value="{{ $client->city }}"><br />


        <div class="flex items-center justify-end mt-4 space-x-4">
            <x-button type="submit" class="ml-4">
                {{ __('Update') }}
            </x-button>
        </div>

    </form>

</x-app-layout>
