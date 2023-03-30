<?php

namespace App\Http\Controllers;

use App\Exports\BalanceExport;
use App\Models\BookingAccount;
use App\Exports\UsersExport;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Maatwebsite\Excel\Facades\Excel;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

class BookingAccountController extends Controller
{

    public $balanceArray = [];
    public $balanceTotals = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'list of accounts';
    }



    /**
     * 
     * This method is called when the user selects a booking account.
     * The selected booking account is stored in the session and the
     * bookings for the account are loaded.
     *
     * @param string $sAccount
     * @return \Illuminate\View\View
     */
    public function onAccount($sAccount)
    {
        // get the bookingaccount on the slug
        $account = BookingAccount::where('slug', $sAccount)->first();

        // store the account in the session
        session(['viewscope' => $account->named_id]);

        // return the view with the account
        return view('bookings.index', [
            'method' => 'account.onaccount',
            'include_children' => $account->include_children,
            'polarity' => $account->polarity,
            'account' => $account
        ]);
    }


    /**
     * 
     * @return View|Factory 
     * @throws BindingResolutionException 
     * @throws NotFoundExceptionInterface 
     * @throws ContainerExceptionInterface 
     */
    public function balance()
    {
        $this->balanceArray();
        $this->balanceTotals();


        // devide every internal array by 100 if it is a number
        foreach ($this->balanceArray as $key => $row) {
            if (isset($row['start']) and is_numeric($row['start'])) {
                $this->balanceArray[$key]['start'] = number_format($this->balanceArray[$key]['start'] / 100, 2, ',', '.');
            }
            if (isset($row['end']) and is_numeric($row['end'])) {
                $this->balanceArray[$key]['end'] = number_format($this->balanceArray[$key]['end'] / 100, 2, ',', '.');
            }
        }

        // $this->balanceArray[] = $this->balanceTotals;
        $this->balanceTotals['start'] = number_format($this->balanceTotals['start'] / 100, 2, ',', '.');
        $this->balanceTotals['end'] = number_format($this->balanceTotals['end'] / 100, 2, ',', '.');

        session(['viewscope' => 'balance']);

        return view('bookings.balance', ['balance' => $this->balanceArray, 'balancetotals' => $this->balanceTotals]);
    }


    public function balanceArray()
    {
        $accounts = BookingAccount::all();
        foreach ($accounts as $account) {
            $this->balanceArray[$account->named_id]['name'] = $account->name;
            $this->balanceArray[$account->named_id]['start'] = $account->balance('start');
            $this->balanceArray[$account->named_id]['end'] = $account->balance('end');
        }
    }


    public function balanceTotals()
    {
        $this->balanceTotals = ['name' => 'Totals', 'start' => 0, 'end' => 0];
        foreach ($this->balanceArray as $row) {
            $this->balanceTotals['start'] += $row['start'];
            $this->balanceTotals['end'] += $row['end'];
        }
    }





    public function balanceXlsx()
    {
        return Excel::download(new BalanceExport, 'balance.xlsx');
    }


    public function create()
    {
        return view('accounts.create');
    }


    // This function edits a record based on the id passed in.
    public function edit($id)
    {
        $account = BookingAccount::find($id);
        if ($account === null) {
            return redirect()->back()->with('message', 'Account not found');
        }
        return view('accounts.edit', ['account' => $account]);
    }
}
