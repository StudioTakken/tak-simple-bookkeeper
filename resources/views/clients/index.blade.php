<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Clients') }}
        </h2>
    </x-slot>

    <button class="settingsbutton soft"><a href="{{ route('clients.create') }}">Create Client</a></button>


    <table class="w-full">
        <thead>
            <tr>


                <th>Company Name</th>
                <th>t.a.v.</th>
                <th>Address</th>
                <th>Zip Code</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>


                    <td>{{ $client->company_name }}</td>
                    <td>{{ $client->tav }}</td>
                    <td>{{ $client->address }}</td>
                    <td>{{ $client->zip_code }}</td>
                    <td>{{ $client->city }}</td>
                    <td>

                        <button class="settingsbutton soft"><a
                                href="{{ route('clients.show', $client) }}">Show</a></button>
                        <button class="settingsbutton soft"><a
                                href="{{ route('clients.edit', $client) }}">Edit</a></button>

                        @if (count($client->invoices) == 0)
                            <form action="{{ route('clients.destroy', $client) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="settingsbutton soft">Delete</button>
                            </form>
                        @endif



                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


</x-app-layout>
