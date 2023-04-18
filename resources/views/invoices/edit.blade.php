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

                    {{-- <div>
                        <x-label for="date">Date</x-label>
                        <x-input id="date" class="block w-full mt-1" type="date" name="date"
                            value="{{ $invoice->date }}" required autofocus />
                    </div> --}}

                    {{-- add a field for the invoice nr --}}
                    <div class="mt-4">
                        <x-label for="invoice_nr">Invoice Nr</x-label>
                        <x-input id="invoice_nr" class="block w-full mt-1" type="text" name="invoice_nr"
                            value="{{ $invoice->invoice_nr }}" autofocus />
                    </div>



                    {{-- add a pulldown for the client --}}
                    <div class="mt-4">
                        <x-label for="client">Client</x-label>
                        <select name="client_id" id="client_id" class="block w-full mt-1">

                            <option value="">-- Kies een klant --</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" @if ($client->id == $invoice->client_id) selected @endif>
                                    {{ $client->company_name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="flex w-full mt-4 space-x-4">
                        <div class="w-3/4 mt-4">

                            <x-label for="description">Description</x-label>

                            <x-input id="description" class="block w-full mt-1" type="text" name="description"
                                value="{{ $invoice->description }}" required />
                        </div>

                        <div class="w-1/4 mt-4 text-align">
                            <x-label for="Amount" class="text-right">Total amount</x-label>

                            <x-input id="amount" class="block w-full mt-1 text-right" type="text" name="amount"
                                value="{{ number_format($invoice->amount / 100, 2, ',', '.') }}" required disabled />
                        </div>


                    </div>



                    <div class="mt-20">


                        @if ($details)

                            @foreach ($details as $detail)
                                <div class="flex w-full mt-4 space-x-4">

                                    <div class="w-1/12">
                                        <x-label for="item_nr">Item_nr</x-label>
                                        <x-input id="item_nr" class="block w-full mt-1" type="text"
                                            name="items[{{ $detail->item_nr }}][item_nr]"
                                            value="{{ $detail->item_nr }}" disabled />
                                    </div>
                                    <div class="w-9/12">
                                        <x-label for="description">description</x-label>
                                        <x-input id="description" class="block w-full mt-1" type="text"
                                            name="items[{{ $detail->item_nr }}][description]"
                                            value="{{ $detail->description }}" />
                                    </div>
                                    <div class="w-1/12">
                                        <x-label for="number" class="text-right">number</x-label>
                                        <x-input id="number" class="block w-full mt-1 text-right" type="text"
                                            name="items[{{ $detail->item_nr }}][number]"
                                            value="{{ $detail->number }}" />
                                    </div>
                                    <div class="w-1/12">
                                        <x-label for="rate" class="text-right">rate</x-label>
                                        <x-input id="rate" class="block w-full mt-1 text-right" type="text"
                                            name="items[{{ $detail->item_nr }}][rate]" value="{{ $detail->rate }}" />
                                    </div>
                                    <div class="w-2/12">
                                        <x-label for="item_amount" class="text-right">item_amount</x-label>
                                        <x-input id="item_amount" class="block w-full mt-1 text-right" type="text"
                                            name="items[{{ $detail->item_nr }}][item_amount]"
                                            value="{{ number_format($detail->item_amount / 100, 2, ',', '.') }}" />
                                    </div>

                                </div>
                            @endforeach
                        @else
                            @php
                                $detail = new stdClass();
                                $detail->item_nr = 0;
                            @endphp

                        @endif


                        @for ($i = $detail->item_nr + 1; $i < $detail->item_nr + 4; $i++)
                            <div class="flex w-full mt-4 space-x-4">

                                <div class="w-1/12">
                                    <x-label for="item_nr">Item_nr</x-label>
                                    <x-input id="item_nr" class="block w-full mt-1" type="text"
                                        name="items[{{ $i }}][item_nr]" value="{{ $i }}"
                                        disabled />
                                </div>
                                <div class="w-9/12">
                                    <x-label for="description">description</x-label>
                                    <x-input id="description" class="block w-full mt-1" type="text"
                                        name="items[{{ $i }}][description]" value="" />
                                </div>
                                <div class="w-1/12">
                                    <x-label for="number" class="text-right">number</x-label>
                                    <x-input id="number" class="block w-full mt-1 text-right" type="text"
                                        name="items[{{ $i }}][number]" value="" />
                                </div>
                                <div class="w-1/12">
                                    <x-label for="rate" class="text-right">rate</x-label>
                                    <x-input id="rate" class="block w-full mt-1 text-right" type="text"
                                        name="items[{{ $i }}][rate]" value="" />
                                </div>
                                <div class="w-2/12">
                                    <x-label for="item_amount" class="text-right">item_amount</x-label>
                                    <x-input id="item_amount" class="block w-full mt-1 text-right" type="text"
                                        name="items[{{ $i }}][item_amount]" value="" />
                                </div>

                            </div>
                        @endfor


                    </div>


                    <div class="flex w-full mt-4 space-x-4">



                        {{-- create a checkbox for setting the date to now --}}
                        {{-- show date field if dat is set --}}
                        @if ($invoice->date)
                            <div class="w-3/4 mt-4">
                                <x-label for="date">Date</x-label>
                                <x-input id="date" class="block w-full mt-1" type="date" name="date"
                                    value="{{ $invoice->date }}" required />
                            </div>
                        @else
                            <div class="w-1/4 mt-4">
                                <x-label for="Amount" class="">Set date to now on save</x-label>
                                <input id="set_date_to_now" class="" type="checkbox" name="set_date_to_now"
                                    value="1" />
                            </div>
                        @endif
                    </div>


                    <div class="flex items-center justify-end mt-4 space-x-4">



                        <x-button class="ml-4">
                            {{ __('Update') }}
                        </x-button>
                    </div>





                </form>

                <a href="{{ route('invoice.download', $invoice->id) }}">Download Invoice</a>

                {{-- <form action="{{ route('invoice.download') }}" method="POST">
                    @csrf
                    <button type="submit">Download Invoice</button>
                </form> --}}
            </div>
        </div>
    </div>
</x-app-layout>
