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
use App\Http\Traits\BookingTrait;
use App\Models\BookingCategory;

class BookingsExport extends BookingController implements WithColumnFormatting, FromCollection, WithStyles, WithColumnWidths
{

    use bookingTrait;

    public $boldRows = [];

    public $viewscope;
    public $bookings;
    public $freshnow;

    public $debetStart; // saldo voor periode
    public $creditStart; // saldo voor periode

    public $debet;
    public $credit;

    public $include_children = true;
    public $method;
    public $bookingAccount;

    public $dateordering = 'asc';
    public $search;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {


        $this->viewscope = Session::get('viewscope');
        $this->method = Session::get('method');


        if ($this->viewscope == '') {
            $this->viewscope = config('bookings.main_booking_account');
        }

        // get bookings
        $this->getBookings();


        $aListOfBookings = [];
        $aListOfBookings['heading'] = [
            'date' => 'Datum',
            'account' => 'Rekening',
            'description' => 'Omschrijving',
            'debet' => 'debet',
            'credit' => 'credit',
            'category' => 'Categorie',
            'cross_account' => 'Cross account',

        ];
        $this->boldRows[] = count($aListOfBookings);


        foreach ($this->bookings as $key => $booking) {

            if ($booking->polarity == '-1') {
                $booking->credit = $booking->amount;
            } else {
                $booking->debet = $booking->amount;
            }

            $bookingCategory = BookingCategory::find($booking->category);
            if ($bookingCategory) {
                $sBookingCategory = $bookingCategory->name;
            } else {
                $sBookingCategory = '';
            }

            $aListOfBookings[$key] = [
                'date' => $booking->date,
                'account' => $booking->account,
                'description' => $booking->description,
                'debet' => $booking->debet / 100,
                'credit' => $booking->credit / 100,
                'category' => $sBookingCategory,
                'cross_account' => $booking->cross_account,
            ];
        }

        $aListOfBookings[] = ['', '', '', '', '', ''];



        $aListOfBookings[] = [
            '1' => '',
            '2' => '',
            '3' => '',
            '4' => '=sum(D2:D' . (count($aListOfBookings) - 1) . ')',
            '5' => '=sum(E2:E' . (count($aListOfBookings) - 1) . ')',
            '6' => '',
            '7' => '',
        ];



        $this->boldRows[] = count($aListOfBookings);


        // empty row
        $aListOfBookings[] = ['', '', '', '', '', ''];
        $aListOfBookings[] = ['', '', '', '', '', ''];


        $bookingAccount = $this->getBookingAccountTotals();


        if (session('method') == 'account.onaccount') {


            $aListOfBookings[] = [
                '1' => '',
                '2' => '',
                '3' => 'Balans ' . session('startDate'),
                '4' => $bookingAccount->start_balance / 100,
                '5' => '',
                '6' => '',
                '7' => '',
            ];

            $aListOfBookings[] = [
                '1' => '',
                '2' => '',
                '3' => 'Balans ' . session('stopDate'),
                '4' => $bookingAccount->end_balance / 100,
                '5' => '',
                '6' => '',
                '7' => '',
            ];
        }


        return collect($aListOfBookings);
    }


    public function columnFormats(): array
    {

        return [
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        foreach ($this->boldRows as $boldRow) {
            $sheet->getStyle('A' . ($boldRow) . ':G' . $boldRow)->getFont()->setBold(true);
        }
    }

    public function columnWidths(): array
    {

        return [
            'A' => 12,
            'B' => 20,
            'C' => 65,
            'D' => 12,
            'E' => 12,
            'F' => 20,
            'G' => 20,

        ];
    }
}
