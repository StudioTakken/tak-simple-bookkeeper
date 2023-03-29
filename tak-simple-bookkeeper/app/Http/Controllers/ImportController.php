<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ImportController extends Controller
{
    public function index()
    {
        session(['viewscope' => 'importeren']);
        return view('bookings.import');
    }

    /**
     * @param Request $request 
     * @param BookingController $importer 
     * @return JsonResponse 
     * @throws BindingResolutionException 
     * @throws FileException 
     */
    public function store(Request $request, BookingController $importer)
    {

        // get the post 'gb_rek' value from the form    
        $gb_rek = $request->input('gb_rek');
        $prove = $request->input('prove');



        if ($request->input('gb_rek') === 'ING') {

            $csv = $request->file('file');
            $fileName = time() . '.' . $csv->extension();
            $csv->move(public_path('csv'), $fileName);
            $importer->import(public_path('csv') . '/' . $fileName, $gb_rek);

            // remove the file
            unlink(public_path('csv') . '/' . $fileName);
        }


        if ($gb_rek == 'Debiteuren') {

            $csv = $request->file('file');
            $fileName = time() . '.' . $csv->extension();
            $csv->move(public_path('csv'), $fileName);

            $importer->import(public_path('csv') . '/' . $fileName, $gb_rek);

            // remove the file
            unlink(public_path('csv') . '/' . $fileName);
        }


        if ($prove == 'booking') {

            $booking_id = $request->input('booking_id');
            $upload = $request->file('file');
            $fileName = time() . '.' . $upload->extension();

            // remove all non standard characters
            $fileCalled = preg_replace('/[^A-Za-z0-9\-\.\s]/', '', $upload->getClientOriginalName());

            // all lower case
            $fileCalled = strtolower($fileCalled);

            // replace spaces with a dash
            $fileCalled = preg_replace('/\s/', '-', $fileCalled);

            // store
            Storage::put('prove/' . $booking_id . '/' . $fileCalled, $upload->getContent());
        }
        return response()->json(['success' => $fileName]);
    }
}
