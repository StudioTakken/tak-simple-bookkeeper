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
                    <p><strong>Client:</strong> <a
                            href='{{ route('clients.show', $invoice->client_id) }}'>{{ $invoice->client->company_name }}</a>
                    </p>
                    <p><strong>t.a.v.:</strong> {{ $invoice->client->tav }}</p>
                    <p><strong>Description:</strong> {{ $invoice->description }}</p>
                    <p><strong>Amount:</strong> {{ $invoice->amount }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
