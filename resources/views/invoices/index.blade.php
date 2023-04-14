<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            Invoices
        </h2>
    </x-slot>

    {{-- list the invoices --}}

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex w-9/12">
                        <div class="flex-none">
                            <h2 class="text-xl font-semibold leading-tight">
                                Invoices
                            </h2>
                        </div>
                        <div class="flex-grow"></div>
                        <div class="flex-none">
                            <button class="settingsbutton soft">
                                <a href="{{ route('invoices.create') }}">
                                    Create new invoice
                                </a>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="w-full table-auto">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Description</th>
                                <th class="px-4 py-2">Amount</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $invoice->id }}</td>
                                    <td class="px-4 py-2 border">{{ $invoice->name }}</td>
                                    <td class="px-4 py-2 border">{{ $invoice->description }}</td>
                                    <td class="px-4 py-2 border">{{ $invoice->amount }}</td>
                                    <td class="px-4 py-2 border">
                                        <button class="settingsbutton soft">
                                            <a href="{{ route('invoices.edit', $invoice->id) }}">
                                                Edit
                                            </a>
                                        </button>
                                        <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="settingsbutton soft">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>




</x-app-layout>
