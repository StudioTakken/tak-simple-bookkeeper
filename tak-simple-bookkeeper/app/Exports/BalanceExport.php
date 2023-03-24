<?php

namespace App\Exports;

use App\Http\Controllers\BookingAccountController;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BalanceExport extends BookingAccountController implements WithColumnFormatting, FromCollection, WithStyles, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $this->balanceArray();
        $this->balanceTotals();

        // prepend a header row
        array_unshift($this->balanceArray, ['Balans',  Session::get('startDate'), Session::get('stopDate')]);

        // add an empty row
        $this->balanceArray[] = ['', '', ''];

        // append a totals row
        $this->balanceArray[] = $this->balanceTotals;


        // devide every internal array by 100 if it is a number
        foreach ($this->balanceArray as $key => $row) {

            if (isset($row['start']) and is_numeric($row['start'])) {
                $this->balanceArray[$key]['start'] = $row['start'] / 100;
            }
            if (isset($row['end']) and is_numeric($row['end'])) {
                $this->balanceArray[$key]['end'] = $row['end'] / 100;
            }
        }



        return  collect($this->balanceArray);
    }


    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }



    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            //  'C'  => ['font' => ['size' => 16]],

            // set alignment to right
            'B' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],
            'C' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],


            // style the last row
            count($this->balanceArray) => ['font' => ['bold' => true]],
        ];
    }



    public function columnWidths(): array
    {
        return [
            'A' => 18,
            'B' => 18,
            'C' => 18,
        ];
    }
}
