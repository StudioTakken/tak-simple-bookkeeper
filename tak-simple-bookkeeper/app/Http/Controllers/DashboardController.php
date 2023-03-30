<?php

namespace App\Http\Controllers;

use App\Models\BookingAccount;
use App\Models\BookingCategory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        // get all categories
        $categories = BookingCategory::all();


        // get all the booking accounts
        $accounts = BookingAccount::all();


        return view('dashboard', [
            'categories' => $categories,
            'accounts' => $accounts
        ]);
    }
}
