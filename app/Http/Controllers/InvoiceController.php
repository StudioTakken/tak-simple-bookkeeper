<?php

namespace App\Http\Controllers;


use App\Models\Client;
use App\Models\Invoice;
use Carbon\Carbon;
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
        // get the clients
        $clients = Client::all();
        return view('invoices.create', compact('clients'));
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
            'client_id' => 'required',
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

        if ($invoice->invoice_nr == '') {
            // get the higest invoice_nr and add 1

            // strip all non numeric characters
            $sMaxInvoiceNr = preg_replace('/[^0-9]/', '', Invoice::max('invoice_nr'));

            $invoice->suggested_invoice_nr = $sMaxInvoiceNr + 1;
        }

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


            // if the description is set and longer than 80 characters, cut it
            if (isset($aItems[$key]['description']) && strlen($aItems[$key]['description']) > 80) {
                $aItems[$key]['description'] = substr($aItems[$key]['description'], 0, 80) . '...';
            }



            $aItems[$key]['item_nr'] = $key;

            if (isset($aItems[$key]['rate'])) {
                $aItems[$key]['rate'] = Centify($aItems[$key]['rate']);
            }
            $aItems[$key]['item_amount'] = Centify($aItems[$key]['item_amount']);


            // if number is set and rate is set, calculate the item_amount
            if ($aItems[$key]['number'] != '' && $aItems[$key]['rate'] != '') {
                $aItems[$key]['item_amount'] = $aItems[$key]['number'] * $aItems[$key]['rate'];
            }

            $nTotal += $aItems[$key]['item_amount'];
        }


        if ($request->vat == '') {
            $request->merge(['vat' => 0]);
        }
        $invoice->vat = $request->vat;

        $nAmointVat = $nTotal * $invoice->vat / 100;
        $nAmointInc = $nTotal + $nAmointVat;

        $request->merge(['details' => json_encode($aItems)]);
        $request->merge(['amount' => $nTotal]);
        $request->merge(['amount_vat' => $nAmointVat]);
        $request->merge(['amount_inc' => $nAmointInc]);



        // validate the request
        $request->validate([
            'description' => 'required',
            'amount' => 'required',
        ]);


        // if set_date_to_now is set, set the date to now
        if ($request->set_date_to_now == 1) {
            $request->merge(['date' => date('Y-m-d')]);
        }
        if ($request->set_date_to_null == 1) {
            $request->merge(['date' => NULL]);
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
