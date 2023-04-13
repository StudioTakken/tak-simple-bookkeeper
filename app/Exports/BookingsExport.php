<?php

namespace App\Exports;

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class BookingsExport extends BookingController implements WithColumnFormatting, FromCollection, WithStyles, WithColumnWidths
{

    public $boldRows = [];

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
    }


    public function columnFormats(): array
    {

        return [
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        foreach ($this->boldRows as $boldRow) {
            $sheet->getStyle('A' . ($boldRow) . ':F' . $boldRow)->getFont()->setBold(true);
        }
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
            'G' => 18,
            'H' => 18,
        ];
    }
}
