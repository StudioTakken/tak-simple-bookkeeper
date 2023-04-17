<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $client = new Client;

        $client->email = $request->email;
        $client->company_name = $request->company_name;
        $client->tav = $request->tav;
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->zip_code = $request->zip_code;
        $client->city = $request->city;
        $client->save();
        return redirect()->route('clients.index')->with('success', 'Client created successfully!');
    }

    public function show($id)
    {
        $client = Client::find($id);
        return view('clients.show', compact('client'));
    }

    public function edit($id)
    {
        $client = Client::find($id);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $client = Client::find($id);


        $client->email = $request->email;
        $client->company_name = $request->company_name;
        $client->tav = $request->tav;
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->zip_code = $request->zip_code;
        $client->city = $request->city;

        $client->save();
        return redirect()->route('clients.edit', $client->id)
            ->with('success', 'Client has been updated.');
    }

    public function destroy($id)
    {
        $client = Client::find($id);
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully!');
    }
}
