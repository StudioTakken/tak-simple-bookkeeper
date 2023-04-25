<?php

namespace App\Exports;

use App\Http\Controllers\InvoiceController;
use App\Models\Booking;
use App\Models\BookingAccount;
use App\Models\BookingCategory;
use App\Models\Client;
use App\Models\Invoice;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\Storage;

class InvoicePdfExport extends InvoiceController implements FromCollection
{
    public $my_pdf;
    public $preview;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
    }

    public function preview($id)
    {
        $this->preview = true;
        $this->download($id);
    }


    public function download($id)
    {
        $invoice = Invoice::find($id);
        $details = json_decode($invoice->details, true);
        $client = Client::find($invoice->client_id);

        if ($invoice->exported != '') {
            // do the download
            return response()->download(Storage::path($invoice->exported));
        }

        // preped zero's for invoice number (e.g. 00001)
        $invoice->invoice_nr = str_pad($invoice->invoice_nr, 5, '0', STR_PAD_LEFT);

        $filename = 'rekening_' . $invoice->invoice_nr . '.pdf';

        $this->my_pdf = new TCPDF('P', 'mm', 'A4');

        // set margins
        $this->my_pdf::SetMargins(15, 10, 15);
        $this->my_pdf::SetFooterMargin(10);

        // set auto page breaks
        $this->my_pdf::SetAutoPageBreak(TRUE, 10);

        $this->my_pdf::addPage();

        $this->Header();

        $this->my_pdf::SetFont('helvetica', '', 10);

        $sGeadresseerde =  $client->company_name . PHP_EOL;
        $sGeadresseerde .= 't.a.v. ' . $client->tav . PHP_EOL;
        $sGeadresseerde .= $client->address . PHP_EOL;
        $sGeadresseerde .= $client->city . PHP_EOL;

        $this->my_pdf::SetFont('dejavusans', '', 8);
        $this->my_pdf::setY('30');
        $this->my_pdf::setX('30');
        $this->my_pdf::MultiCell(0, 5, $sGeadresseerde . '', '', 'L');

        $this->my_pdf::setY('60');
        $this->my_pdf::SetFont('dejavusans', '', 8);
        $this->my_pdf::MultiCell(0, 2, "Factuurnummer: " . $invoice->invoice_nr . '', '', 'R');

        // add two weeks to the invoice date
        $twoweekslater = Carbon::parse($invoice->date)->addWeeks(2)->locale('nl')->isoFormat('LL');
        // format the date in dutch language with the Carbon library
        $invoicedDateFormatted = Carbon::parse($invoice->date)->locale('nl')->isoFormat('LL');

        $this->my_pdf::MultiCell(0, 2, "Datum: " . $invoicedDateFormatted . '', '', 'R');
        $this->my_pdf::SetFont('dejavusans', '', 8);

        $this->my_pdf::setY('80');
        $this->my_pdf::SetFont('dejavusans', 'B', 9);
        $this->my_pdf::MultiCell(0, 2, 'Rekening voor ' . $invoice->description . '', '', 'L');
        $this->my_pdf::SetFont('dejavusans', '', 8);

        $this->my_pdf::Ln();
        $this->my_pdf::Ln();

        $header = ['Omschrijving', 'Aantal', 'Tarief', 'Bedrag'];

        $details[] = ['sumline' => true];

        $subTotalRow = [
            'description' => 'Sub totaal',
            'number' => '',
            'rate' => '',
            'item_amount' => $invoice->amount
        ];
        $details[] = $subTotalRow;

        $vatRow = [
            'description' => 'Btw ' . $invoice->vat . '% over ' . number_format($invoice->amount / 100, 2, ',', '.') . '',
            'number' => '',
            'rate' => '',
            'item_amount' => $invoice->amount_vat
        ];
        $details[] = $vatRow;

        $details[] = ['sumline' => true];

        $amountIncRow = [
            'description' => 'Totaal inclusief btw',
            'number' => '',
            'rate' => '',
            'item_amount' => $invoice->amount_inc
        ];
        $details[] = $amountIncRow;

        $this->InvoiceTable($header, $details);

        $company = config('company');

        $this->my_pdf::MultiCell(0, 2, 'U wordt vriendelijk verzocht deze rekening voor ' . $twoweekslater . ' te voldoen.', '', 'L');
        $this->my_pdf::Ln();
        $this->my_pdf::Ln();
        $this->my_pdf::MultiCell(0, 2, 'Met vriendelijke groet,', '', 'L');
        $this->my_pdf::Ln();
        $this->my_pdf::MultiCell(0, 2, $company['person'] . '.', '', 'L');

        $this->Footer();

        if ($this->preview == true) {
            return $this->my_pdf::Output($filename, 'I');
        } else {

            // check if the invoices folder exists
            if (!file_exists(storage_path('app/invoices'))) {
                // create the invoices folder
                mkdir(storage_path('app/invoices'), 0755, true);
            }

            // set the path to the invoices folder storage/app/invoices
            $this->my_pdf::Output(storage_path('app/invoices/' . $filename), 'F');
            // return $this->my_pdf::Output($filename, 'I');

            // set the path in invoice->exported
            //    $invoice->exported = storage_path('app/invoices/' . $filename);
            $invoice->exported = 'invoices/' . $filename;
            $invoice->save();

            // make a booking for the invoice into the debiteuren account
            $booking = new Booking;

            // get the account_id of debiteuren
            $account = BookingAccount::where('slug', 'Debiteuren')->first();
            $booking->account = $account->named_id;

            // get the id of category 'inkomsten'
            $category = BookingCategory::where('slug', 'inkomsten')->first();
            $booking->category = $category->id;

            $booking->amount = $invoice->amount;
            $booking->description = $client->company_name . ": " . $invoice->description;
            $booking->date = $invoice->date;
            $booking->invoice_nr = $invoice->invoice_nr;


            $booking->save();

            // get last inserted id
            $id = $booking->id;
            if ($invoice->vat > 0) {
                Booking::find($id)->addBookingBtw('in', $invoice->vat);
            }

            // dont download the file, just redirect back to the referer
            return redirect()->back();

            // and then redirect to the invoices page ?
            // return response()->download(Storage::path($invoice->exported));
        }
    }




    function InvoiceTable($header, $data)
    {

        $this->my_pdf::SetLineStyle(array('width' => 0.1, 'cap' => 'none', 'join' => 'miter', 'dash' => 0, 'color' => array(80, 80, 80)));

        // Column widths
        $w = array(125, 12, 15, 20);

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

                if (isset($row['sumline'])) {

                    $this->my_pdf::Cell($w[0], 6, '', 'LR');
                    $this->my_pdf::Cell($w[1], 6, '', 'LR', 0, 'R');
                    $this->my_pdf::Cell($w[2], 6, '', 'LR', 0, 'R');
                    $this->my_pdf::Cell($w[3], 6, '__________', 'LR', 0, 'R');
                    $this->my_pdf::Ln();
                    continue;
                }
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

                if (isset($row['rate']) and $row['rate'] > 0) {
                    $row['rate'] = number_format((int)$row['rate'] / 100, 2, ',', '.');
                    $this->my_pdf::Cell($w[2], 6, $row['rate'], 'LR', 0, 'R');
                } else {
                    $this->my_pdf::Cell($w[2], 6, '', 'LR', 0, 'R');
                }

                if (isset($row['item_amount'])
                    //  && $row['item_amount'] != 0
                ) {

                    $row['item_amount'] = number_format((int)$row['item_amount'] / 100, 2, ',', '.');
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




    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->my_pdf::SetY(-30);
        // Set font
        $this->my_pdf::SetFont('dejavusans', 'I', 8);
        // Page number
        $this->my_pdf::Cell(195, 0, 'Pagina ' . $this->my_pdf::getAliasNumPage() . '/' . $this->my_pdf::getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');

        $this->my_pdf::SetFont('dejavusans', '', 8);
        $this->my_pdf::SetY(-25);

        // get the company details from the config/company file
        $company = config('company');
        $addressLine = $company['address'] . ' | ' . $company['zip'] . ' | ' . $company['city'];
        $other_contact_line = 'Email: ' . $company['email'] . ' | Website: ' . $company['website'] . ' | Telefoon: ' . $company['phone'];
        $bank_and_vat_ect_line = 'Bank: ' . $company['bankaccount'] . ', t.n.v. ' . $company['bankaccountname'] . ' | KvK: ' . $company['kvknumber'] . ' | BTW-ID: ' . $company['vatidnumber'];

        $this->my_pdf::MultiCell(0, 2, $company['name'], '', 'C');
        $this->my_pdf::MultiCell(0, 2, $addressLine, '', 'C');
        $this->my_pdf::MultiCell(0, 2, $other_contact_line, '', 'C');
        $this->my_pdf::MultiCell(0, 2, $bank_and_vat_ect_line, '', 'C');
    }



    //Page header
    public function Header()
    {

        $sLogo = config('company')['logopath'];

        // logo
        if (isset($sLogo) and $sLogo != '') {
            $myWidth = 60;
            $maxHeight = 20;

            // the path to the storage folder
            $sLogoPath = storage_path() . '/app/public' . $sLogo;

            if (file_exists($sLogoPath)) {

                $size = getimagesize($sLogoPath);

                $newWidth = ($size['0'] / $size['1']) * $maxHeight;

                if ($newWidth < $myWidth) {
                    $myWidth = $newWidth * 0.9;
                }
                // Insert a logo in the top-right corner
                $this->my_pdf::Image($sLogoPath, 130, 10, $myWidth);
            }
        }


        $this->my_pdf::SetMargins('20', '40');
    }
}
