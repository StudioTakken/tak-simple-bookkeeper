<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ ucfirst($scope) }}
            </h2>
        </div>
    </x-slot>

    @livewire('date-settings')


    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif


    <div class="py-6">


        <a href="{{ route('bookings.import') }}">
            <x-button size="base" class="items-center gap-2">
                <x-heroicon-o-home aria-hidden="true" class="w-4 h-4" />
                <span>Import</span>
            </x-button>
        </a>


        {{-- <a href="{{ route('bookings.create') }}">
            <x-button size="base" class="items-center gap-2">
                <x-heroicon-o-home aria-hidden="true" class="w-4 h-4" />
                <span>Create</span>
            </x-button>
        </a> --}}

        <table class="min-w-full">
            <thead class="border-b">

                <tr>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Date</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Description</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-right">Bedrag Incl BTW
                    </th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-right">Bewerk</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-right">Bedrag Excl BTW
                    </th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-right">BTW</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Category</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Subcategory</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Account</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Tegenrekening</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Tags</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Remarks</th>
                </tr>
            </thead>


            @foreach ($bookings as $booking)
                @livewire('admin-row-booking', ['booking' => $booking])
            @endforeach
        </table>

    </div>
</x-app-layout>
