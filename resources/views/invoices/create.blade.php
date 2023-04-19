<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            Invoices
        </h2>
    </x-slot>


    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex w-9/12">
                        <div class="flex-none">
                            <h2 class="text-xl font-semibold leading-tight">
                                Create new invoice
                            </h2>
                        </div>
                        <div class="flex-grow"></div>
                        <div class="flex-none">
                            <button class="settingsbutton soft">
                                <a href="{{ route('invoices.index') }}">
                                    Back to invoices
                                </a>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-auth-validation-errors class="mb-4" :errors="$errors" />


                    <form action="{{ route('invoices.store') }}" method="POST">
                        @csrf


                        <div class="flex flex-col gap-4">
                            {{-- add a pulldown for the client --}}
                            <div class="mt-4">
                                <x-label for="client">Client</x-label>
                                <select name="client_id" id="client_id" class="block w-full mt-1">

                                    <option value="">-- Kies een klant --</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">
                                            {{ $client->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="description">description</label>
                                <input type="text" name="description" id="description"
                                    value="{{ old('description') }}" />
                            </div>

                            <div class="flex items-center justify-end mt-4 space-x-4">
                                <x-button type="submit" class="ml-4">
                                    {{ __('Create') }}
                                </x-button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
