<?php

namespace App\Exports;

use App\Http\Controllers\BookingAccountController;
use App\Http\Traits\CompanyDetailsTrait;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BalanceExport extends BookingAccountController implements WithColumnFormatting, FromCollection, WithStyles, WithColumnWidths
{

    use CompanyDetailsTrait;

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
        array_unshift($this->balanceArray, ['Balans',  Session::get('startDate'), Session::get('stopDate'), ' ', Session::get('startDate'), Session::get('stopDate')]);


        // append a totals row
        $this->balanceArray['totals'] = $this->balanceTotals;

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

            if (isset($this->balanceArray[$key]['polarity']) and $this->balanceArray[$key]['polarity'] == -1) {
                // append four elements to the array, after the first element
                array_splice($this->balanceArray[$key], 1, 0, ['', '', '']);
            }

            // remove the polarity element
            if (isset($this->balanceArray[$key]['polarity'])) {
                unset($this->balanceArray[$key]['polarity']);
            }

            if ($key == 'totals') {



                if ($this->balanceArray['totals']['startEigenVermogen'] == 0) {
                    $this->balanceArray['totals']['startEigenVermogen'] = '0';
                } else {
                    $this->balanceArray['totals']['startEigenVermogen'] = $this->balanceArray['totals']['startEigenVermogen'] / 100;
                }
                if ($this->balanceArray['totals']['endEigenVermogen'] == 0) {
                    $this->balanceArray['totals']['endEigenVermogen'] = '0';
                } else {
                    $this->balanceArray['totals']['endEigenVermogen'] = $this->balanceArray['totals']['endEigenVermogen'] / 100;
                }

                if ($this->balanceArray['totals']['startChecksum'] == 0) {
                    $this->balanceArray['totals']['startChecksum'] = '0';
                } else {
                    $this->balanceArray['totals']['startChecksum'] = $this->balanceArray['totals']['startChecksum'] / 100;
                }
                if ($this->balanceArray['totals']['endChecksum'] == 0) {
                    $this->balanceArray['totals']['endChecksum'] = '0';
                } else {
                    $this->balanceArray['totals']['endChecksum'] = $this->balanceArray['totals']['endChecksum'] / 100;
                }



                $this->balanceArray['ev'] = [
                    'Eigen Vermogen',
                    ' ',
                    ' ',
                    ' ',
                    $this->balanceArray['totals']['startEigenVermogen'],
                    $this->balanceArray['totals']['endEigenVermogen']
                ];
                $this->balanceArray[] = [' ', '', '', '', '', ''];



                if ($this->balanceArray['totals']['startDebet'] == 0) {
                    $this->balanceArray['totals']['startDebet'] = '0';
                } else {
                    $this->balanceArray['totals']['startDebet'] = $this->balanceArray['totals']['startDebet'] / 100;
                }
                if ($this->balanceArray['totals']['endDebet'] == 0) {
                    $this->balanceArray['totals']['endDebet'] = '0';
                } else {
                    $this->balanceArray['totals']['endDebet'] = $this->balanceArray['totals']['endDebet'] / 100;
                }
                if ($this->balanceArray['totals']['startCredit'] == 0) {
                    $this->balanceArray['totals']['startCredit'] = '0';
                } else {
                    $this->balanceArray['totals']['startCredit'] = $this->balanceArray['totals']['startCredit'] / 100;
                }
                if ($this->balanceArray['totals']['endCredit'] == 0) {
                    $this->balanceArray['totals']['endCredit'] = '0';
                } else {
                    $this->balanceArray['totals']['endCredit'] = $this->balanceArray['totals']['endCredit'] / 100;
                }





                $this->balanceArray['totalsdisplay'] = [
                    'Totals',
                    $this->balanceArray['totals']['startDebet'],
                    $this->balanceArray['totals']['endDebet'],
                    '  ',
                    $this->balanceArray['totals']['startChecksum'],
                    $this->balanceArray['totals']['endChecksum']
                ];
            }
        }


        $this->boldRows[] = count($this->balanceArray) - 1;

        $this->balanceArray[] = [' ', '', '', '', '', ''];


        $resultDebet = $this->balanceArray['totals']['endDebet'] - $this->balanceArray['totals']['startDebet'];
        $resultCredit = $this->balanceArray['totals']['endCredit'] - $this->balanceArray['totals']['startCredit'];
        $result = $resultDebet - $resultCredit;
        $winst = $result - ($this->aBalanceConclusion['btw_verschil'] / 100) + ($this->aBalanceConclusion['prive_opnamen'] / 100);

        // remove the totals element
        unset($this->balanceArray['totals']);

        //  $this->balanceArray[] = ['', '', '', '', '', ''];
        /// resultaat, nog af te dragen belasting, winst of verlies
        $this->balanceArray[] = ['Resultaat', '', $result];
        $this->boldRows[] = count($this->balanceArray);

        $this->balanceArray[] = ['- Nog af te dragen BTW', '', ($this->aBalanceConclusion['btw_verschil'] / 100)];
        $this->balanceArray[] = ['+ Prive opname en belasting', '', ($this->aBalanceConclusion['prive_opnamen'] / 100)];
        $this->balanceArray[] = ['Winst', '', $winst];
        $this->boldRows[] = count($this->balanceArray);

        // we need to add an empty row
        $this->balanceArray[] = [''];
        $this->balanceArray[] = [''];

        # get the company details for the excel file 
        $aCompanyRows = $this->getCompanyDetailsForAsExcellRows('1');

        // append the company details to the balance array
        $this->balanceArray = array_merge($this->balanceArray, $aCompanyRows);






        return  collect($this->balanceArray);
    }


    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }



    public function styles(Worksheet $sheet)
    {

        foreach ($this->boldRows as $boldRow) {
            $sheet->getStyle('A' . ($boldRow) . ':F' . $boldRow)->getFont()->setBold(true);
        }


        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            // set alignment to right
            'B' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],
            'C' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],
            'E' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],
            'F' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],


        ];
    }



    public function columnWidths(): array
    {
        return [
            'A' => 32,
            'B' => 18,
            'C' => 18,
            'D' => 4,
            'E' => 18,
            'F' => 18,
        ];
    }
}
