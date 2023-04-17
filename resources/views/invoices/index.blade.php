<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            Invoices
        </h2>
    </x-slot>

    {{-- list the invoices --}}

    <div class="container mx-auto">
        <div class="py-6">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        {{ __('Date') }}</th>

                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        {{ __('Invoice Number') }}</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        {{ __('Client') }}</th>

                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        {{ __('Description') }}</th>


                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        {{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->invoice_nr }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->client->company_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->description }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->amount }}</td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <a href="{{ route('invoices.show', $invoice->id) }}"
                                                    class="mr-4 text-indigo-600 hover:text-indigo-900">{{ __('View') }}</a>
                                                <a href="{{ route('invoices.edit', $invoice->id) }}"
                                                    class="mr-4 text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                                <form action="{{ route('invoices.destroy', $invoice->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('{{ __('Are you sure you want to delete this invoice?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900">{{ __('Delete') }}</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




</x-app-layout>
