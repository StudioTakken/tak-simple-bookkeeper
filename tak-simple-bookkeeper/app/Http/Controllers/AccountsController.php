<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountsController extends BookingController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // set the session variable viewscope to 'debiteuren'
        // session(['viewscope' => 'debiteuren']);
        //  return view('bookings.index', ['method' => 'debiteuren.index', 'include_children' => true]);

        return 'list of accounts';
    }



    public function onAccount($sAccount)
    {
        session(['viewscope' => $sAccount]);
        return view('bookings.index', ['method' => 'account.onaccount', 'include_children' => true]);
    }
}
