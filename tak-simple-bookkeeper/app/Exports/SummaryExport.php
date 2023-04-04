<?php

namespace App\Exports;

use App\Http\Controllers\BookingCategoryController;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SummaryExport extends BookingCategoryController implements WithColumnFormatting, FromCollection, WithStyles, WithColumnWidths
{

    public $summaryForExcel = [];
    public $boldRows = [];

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // get session filter
        $this->filter = session('filter');

        if (!$this->filter) {
            $this->filter = 'inout';
        }
        $summary = $this->getSummary($this->filter);

        $rn = 0;
        $summaryForExcel = [];
        $summaryForExcel[$rn]['A'] = 'Samenvatting ' . $this->filterNames[$this->filter];
        $rn++;

        $summaryForExcel[$rn] = ['A' => '', 'B' => '', 'C' => '', 'D' => ''];
        $rn++;

        $summaryForExcel[$rn]['A'] = 'Categorie';
        $summaryForExcel[$rn]['B'] = 'Debet';
        $summaryForExcel[$rn]['C'] = 'Categorie';
        $summaryForExcel[$rn]['D'] = 'Credit';

        $rn++;
        $startRowBalance = $rn;
        $highestRowNr = $rn;


        foreach ($summary as $listname => $list) {

            // debet, credit, totals
            if ($listname == 'debet') {
                $rn =  $startRowBalance;
                foreach ($list as $key => $row) {

                    if (!isset($summaryForExcel[$rn])) {
                        $summaryForExcel[$rn] = [];
                        $summaryForExcel[$rn]['A'] = '';
                        $summaryForExcel[$rn]['B'] = '';
                        $summaryForExcel[$rn]['C'] = '';
                        $summaryForExcel[$rn]['D'] = '';
                    }

                    $summaryForExcel[$rn]['A'] = $row['name'];
                    $summaryForExcel[$rn]['B'] = $row['nDebet'] / 100;
                    $rn++;

                    if ($rn > $highestRowNr) {
                        $highestRowNr = $rn;
                    }
                }
            }
            // debet, credit, totals
            if ($listname == 'credit') {
                $rn =  $startRowBalance;
                foreach ($list as $key => $row) {

                    if (!isset($summaryForExcel[$rn])) {
                        $summaryForExcel[$rn] = [];
                        $summaryForExcel[$rn]['A'] = '';
                        $summaryForExcel[$rn]['B'] = '';
                        $summaryForExcel[$rn]['C'] = '';
                        $summaryForExcel[$rn]['D'] = '';
                    }

                    $summaryForExcel[$rn]['C'] = $row['name'];
                    $summaryForExcel[$rn]['D'] = $row['nCredit'] / 100;
                    $rn++;

                    if ($rn > $highestRowNr) {
                        $highestRowNr = $rn;
                    }
                }
            }

            $rn = $highestRowNr + 1;

            $rn++;

            $summaryForExcel[$rn] = ['A' => '', 'B' => '', 'C' => '', 'D' => ''];
            $rn++;


            if ($listname == 'totals') {

                $this->boldRows[] = $rn;
                $summaryForExcel[$rn] = [];
                $summaryForExcel[$rn]['A'] = 'Totaal In';
                $summaryForExcel[$rn]['B'] = $list['nDebet'] / 100;
                $summaryForExcel[$rn]['C'] = 'Totaal Uit';
                $summaryForExcel[$rn]['D'] = $list['nCredit'] / 100;
            }
        }
        $rn++;
        $summaryForExcel[$rn] = ['A' => '', 'B' => '', 'C' => '', 'D' => ''];
        $rn++;

        // if ($this->filter == 'inout') {
        //     $this->boldRows[] = $rn;
        //     $summaryForExcel[$rn]['A'] = '';
        //     $summaryForExcel[$rn]['B'] = '';
        //     $summaryForExcel[$rn]['C'] = 'Saldo';
        //     $summaryForExcel[$rn]['D'] = ($list['nDebet'] - $list['nCredit']) / 100;
        //     $rn++;
        // }


        if ($this->filter == 'venw') {
            // winst
            $this->boldRows[] = $rn;
            $summaryForExcel[$rn]['A'] = '';
            $summaryForExcel[$rn]['B'] = '';
            $summaryForExcel[$rn]['C'] = 'Winst';
            $summaryForExcel[$rn]['D'] = ($list['nDebet'] - $list['nCredit']) / 100;
            $rn++;
        }

        if ($this->filter == 'btw') {
            // btw
            $this->boldRows[] = $rn;
            $summaryForExcel[$rn]['A'] = '';
            $summaryForExcel[$rn]['B'] = '';
            $summaryForExcel[$rn]['C'] = 'BTW op inkomsten';
            $summaryForExcel[$rn]['D'] = ($list['nBtwDebet']) / 100;
            $rn++;

            $this->boldRows[] = $rn;
            $summaryForExcel[$rn]['A'] = '';
            $summaryForExcel[$rn]['B'] = '';
            $summaryForExcel[$rn]['C'] = 'Voorbelasting';
            $summaryForExcel[$rn]['D'] = ($list['nBtwCredit']) / 100;
            $rn++;

            $this->boldRows[] = $rn;
            $summaryForExcel[$rn]['A'] = '';
            $summaryForExcel[$rn]['B'] = '';
            $summaryForExcel[$rn]['C'] = 'Af te dragen';
            $summaryForExcel[$rn]['D'] = ($list['nBtwVerschil']) / 100;
            $rn++;
        }





        $this->summaryForExcel = $summaryForExcel;
        return collect($summaryForExcel);
    }


    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }



    public function styles(Worksheet $sheet)
    {

        foreach ($this->boldRows as $boldRow) {
            $sheet->getStyle('A' . ($boldRow - 1) . ':D' . $boldRow)->getFont()->setBold(true);
        }



        return [

            1    => ['font' => ['bold' => true]],
            2    => ['font' => ['bold' => true]],

            'B' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],
            'D' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],

        ];
    }



    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 18,
            'C' => 25,
            'D' => 18,
        ];
    }
}
