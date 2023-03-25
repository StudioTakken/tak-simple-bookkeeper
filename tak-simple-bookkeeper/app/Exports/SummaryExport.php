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
        $summaryForExcel[$rn]['A'] = 'Categorie';
        $summaryForExcel[$rn]['B'] = 'Debet';
        $summaryForExcel[$rn]['C'] = 'Categorie';
        $summaryForExcel[$rn]['D'] = 'Credit';



        foreach ($summary as $listname => $list) {

            // debet, credit, totals
            if ($listname == 'debet') {
                $rn = 3;
                foreach ($list as $key => $row) {

                    if (!isset($summaryForExcel[$rn])) {
                        $summaryForExcel[$rn] = [];
                        $summaryForExcel[$rn]['A'] = '';
                        $summaryForExcel[$rn]['B'] = '';
                        $summaryForExcel[$rn]['C'] = '';
                        $summaryForExcel[$rn]['D'] = '';
                    }

                    $summaryForExcel[$rn]['A'] = $row['name'];
                    $summaryForExcel[$rn]['B'] = $row['debetNr'] / 100;
                    $rn++;
                }
            }
            // debet, credit, totals
            if ($listname == 'credit') {
                $rn = 3;
                foreach ($list as $key => $row) {

                    if (!isset($summaryForExcel[$rn])) {
                        $summaryForExcel[$rn] = [];
                        $summaryForExcel[$rn]['A'] = '';
                        $summaryForExcel[$rn]['B'] = '';
                        $summaryForExcel[$rn]['C'] = '';
                        $summaryForExcel[$rn]['D'] = '';
                    }

                    $summaryForExcel[$rn]['C'] = $row['name'];
                    $summaryForExcel[$rn]['D'] = $row['creditNr'] / 100;
                    $rn++;
                }
            }

            if ($listname == 'totals') {
                $summaryForExcel[$rn] = [];
                $summaryForExcel[$rn]['A'] = $list['name'];
                $summaryForExcel[$rn]['B'] = $list['debetNr'] / 100;
                $summaryForExcel[$rn]['C'] = '';
                $summaryForExcel[$rn]['D'] = $list['creditNr'] / 100;
            }
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
        return [

            1    => ['font' => ['bold' => true]],
            2    => ['font' => ['bold' => true]],

            'B' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],
            'D' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],


            // style the last row
            count($this->summaryForExcel) => ['font' => ['bold' => true]],
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
