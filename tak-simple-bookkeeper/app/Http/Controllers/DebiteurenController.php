<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class DebiteurenController extends BookingController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // set the session variable viewscope to 'debiteuren'
        session(['viewscope' => 'debiteuren']);
        return view('bookings.index', ['method' => 'debiteuren.index', 'include_children' => true]);
    }
}
