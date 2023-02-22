<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //get bookings as collection
        $bookings = Booking::period()->get();
        return view('bookings.index', ['bookings' => $bookings, 'scope' => 'boekingen']);
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
        //
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


    public function import()
    {

        $imported_counter = 0;
        $imported_allready_counter = 0;

        // import the csv file
        $file = fopen("/Users/martintakken/WebsitesLocalWork/takBH/tak-simple-bookkeeper/storage/app/public/csv/bookings.csv", "r");
        $importData_arr = array();
        $row = 0;

        $colname = [];
        while (($filedata = fgetcsv($file, 1000, ";")) !== FALSE) {
            $num = count($filedata);

            // Skip first row (Remove below comment if you want to skip the first row)
            if ($row == 0) {

                for ($c = 0; $c < $num; $c++) {
                    $colname[$c] = $filedata[$c];
                }


                $row++;
                continue;
            }
            for ($c = 0; $c < $num; $c++) {
                $importData_arr[$row][$colname[$c]] = $filedata[$c];
            }
            $row++;
        }
        fclose($file);

        // Insert to MySQL database
        foreach ($importData_arr as $importData) {

            $importData['btw'] = 0;
            $importData['amount_inc'] = 0;



            $importData['plus_min_int'] = 1;

            if ($importData['Af Bij'] === 'Bij') {
                $importData['plus_min'] = 'plus';
                $importData['plus_min_int'] = 1;
                // dd($importData['Af Bij']);
            } elseif ($importData['Af Bij'] === 'Af') {
                $importData['plus_min'] = 'min';
                $importData['plus_min_int'] = -1;
            }


            // make the value form comma to dot
            $importData['Bedrag (EUR)'] = str_replace(',', '.', $importData['Bedrag (EUR)']);
            $importData['btw'] = str_replace(',', '.', $importData['btw']);
            $importData['amount_inc'] = str_replace(',', '.', $importData['amount_inc']);

            $importData['Bedrag (EUR)']           = Centify($importData['Bedrag (EUR)']);
            $importData['btw']              = Centify($importData['btw']);
            $importData['amount_inc']       = Centify($importData['amount_inc']);

            $insertData = array(

                "date" => $importData['Datum'],
                "account" => $importData['Rekening'],
                "contra_account" => $importData['Tegenrekening'],
                "description" => $importData['Naam / Omschrijving'],
                "plus_min" => $importData['plus_min'],
                "plus_min_int" => $importData['plus_min_int'],
                "invoice_nr" => '0',
                "bank_code" => $importData['Code'],
                "amount_inc" => (float)$importData['Bedrag (EUR)'],
                "btw" => $importData['btw'],
                "amount" => 0,
                "remarks" => $importData['Mededelingen'],
                "tag" => $importData['Tag'],
                "mutation_type" => $importData['Mutatiesoort'],
                "category" => '',
            );

            if (Booking::checkIfAllreadyImported($insertData)) {
                // count the number of bookings that are allready imported
                $imported_allready_counter++;
                continue;
            }

            $aOriginals = $insertData;

            // append $aOriginals with the original values
            $insertData['originals'] = $aOriginals;


            Booking::insertData($insertData);
            // count the number of bookings that are imported
            $imported_counter++;
        }

        return redirect()->route('bookings.index')
            ->with('success', 'Bookings imported successfully. (geimporteerd: ' . $imported_counter . ', al geïmporteerd: ' . $imported_allready_counter . ')');
    }
}
