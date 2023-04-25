<?php

namespace App\Http\Controllers;

use App\Models\BookingAccount;
use App\Models\BookingCategory;
use App\Http\Traits\CompanyDetailsTrait;

class DashboardController extends Controller
{

    use CompanyDetailsTrait;


    public function index()
    {

        // get all categories
        $categories = BookingCategory::all();


        // get all the booking accounts
        $accounts = BookingAccount::all();

        // company details
        $companyDetails = $this->getAllCompanyDetails();

        return view('dashboard', [
            'categories' => $categories,
            'accounts' => $accounts,
            'companyDetails' => $companyDetails
        ]);
    }
}
