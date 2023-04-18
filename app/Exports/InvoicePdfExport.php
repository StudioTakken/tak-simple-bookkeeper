<?php

namespace App\Exports;

use App\Http\Controllers\InvoiceController;
use App\Models\Client;
use App\Models\Invoice;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Elibyy\TCPDF\Facades\TCPDF;


class InvoicePdfExport extends InvoiceController implements FromCollection
{


    public $my_pdf;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
    }



    public function download($id)
    {
        $invoice = Invoice::find($id);
        $details = json_decode($invoice->details, true);

        $client = Client::find($invoice->client_id);

        $filename = 'demo.pdf';
        $filename = 'invoice_' . $invoice->invoice_nr . '.pdf';

        $this->my_pdf = new TCPDF;

        $this->my_pdf::SetMargins(20, 10, 20, true);
        $this->my_pdf::addPage();

        $this->my_pdf::SetFont('helvetica', '', 10);


        $sGeadresseerde =  $client->company_name . PHP_EOL;
        $sGeadresseerde .= 't.a.v. ' . $client->tav . PHP_EOL;
        $sGeadresseerde .= $client->address . PHP_EOL;
        $sGeadresseerde .= $client->city . PHP_EOL;


        $this->my_pdf::SetFont('dejavusans', '', 9);
        $this->my_pdf::setY('30');
        $this->my_pdf::setX('30');
        $this->my_pdf::MultiCell(0, 5, $sGeadresseerde . '', '', 'L');

        $this->my_pdf::setY('60');
        $this->my_pdf::SetFont('dejavusans', '', 9);
        $this->my_pdf::MultiCell(0, 2, "Factuurnummer: " . $invoice->invoice_nr . '', '', 'R');

        // format the date in dutch language with the Carbon library
        $invoice->date = Carbon::parse($invoice->date)->locale('nl')->isoFormat('LL');

        $this->my_pdf::MultiCell(0, 2, "Datum: " . $invoice->date . '', '', 'R');
        $this->my_pdf::SetFont('dejavusans', '', 9);

        $this->my_pdf::setY('80');
        $this->my_pdf::SetFont('dejavusans', 'B', 9);
        $this->my_pdf::MultiCell(0, 2, 'Rekenng voor ' . $invoice->description . '', '', 'L');
        $this->my_pdf::SetFont('dejavusans', '', 9);


        $this->my_pdf::Ln();
        $this->my_pdf::Ln();


        $header = ['Omschrijving', 'Aantal', 'Tarief', 'Bedrag'];

        $details[] = [];
        $totalRow = [
            'description' => 'Totaal',
            'number' => '',
            'rate' => '',
            'item_amount' => $invoice->amount
        ];

        $details[] = $totalRow;

        $this->InvoiceTable($header, $details);

        $this->my_pdf::Output(public_path($filename), 'F');

        return response()->download(public_path($filename));
    }




    function InvoiceTable($header, $data)
    {

        // Column widths
        $w = array(100, 20, 25, 25);

        // Header
        for ($i = 0; $i < count($header); $i++) {
            if ($i == 0) { // eerste
                $this->my_pdf::Cell($w[$i], 7, $header[$i], 1, 0, 'L');
            } else {
                $this->my_pdf::Cell($w[$i], 7, $header[$i], 1, 0, 'R');
            }
        }

        $this->my_pdf::Ln();

        if ($data) {
            foreach ($data as $row) {
                if (isset($row['description'])) {
                    $this->my_pdf::Cell($w[0], 6, $row['description'], 'LR');
                } else {
                    $this->my_pdf::Cell($w[0], 6, '', 'LR');
                }

                if (isset($row['number'])) {
                    $this->my_pdf::Cell($w[1], 6, $row['number'], 'LR', 0, 'R');
                } else {
                    $this->my_pdf::Cell($w[1], 6, '', 'LR', 0, 'R');
                }

                if (isset($row['rate'])) {
                    $this->my_pdf::Cell($w[2], 6, $row['rate'], 'LR', 0, 'R');
                } else {
                    $this->my_pdf::Cell($w[2], 6, '', 'LR', 0, 'R');
                }

                if (isset($row['item_amount'])
                    //  && $row['item_amount'] != 0
                ) {
                    $this->my_pdf::Cell($w[3], 6, $row['item_amount'], 'LR', 0, 'R');
                } else {
                    $this->my_pdf::Cell($w[3], 6, '', 'LR', 0, 'R');
                }


                $this->my_pdf::Ln();
            }
            // Closing line
            $this->my_pdf::Cell(array_sum($w), 0, '', 'T');
            $this->my_pdf::Ln();
        }
    }
}
