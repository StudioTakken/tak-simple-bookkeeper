<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Bookings') }}
            </h2>


        </div>
    </x-slot>


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
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Date</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Description</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-right">Bedrag
                    </th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-right">Bedrag
                        Inc BTW</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-right">BTW</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Category</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Subcategory</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Account</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Tegenrekening</th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Tags</th>
                </tr>
            </thead>


            @foreach ($bookings as $booking)
                {{-- create a table with the following columns: date, description, amount, category, subcategory, account, tags --}}
                <tr>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $booking->date }}</td>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $booking->description }}
                    </td>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-right">
                        {{ number_format($booking->amount / 100, 2, ',', '.') }}
                    </td>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-right">
                        {{ number_format($booking->amount_inc / 100, 2, ',', '.') }}
                    </td>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-right">
                        {{ number_format($booking->btw / 100, 2, ',', '.') }}
                    </td>

                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $booking->category }}
                    </td>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $booking->subcategory }}
                    </td>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                        {{ $booking->account }}
                    </td>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                        {{ $booking->contra_account }}</td>

                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $booking->tags }}</td>
                </tr>
            @endforeach
        </table>


        {{-- 

        @php
            $variants = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'black'];
            
            $sizes = ['sm', 'base', 'lg'];
        @endphp


        <div class="grid items-center gap-4">
            @foreach ($variants as $variant)
                <div class="grid items-start grid-cols-3 gap-4 justify-items-center">
                    @foreach ($sizes as $size)
                        <x-button :variant="$variant" size="{{ $size }}" class="items-center gap-2">
                            <x-heroicon-o-home aria-hidden="true"
                                class="{{ $size == 'sm' ? 'w-4 h-4' : ($size == 'base' ? 'w-6 h-6' : 'w-7 h-7') }}" />

                            <span>Button</span>
                        </x-button>
                    @endforeach
                </div>
            @endforeach
        </div> --}}

    </div>
</x-app-layout>
