<?php

namespace App\Http\Controllers;

use App\Models\Client;
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
            //   'invoice_nr' => 'required',
            //   'date' => 'required',
            'description' => 'required',
            //'amount' => 'required',
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
    public function show($id)
    {
        $invoice = Invoice::find($id);
        // get the invoice and pass it to the view
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $invoice = Invoice::find($id);
        $details = json_decode($invoice->details);
        $clients = Client::all();
        // get the invoice and pass it to the view
        return view('invoices.edit', compact('invoice', 'details', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Invoice $invoice)
    public function update(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        $nTotal = 0;
        $aItems = $request->items;

        // if there is no description, remove the item
        foreach ($aItems as $key => $item) {
            if ($aItems[$key]['description'] == '') {
                unset($aItems[$key]);
            }
        }

        foreach ($aItems as $key => $item) {
            $aItems[$key]['item_nr'] = $key;
            // if number is set and rate is set, calculate the item_amount
            if ($aItems[$key]['number'] != '' && $aItems[$key]['rate'] != '') {
                $aItems[$key]['item_amount'] = $aItems[$key]['number'] * $aItems[$key]['rate'];
            }


            $aItems[$key]['item_amount'] = Centify($aItems[$key]['item_amount']);
            $nTotal += $aItems[$key]['item_amount'];
        }

        $request->merge(['details' => json_encode($aItems)]);
        $request->merge(['amount' => $nTotal]);



        // validate the request
        $request->validate([
            'description' => 'required',
            'amount' => 'required',
        ]);


        // if set_date_to_now is set, set the date to now
        if ($request->set_date_to_now) {
            $request->merge(['date' => date('Y-m-d')]);
        }



        // update the invoice
        $invoice->update($request->all());

        if ($invoice->wasChanged()) {
            return redirect()->route('invoices.edit', $invoice->id)->with('success', 'Invoice updated successfully');
        } else {
            return redirect()->route('invoices.edit', $invoice->id)->with('error', 'Invoice update failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        // delete the invoice
        $invoice->delete();

        // redirect to the invoice list
        return redirect()->route('invoices.index');
    }
}
