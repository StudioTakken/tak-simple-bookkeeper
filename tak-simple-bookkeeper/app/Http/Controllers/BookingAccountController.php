<?php

namespace App\Http\Controllers;

use App\Models\BookingAccount;
use Illuminate\Http\Request;

class BookingAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'list of accounts';
    }



    public function onAccount($sAccount)
    {
        // get the bookingaccount on the slug
        $account = BookingAccount::where('slug', $sAccount)->first();

        session(['viewscope' => $account->named_id]);
        return view('bookings.index', ['method' => 'account.onaccount', 'include_children' => $account->include_children, 'account' => $account]);
    }

    public function balance()
    {

        // get all the bookingaccounts
        $accounts = BookingAccount::all();

        $balancetotals['start'] = 0;
        $balancetotals['end'] = 0;

        foreach ($accounts as $account) {



            $balance[$account->named_id]['name'] = $account->name;

            $balance[$account->named_id]['start'] = $account->balance('start');
            $balancetotals['start'] += $account->balance('start');
            $balance[$account->named_id]['end'] = $account->balance('end');
            $balancetotals['end'] += $account->balance('end');

            $balance[$account->named_id]['start'] = number_format($balance[$account->named_id]['start'] / 100, 2, ',', '.');
            $balance[$account->named_id]['end'] = number_format($balance[$account->named_id]['end'] / 100, 2, ',', '.');
        }


        $balancetotals['start'] = number_format($balancetotals['start'] / 100, 2, ',', '.');
        $balancetotals['end'] = number_format($balancetotals['end'] / 100, 2, ',', '.');



        session(['viewscope' => 'balance']);
        return view('bookings.balance', ['balance' => $balance, 'balancetotals' => $balancetotals]);
    }


    // edit 
    public function edit($id)
    {
        $account = BookingAccount::find($id);
        return view('accounts.edit', ['account' => $account]);
    }
}
