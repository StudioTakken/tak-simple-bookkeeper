<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Clients') }}
        </h2>
    </x-slot>



    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex ">
                        <div class="flex-none">
                            <h2 class="text-xl font-semibold leading-tight">
                                Edit Client {{ $client->company_name }}
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


                    @if (session()->has('success'))
                        <div class="my-5 alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif


                    <form action="{{ route('clients.update', $client) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="flex flex-col gap-2">


                            <div class="flex flex-col gap-2">
                                <x-label for="company_name">Company Name:</x-label>
                                <input class="w-full" type="text" name="company_name" id="company_name"
                                    value="{{ $client->company_name }}">
                            </div>
                            <div class="flex flex-col gap-2">
                                <x-label for="tav">t.a.v.:</x-label>
                                <input class="w-full" type="text" name="tav" id="tav"
                                    value="{{ $client->tav }}">
                            </div>
                            <div class="flex flex-col gap-2">
                                <x-label for="address">Address:</x-label>
                                <input class="w-full" type="text" name="address" id="address"
                                    value="{{ $client->address }}">
                            </div>
                            <div class="flex flex-col gap-2">
                                <x-label for="zip_code">Zip Code:</x-label>
                                <input class="w-full" type="text" name="zip_code" id="zip_code"
                                    value="{{ $client->zip_code }}">
                            </div>
                            <div class="flex flex-col gap-2">
                                <x-label for="city">City:</x-label>
                                <input class="w-full" type="text" name="city" id="city"
                                    value="{{ $client->city }}">
                            </div>
                            <div class="flex flex-col gap-2">
                                <x-label for="email">Email:</x-label>
                                <input class="w-full" type="email" name="email" id="email"
                                    value="{{ $client->email }}">
                            </div>
                            <div class="flex flex-col gap-2">
                                <x-label for="phone">Phone:</x-label>
                                <input class="w-full" type="text" name="phone" id="phone"
                                    value="{{ $client->phone }}">
                            </div>
                            <div class="flex items-center justify-end mt-4 space-x-4">
                                <x-button type="submit" class="ml-4">
                                    {{ __('Update') }}
                                </x-button>
                            </div>
                    </form>
                </div>

            </div>
        </div>
    </div>



</x-app-layout>
