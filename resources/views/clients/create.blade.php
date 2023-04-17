<x-app-layout>
    <x-slot name="header"><br />
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create Client') }}
        </h2>
    </x-slot>
    <form action="{{ route('clients.store') }}" method="POST">
        @csrf

        <label for="company_name">Company Name:</label><br />
        <input class="w-3/4" type="text" name="company_name" id="company_name"><br />
        <label for="tav">t.a.v.:</label><br />
        <input class="w-3/4" type="text" name="tav" id="tav"><br />
        <label for="address">Address:</label><br />
        <input class="w-3/4" type="text" name="address" id="address"><br />
        <label for="zip_code">Zip Code:</label><br />
        <input class="w-3/4" type="text" name="zip_code" id="zip_code"><br />
        <label for="city">City:</label><br />
        <input class="w-3/4" type="text" name="city" id="city"><br />


        <label for="email">Email:</label><br />
        <input class="w-3/4" type="email" name="email" id="email"><br />
        <label for="phone">Phone:</label><br />
        <input class="w-3/4" type="text" name="phone" id="phone"><br />

        <div class="flex items-center justify-end mt-4 space-x-4">
            <x-button type="submit" class="ml-4">
                {{ __('Create') }}
            </x-button>
        </div>


    </form>

</x-app-layout>
