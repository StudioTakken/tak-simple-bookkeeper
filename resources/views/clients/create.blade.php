<x-app-layout>
    <x-slot name="header"><br />
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Clients') }}
        </h2>
    </x-slot>


    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex w-9/12">
                        <div class="flex-none">
                            <h2 class="text-xl font-semibold leading-tight">
                                Create new Client
                            </h2>
                        </div>
                        <div class="flex-grow"></div>
                        <div class="flex-none">
                            <button class="settingsbutton soft">
                                <a href="{{ route('clients.index') }}">
                                    Back to clients
                                </a>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}

                    <x-validation-errors class="mb-4" :errors="$errors" />

                    <form action="{{ route('clients.store') }}" method="POST">
                        @csrf

                        <label for="company_name">Company Name:</label><br />
                        <input class="w-full" type="text" name="company_name" id="company_name"><br />
                        <label for="tav">t.a.v.:</label><br />
                        <input class="w-full" type="text" name="tav" id="tav"><br />
                        <label for="address">Address:</label><br />
                        <input class="w-full" type="text" name="address" id="address"><br />
                        <label for="zip_code">Zip Code:</label><br />
                        <input class="w-full" type="text" name="zip_code" id="zip_code"><br />
                        <label for="city">City:</label><br />
                        <input class="w-full" type="text" name="city" id="city"><br />


                        <label for="email">Email:</label><br />
                        <input class="w-full" type="email" name="email" id="email"><br />
                        <label for="phone">Phone:</label><br />
                        <input class="w-full" type="text" name="phone" id="phone"><br />

                        <div class="flex items-center justify-end mt-4 space-x-4">
                            <x-button type="submit" class="ml-4">
                                {{ __('Create') }}
                            </x-button>
                        </div>

                    </form>


                </div>
            </div>
        </div>



</x-app-layout>
