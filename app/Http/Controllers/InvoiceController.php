<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // list all invoices
        $invoices = Invoice::all();

        // pass the invoices to the view
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the request
        $request->validate([
            'invoice_nr' => 'required',
            'date' => 'required',
            'description' => 'required',
            'amount' => 'required',
        ]);

        // create the invoice
        $invoice = Invoice::create($request->all());

        // redirect to the invoice
        return redirect()->route('invoices.edit', $invoice);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        // get the invoice and pass it to the view
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {

        ddl('huh');
        // get the invoice and pass it to the view
        return view('invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        // validate the request
        $request->validate([
            'invoice_nr' => 'required',
            'date' => 'required',
            'description' => 'required',
            'amount' => 'required',
        ]);

        // update the invoice
        $invoice->update($request->all());

        // redirect to the invoice
        return redirect()->route('invoices.edit', $invoice);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        // delete the invoice
        $invoice->delete();

        // redirect to the invoice list
        return redirect()->route('invoices.index');
    }
}
