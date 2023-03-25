<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
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


        if ($request->input('gb_rek') === 'ING') {

            $csv = $request->file('file');
            $csvName = time() . '.' . $csv->extension();
            $csv->move(public_path('csv'), $csvName);
            $importer->import(public_path('csv') . '/' . $csvName, $gb_rek);

            // remove the file
            unlink(public_path('csv') . '/' . $csvName);
        }


        if ($gb_rek == 'Debiteuren') {

            $csv = $request->file('file');
            $csvName = time() . '.' . $csv->extension();
            $csv->move(public_path('csv'), $csvName);

            $importer->import(public_path('csv') . '/' . $csvName, $gb_rek);

            // remove the file
            unlink(public_path('csv') . '/' . $csvName);
        }

        return response()->json(['success' => $csvName]);
    }
}
