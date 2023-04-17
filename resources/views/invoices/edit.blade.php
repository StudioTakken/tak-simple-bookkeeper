<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Invoice') }}
        </h2>
    </x-slot>

    <div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">


        <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">



            @if (session('success'))
                <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded"
                    role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="relative px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif



            <div class="p-6 bg-white border-b border-gray-200 sm:px-20">
                <form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-label for="date">Date</x-label>

                        <x-input id="date" class="block w-full mt-1" type="date" name="date"
                            value="{{ $invoice->date }}" required autofocus />
                    </div>

                    <div class="mt-4">

                        <x-label for="description">Description</x-label>

                        <x-input id="description" class="block w-full mt-1" type="text" name="description"
                            value="{{ $invoice->description }}" required />
                    </div>



                    <div class="mt-4">
                        <x-label for="Amount">Amount</x-label>

                        <x-input id="amount" class="block w-full mt-1" type="text" name="amount"
                            value="{{ $invoice->amount }}" required />
                    </div>

                    <div class="mt-4">

                        Items here ...

                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Update') }}
                        </x-button>
                    </div>





                </form>
            </div>
        </div>
    </div>
</x-app-layout>
