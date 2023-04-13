<?php

namespace App\Http\Controllers;

use App\Exports\BookingsExport;
use App\Models\Booking;
use App\Models\BookingCategory;
use App\Models\BookingProve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // set the session variable viewscope to 'bookings'
        session(['viewscope' => 'bookings']);
        return view('bookings.index', ['method' => 'bookingcontroller.index', 'include_children' => true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('bookings.edit', ['booking' => Booking::find($id), 'scope' => 'Edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function import($filePath, $gb_rek)
    {


        $imported_counter = 0;
        $imported_allready_counter = 0;

        $file = fopen($filePath, "r");
        $importData_arr = array();
        $row = 0;

        $colname = [];


        // if file is an xlsx file then read the xlsx file
        // it is dropped into the debitueren import field
        if ($gb_rek == 'Debiteuren') {
            if (pathinfo($filePath, PATHINFO_EXTENSION) === 'xlsx') {
                // read the xlsx file and put it in an array
                $reader = new Xlsx();
                $spreadsheet = $reader->load($filePath);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                // read line by line and put it in an array
                foreach ($sheetData as $sheetrow) {
                    $num = count($sheetrow);

                    // Skip first row (Remove below comment if you want to skip the first row)
                    if ($row == 0) {
                        foreach ($sheetrow as $key => $value) {
                            $mappedKey = $this->mapImportKey($sheetrow[$key], $gb_rek);
                            $colname[$key] = $mappedKey;
                        }
                        $row++;
                        continue;
                    } else {
                        foreach ($sheetrow as $key => $value) {

                            $importData_arr[$row][$colname[$key]] = $sheetrow[$key];

                            if (
                                $colname[$key] == 'date'
                                and
                                (!isset($importData_arr[$row][$colname[$key]])
                                    or $importData_arr[$row][$colname[$key]] == '')
                            ) {
                                //remove the row
                                unset($importData_arr[$row]);
                                continue 2;
                            }

                            $importData_arr[$row]['plus_min'] = 'Bij';
                            $importData_arr[$row]['account'] = 'Debiteuren';
                            $importData_arr[$row]['contra_account'] = '';
                            $importData_arr[$row]['bank_code'] = '';
                            $importData_arr[$row]['tag'] = '';
                            $importData_arr[$row]['remarks'] = '';
                            $importData_arr[$row]['mutation_type'] = '';
                        }
                        $importData_arr[$row]['description'] = $importData_arr[$row]['klant'] . ' - ' . $importData_arr[$row]['project'];
                        $row++;
                    }
                }
            }
        }

        // it is dropped in the bank import field
        if ($gb_rek == 'ING') {
            // bookings from bank
            while (($filedata = fgetcsv($file, 1000, ";")) !== FALSE) {
                $num = count($filedata);

                // Skip first row (Remove below comment if you want to skip the first row)
                if ($row == 0) {

                    for ($c = 0; $c < $num; $c++) {
                        $mappedKey = $this->mapImportKey($filedata[$c], $gb_rek);
                        $colname[$c] =  $mappedKey;
                    }

                    $row++;
                    continue;
                }

                for ($c = 0; $c < $num; $c++) {
                    $importData_arr[$row][$colname[$c]] = $filedata[$c];
                }

                // todo: categorien toewijzing obv omschrijving
                $importData_arr[$row]['invoice_nr'] = '';
                $row++;
            }
        }


        fclose($file);

        // bookings from my bank come in reverse order so I need to inverse the array
        if ($gb_rek == 'ING') {
            $importData_arr = array_reverse($importData_arr);
        }

        // Insert to MySQL database
        foreach ($importData_arr as $importData) {

            $importData['btw'] = 0;
            $importData['polarity'] = 1;

            if ($importData['plus_min'] === 'Bij') {
                $importData['plus_min'] = 'plus';
                $importData['polarity'] = 1;
            } elseif ($importData['plus_min'] === 'Af') {
                $importData['plus_min'] = 'min';
                $importData['polarity'] = -1;
            }

            // make the value form comma to dot
            $importData['amount'] = str_replace(',', '.', $importData['amount']);
            $importData['amount'] = Centify($importData['amount']);

            $insertData = array(
                "date" => date('Y-m-d', strtotime($importData['date'])),
                "account" => $importData['account'],
                "contra_account" => $importData['contra_account'],
                "description" => $importData['description'],
                "plus_min" => $importData['plus_min'],
                "polarity" => $importData['polarity'],
                "invoice_nr" => $importData['invoice_nr'],
                "bank_code" => $importData['bank_code'],
                "amount" => (float)$importData['amount'],
                "remarks" => $importData['remarks'],
                "tag" => $importData['tag'],
                "mutation_type" => $importData['mutation_type'],
                "category" => NULL,
            );



            if ($gb_rek == 'Debiteuren') {
                // get the id of category 'inkomsten'
                $oCategory = BookingCategory::where('slug', 'inkomsten')->first();
                $insertData['category'] =  $oCategory->id;
            }

            // add a hash to the booking
            $insertData['hashed'] = md5(serialize($insertData));

            if (Booking::checkIfAllreadyImported($insertData['hashed'])) {
                // count the number of bookings that are allready imported
                $imported_allready_counter++;
                continue;
            }

            $aOriginals = $insertData;

            // append $aOriginals with the original values
            $insertData['originals'] = $aOriginals;



            $id = Booking::insertData($insertData);

            // if it is a debiteuren booking then split the booking in 2 bookings
            if ($gb_rek == 'Debiteuren') {
                Booking::find($id)->addBookingBtw('in');
            }
            // count the number of bookings that are imported
            $imported_counter++;
        }
    }



    protected function mapImportKey($key, $gb_rek)
    {

        $map = [
            'Datum' => 'date',
            'Rekening' => 'account',
            'Tegenrekening' => 'contra_account',
            'klant' => 'klant',
            'Af Bij' => 'plus_min',
            'incl' => 'amount',
            'Mededelingen' => 'remarks',
            'Tag' => 'tag',
            'Mutatiesoort' => 'mutation_type',
            'Code' => 'bank_code',
            'Bedrag (EUR)' => 'amount',
            'Naam / Omschrijving' => 'description',
        ];


        if ($gb_rek == 'Debiteuren') {

            // remove the key incl
            unset($map['incl']);
            $map['excl']        = 'amount';  // we add the btw later
            $map['Rekening']    = 'invoice_nr';
        }

        if (isset($map[$key])) {
            return $map[$key];
        } else {
            return $key;
        }
    }


    /// download the file
    public function prove_download($fileId)
    {
        // get the booking_prove on id
        $oBookingProve = BookingProve::find($fileId);
        return  Storage::Download($oBookingProve->path, $oBookingProve->name);
    }


    public function bookingsXlsx()
    {
        return Excel::download(new BookingsExport, 'bookings.xlsx');
    }
}
