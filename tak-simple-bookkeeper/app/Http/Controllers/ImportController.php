<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index()
    {
        return view('bookings.import', ['scope' => 'import']);
    }

    public function store(Request $request)
    {
        $image = $request->file('file');

        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images'), $imageName);

        return response()->json(['success' => $imageName]);
    }
}
