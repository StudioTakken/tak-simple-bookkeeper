<x-app-layout>

    <x-slot name="header" class="py-0 my-0">
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


            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex ">
                    <div class="flex-none">
                        <h2 class="text-xl font-semibold leading-tight">
                            Edit Invoice: {{ $invoice->description }}
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


                <x-validation-errors class="mb-4" :errors="$errors" />


                @if (session()->has('success'))
                    <div class="my-5 alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif

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


                        @if ($invoice->invoice_nr == null)
                            Op basis van de laatst aangemaakte rekening zou ik rekening-nummer
                            {{ $invoice->suggested_invoice_nr }}
                            voorstellen. Maar je kunt hier ook van af wijken.
                            <x-input id="invoice_nr" class="block w-full mt-1" type="text" name="invoice_nr"
                                value="{{ $invoice->suggested_invoice_nr }}" autofocus />
                        @else
                            <x-input id="invoice_nr" class="block w-full mt-1" type="text" name="invoice_nr"
                                value="{{ $invoice->invoice_nr }}" autofocus />
                        @endif

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



                    <div class="mt-4 ">

                        <x-label for="description">Description</x-label>

                        <x-input id="description" class="block w-full mt-1" type="text" name="description"
                            value="{{ $invoice->description }}" required />
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
                                            maxlength="100" name="items[{{ $detail->item_nr }}][description]"
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
                                            name="items[{{ $detail->item_nr }}][rate]"
                                            value="{{ number_format($detail->rate / 100, 2, ',', '.') }}" />
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





                    <div class="flex w-full mt-20 space-x-4">


                        {{-- add a dropdown for the vat, with 0, 6 or 21 as possible values --}}
                        <div class="w-1/4 mt-4">
                            <x-label for="vat">BTW</x-label>
                            <select name="vat" id="vat" class="block w-full mt-1">
                                <option value="0" @if ($invoice->vat == 0) selected @endif>0 %</option>
                                <option value="6" @if ($invoice->vat == 9) selected @endif>9 %</option>
                                <option value="21" @if ($invoice->vat == 21) selected @endif>21 %</option>
                            </select>
                        </div>


                        <div class="w-1/4 mt-4 text-align">
                            <x-label for="Amount" class="text-right">Total amount</x-label>
                            <x-input id="amount" class="block w-full mt-1 text-right" type="text"
                                name="amount" value="{{ number_format($invoice->amount / 100, 2, ',', '.') }}"
                                required disabled />
                        </div>


                        {{-- add a field for the vat amount --}}
                        <div class="w-1/4 mt-4 text-align">
                            <x-label for="amount_vat" class="text-right">BTW bedrag</x-label>
                            <x-input id="amount_vat" class="block w-full mt-1 text-right" type="text"
                                name="amount_vat"
                                value="{{ number_format($invoice->amount_vat / 100, 2, ',', '.') }}" required
                                disabled />
                        </div>

                        {{-- add a field for the amount including vat --}}
                        <div class="w-1/4 mt-4 text-align">
                            <x-label for="amount_inc" class="text-right">Bedrag inclusief BTW</x-label>
                            <x-input id="amount_inc" class="block w-full mt-1 text-right" type="text"
                                name="amount_inc"
                                value="{{ number_format($invoice->amount_inc / 100, 2, ',', '.') }}" required
                                disabled />
                        </div>

                    </div>




                    <div class="flex w-full mt-4 space-x-4">

                        @if ($invoice->date)
                            <div class="w-1/4 mt-4">
                                <x-label for="date">Date</x-label>
                                <x-input id="date" class="block w-full mt-1" type="date" name="date"
                                    value="{{ $invoice->date }}" required />
                            </div>

                            <div class="w-2/4 mt-4">
                                <input id="set_date_to_null" class="" type="checkbox" name="set_date_to_null"
                                    value="1" />
                                <x-label for="Amount" class="">Zet de datum terug op nul, zodat je de preview
                                    nog eens kunt zien.
                                </x-label>

                            </div>
                        @else
                            <div class="w-2/4 mt-4">
                                <x-label for="Amount" class="">Zet de datum op vandaag bij opslaan, als je
                                    klaar bent en de preview
                                    hebt gezien.<br />
                                </x-label>
                                <input id="set_date_to_now" class="" type="checkbox" name="set_date_to_now"
                                    value="1" />
                            </div>
                        @endif
                    </div>


                    <div class="flex items-center justify-end mt-4 space-x-4">


                        @if ($invoice->exported)
                        @else
                            <x-button class="ml-4">
                                {{ __('Update/Save') }}
                            </x-button>
                        @endif

                    </div>

                </form>





                <div class="flex">
                    @if ($invoice->exported)
                        <div class="w-2/4 mt-5">
                            <i>LET OP: Deze rekening is al geëxporteerd.<br />Je kunt de rekening niet meer
                                aanpassen.</i>
                            <br />


                            @if (Storage::exists($invoice->exported))
                                <i> {{ $invoice->exported }} </i><br />
                            @endif

                            <button class="settingsbutton soft">
                                <a target="new" href="{{ route('invoice.download', $invoice->id) }}">Download
                                    opgeslagen rekening</a>
                            </button>

                        </div>
                    @else
                        <div class="w-2/4 mt-5">

                            @if ($invoice->date)
                                <i>Hiermee wordt de rekening als pdf aangemaakt en opgenomen in
                                    debiteuren.</i><br />
                            @endif

                            <button class="settingsbutton soft">
                                @if ($invoice->date)
                                    <a href="{{ route('invoice.download', $invoice->id) }}">Maak
                                        rekening</a>
                                @else
                                    <a target="new" href="{{ route('invoice.preview', $invoice->id) }}">Preview
                                        concept</a>
                                @endif
                            </button>

                        </div>
                    @endif

                    @if ($invoice->exported)
                        <div class="w-2/4 mt-5 text-right">
                            <i>Ligt niet voor de hand omdat deze rekening al is geëxporteerd.<br />Weet wat je doet.</i>


                            <form action="{{ route('invoices.reset', $invoice->id) }}" method="POST"
                                onsubmit="return confirm('{{ __('Hiermee wordt de rekening terug gezet op onaf. Weet wat je doet!') }}')">
                                @csrf
                                @method('POST')
                                <button type="submit"
                                    class="text-red-600 hover:text-red-900 settingsbutton soft">{{ __('Reset') }}</button>
                            </form>

                            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST"
                                onsubmit="return confirm('{{ __('Verwijderen ligt niet voor de hand omdat deze rekening al is geëxporteerd. Weet wat je doet!') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-600 hover:text-red-900 settingsbutton soft">{{ __('Delete') }}</button>
                            </form>

                        </div>
                    @endif

                </div>




            </div>
        </div>
    </div>
</x-app-layout>
