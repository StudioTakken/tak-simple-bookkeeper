<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Invoice Details') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 sm:px-20">
                <div class="mt-8">
                    <p><strong>Id:</strong> {{ $invoice->id }}</p>
                    <p><strong>Date:</strong> {{ $invoice->date }}</p>
                    <p><strong>Invoice Number:</strong> {{ $invoice->invoice_nr }}</p>
                    <p><strong>Client:</strong>

                        @if ($invoice->client_id == null)
                            <span class="text-red-500">No client selected</span>
                        @else
                            <a
                                href='{{ route('clients.show', $invoice->client_id) }}'>{{ $invoice->client->company_name }}</a>
                        @endif

                    </p>

                    @if ($invoice->client_id == null or $invoice->client->tav == null)
                    @else
                        <p><strong>t.a.v.:</strong> {{ $invoice->client->tav }}</p>
                    @endif


                    <p><strong>Description:</strong> {{ $invoice->description }}</p>
                    <p><strong>Amount:</strong> {{ $invoice->amount }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
