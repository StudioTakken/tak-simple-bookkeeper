<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Clients') }}
        </h2>
    </x-slot>
    <a href="{{ route('clients.create') }}">Create Client</a>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
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
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->company_name }}</td>
                    <td>{{ $client->tav }}</td>
                    <td>{{ $client->address }}</td>
                    <td>{{ $client->zip_code }}</td>
                    <td>{{ $client->city }}</td>
                    <td>
                        <a href="{{ route('clients.show', $client) }}">Show</a>
                        <a href="{{ route('clients.edit', $client) }}">Edit</a>
                        <form action="{{ route('clients.destroy', $client) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


</x-app-layout>
