<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Clients') }}
        </h2>

    </x-slot>
    <button class="settingsbutton soft"><a href="{{ route('clients.create') }}">Create
            Client</a></button>

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
                                        Company Name</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        t.a.v.</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Address</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Zip Code</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        City</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($clients as $client)
                                    <tr>


                                        <td class="px-6 py-4 whitespace-nowrap">{{ $client->company_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $client->tav }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $client->address }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $client->zip_code }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $client->city }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <div class="flex items-center">
                                                {{-- <button class="settingsbutton soft"><a
                                                        href="{{ route('clients.show', $client) }}">Show</a></button> --}}
                                                <button class="settingsbutton soft"><a
                                                        href="{{ route('clients.edit', $client) }}">Edit</a></button>

                                                @if (count($client->invoices) == 0)
                                                    <form action="{{ route('clients.destroy', $client) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="settingsbutton soft">Delete</button>
                                                    </form>
                                                @endif

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
