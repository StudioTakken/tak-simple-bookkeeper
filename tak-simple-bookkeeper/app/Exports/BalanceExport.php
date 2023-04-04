<?php

namespace App\Exports;

use App\Http\Controllers\BookingAccountController;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BalanceExport extends BookingAccountController implements WithColumnFormatting, FromCollection, WithStyles, WithColumnWidths
{

    public $boldRows = [];

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $this->balanceArray();
        $this->balanceTotals();
        $this->balanceConclusion();

        // prepend a header row
        array_unshift($this->balanceArray, ['Balans',  Session::get('startDate'), Session::get('stopDate')]);

        // add an empty row
        $this->balanceArray[] = ['', '', ''];

        // append a totals row
        $this->balanceArray[] = $this->balanceTotals;
        $this->boldRows[] = count($this->balanceArray);

        // devide every internal array by 100 if it is a number
        foreach ($this->balanceArray as $key => $row) {


            if (isset($row['start']) and is_numeric($row['start'])) {
                $this->balanceArray[$key]['start'] = $row['start'] / 100;
                if ($this->balanceArray[$key]['start'] == 0) {
                    $this->balanceArray[$key]['start'] = '0';
                }
            }

            if (isset($row['end']) and is_numeric($row['end'])) {
                $this->balanceArray[$key]['end'] = $row['end'] / 100;

                if ($this->balanceArray[$key]['end'] == 0) {
                    $this->balanceArray[$key]['end'] = '0';
                }
            }
        }

        $this->balanceArray[] = ['', '', ''];


        $result = $this->balanceArray[$key]['end'] - $this->balanceArray[$key]['start'];
        $winst = $result - ($this->aBalanceConclusion['btw_verschil'] / 100) + ($this->aBalanceConclusion['prive_opnamen'] / 100);

        /// resultaat, nog af te dragen belasting, winst of verlies
        $this->balanceArray[] = ['Resultaat', '', $result];
        $this->boldRows[] = count($this->balanceArray);
        $this->balanceArray[] = ['- Nog af te dragen BTW', '', ($this->aBalanceConclusion['btw_verschil'] / 100)];
        $this->boldRows[] = count($this->balanceArray);
        $this->balanceArray[] = ['+ Prive opname en belasting', '', ($this->aBalanceConclusion['prive_opnamen'] / 100)];
        $this->boldRows[] = count($this->balanceArray);
        $this->balanceArray[] = ['Winst', '', $winst];
        $this->boldRows[] = count($this->balanceArray);




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

        foreach ($this->boldRows as $boldRow) {
            $sheet->getStyle('A' . ($boldRow - 1) . ':C' . $boldRow)->getFont()->setBold(true);
        }


        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            // set alignment to right
            'B' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],
            'C' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],


        ];
    }



    public function columnWidths(): array
    {
        return [
            'A' => 32,
            'B' => 18,
            'C' => 18,
        ];
    }
}
