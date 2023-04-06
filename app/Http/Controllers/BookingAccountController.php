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


        $this->balanceTotals['resultDebet'] = $this->balanceTotals['endDebet'] - $this->balanceTotals['startDebet'];
        $this->balanceTotals['resultCredit'] = $this->balanceTotals['endCredit'] - $this->balanceTotals['startCredit'];

        $this->balanceTotals['result'] = $this->balanceTotals['resultDebet'] - $this->balanceTotals['resultCredit'];

        $this->balanceTotals['btw_afdracht'] = $this->aBalanceConclusion['btw_verschil'];
        $this->balanceTotals['prive'] = $this->aBalanceConclusion['prive_opnamen'];
        $this->balanceTotals['winst'] = $this->balanceTotals['result'] - $this->aBalanceConclusion['btw_verschil']
            + $this->aBalanceConclusion['prive_opnamen'];



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
            $this->balanceArray[$account->named_id]['polarity'] = $account->polarity;
        }
    }


    public function balanceConclusion()
    {

        // get the total of bookingCategory btw-in
        // todo on slug, make a list in .env oid
        $btw_in_account = BookingCategory::where('named_id', 'btw')->first();
        $btw_out_account = BookingCategory::where('named_id', 'btw-uit')->first();

        $this->aBalanceConclusion['btw_in'] = Booking::period()->where('category', $btw_in_account->id)->orderBy('date')->orderBy('id')->sum('amount');
        $this->aBalanceConclusion['btw_uit'] = Booking::period()->where('category', $btw_out_account->id)->orderBy('date')->orderBy('id')->sum('amount');
        $this->aBalanceConclusion['btw_verschil'] = $this->aBalanceConclusion['btw_in'] - $this->aBalanceConclusion['btw_uit'];



        $prive_opnamen = 0;
        // get the bookingCategories that have on_balance = 0
        $not_on_balance = BookingCategory::where('on_balance', 0)->get();

        foreach ($not_on_balance as $nob_category) {
            $prive_opnamen += Booking::period()->where('category', $nob_category->id)->where('polarity', '-1')->orderBy('date')->orderBy('id')->sum('amount');
            $prive_opnamen -= Booking::period()->where('category', $nob_category->id)->where('polarity', '1')->orderBy('date')->orderBy('id')->sum('amount');
        }

        $this->aBalanceConclusion['prive_opnamen'] = $prive_opnamen;
    }


    public function balanceTotals()
    {
        $this->balanceTotals = [
            'name' => 'Totals',
            'startDebet' => 0,
            'endDebet' => 0,
            'startCredit' => 0,
            'endCredit' => 0,


        ];
        foreach ($this->balanceArray as $row) {

            if ($row['polarity'] == 1) {
                $this->balanceTotals['startDebet'] += $row['start'];
                $this->balanceTotals['endDebet'] += $row['end'];
            } else {
                $this->balanceTotals['startCredit'] += $row['start'];
                $this->balanceTotals['endCredit'] += $row['end'];
            }
        }

        // startEigenVermogen


        $this->balanceTotals['startEigenVermogen'] = $this->balanceTotals['startDebet'] - $this->balanceTotals['startCredit'];
        $this->balanceTotals['endEigenVermogen'] = $this->balanceTotals['endDebet'] - $this->balanceTotals['endCredit'];

        $this->balanceTotals['startChecksum'] =  $this->balanceTotals['startEigenVermogen'] + $this->balanceTotals['startCredit'];
        $this->balanceTotals['endChecksum'] =  $this->balanceTotals['endEigenVermogen'] + $this->balanceTotals['endCredit'];
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
