<?php

namespace App\Http\Controllers;

use App\Exports\BalanceExport;
use App\Models\BookingAccount;
use App\Exports\UsersExport;
use App\Models\Booking;
use App\Models\BookingCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

class BookingAccountController extends Controller
{

    public $balanceArray = [];
    public $balanceArrayExtern = [];
    public $balanceArrayNotInProvit = [];
    public $balanceTotals = [];
    public $aBalanceConclusion = [];

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
        if (isset($account->named_id)) {
            session(['viewscope' => $account->named_id]);
        }

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
        $this->balanceConclusion();


        $this->balanceTotals['result'] = $this->balanceTotals['end'] - $this->balanceTotals['start'];

        $this->balanceTotals['btw_afdracht'] = $this->aBalanceConclusion['btw_verschil'];
        $this->balanceTotals['prive'] = $this->aBalanceConclusion['prive_opnamen'];
        $this->balanceTotals['winst'] = $this->balanceTotals['result'] - $this->aBalanceConclusion['btw_verschil']
            + $this->aBalanceConclusion['prive_opnamen'];

        $this->balanceTotals['start'] = number_format($this->balanceTotals['start'] / 100, 2, ',', '.');
        $this->balanceTotals['end'] = number_format($this->balanceTotals['end'] / 100, 2, ',', '.');

        $this->balanceTotals['result'] = number_format($this->balanceTotals['result'] / 100, 2, ',', '.');
        $this->balanceTotals['btw_afdracht'] = number_format($this->balanceTotals['btw_afdracht'] / 100, 2, ',', '.');
        $this->balanceTotals['prive'] = number_format($this->balanceTotals['prive'] / 100, 2, ',', '.');
        $this->balanceTotals['winst'] = number_format($this->balanceTotals['winst'] / 100, 2, ',', '.');

        session(['viewscope' => 'balance']);

        $start = Session::get('startDate');
        // minus 1 day
        $start = date('Y-m-d', strtotime($start . ' -1 day'));
        $stop = Session::get('stopDate');

        return view(
            'bookings.balance',
            [
                'balance' => $this->balanceArray,
                'balancetotals' => $this->balanceTotals,
                'start' => $start,
                'stop' => $stop
            ]


        );
    }


    public function balanceArray()
    {
        $accounts = BookingAccount::all();

        foreach ($accounts as $account) {
            if ($account->intern == 0) {
                continue;
            }
            $this->balanceArray[$account->named_id]['name'] = $account->name;
            $this->balanceArray[$account->named_id]['start'] = $account->balance('start');
            $this->balanceArray[$account->named_id]['end'] = $account->balance('end');
        }
    }


    public function balanceConclusion()
    {

        // get the total of bookingCategory btw-in
        // todo on slug, make a list in .env oid
        $btw_in_account = BookingCategory::where('named_id', 'btw')->first();
        $btw_out_account = BookingCategory::where('named_id', 'btw-uit')->first();

        $this->aBalanceConclusion['btw_in'] = Booking::period()->where('category', $btw_in_account->id)->orderBy('date')->orderBy('id')->sum('amount_inc');
        $this->aBalanceConclusion['btw_uit'] = Booking::period()->where('category', $btw_out_account->id)->orderBy('date')->orderBy('id')->sum('amount_inc');
        $this->aBalanceConclusion['btw_verschil'] = $this->aBalanceConclusion['btw_in'] - $this->aBalanceConclusion['btw_uit'];



        $prive_opnamen = 0;
        // get the bookingCategories that have on_balance = 0
        $not_on_balance = BookingCategory::where('on_balance', 0)->get();

        foreach ($not_on_balance as $nob_category) {
            $prive_opnamen += Booking::period()->where('category', $nob_category->id)->where('polarity', '-1')->orderBy('date')->orderBy('id')->sum('amount_inc');
            $prive_opnamen -= Booking::period()->where('category', $nob_category->id)->where('polarity', '1')->orderBy('date')->orderBy('id')->sum('amount_inc');
        }

        $this->aBalanceConclusion['prive_opnamen'] = $prive_opnamen;
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
