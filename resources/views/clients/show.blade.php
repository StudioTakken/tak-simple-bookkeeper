<h1>{{ $client->name }}</h1>
<p>Email: {{ $client->email }}</p>
<p>Phone: {{ $client->phone }}</p>
<p>Company Name: {{ $client->company_name }}</p>
<p>t.a.v.: {{ $client->tav }}</p>
<p>Address: {{ $client->address }}</p>
<p>Zip Code: {{ $client->zip_code }}</p>
<p>City: {{ $client->city }}</p>
<p>Created at: {{ $client->created_at }}</p>
<p>Updated at: {{ $client->updated_at }}</p>

<a href="{{ route('clients.edit', $client) }}">Edit</a>

<form action="{{ route('clients.destroy', $client) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">Delete</button>
</form>
