<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Exports\SummaryExport;
use Illuminate\Support\Carbon;
use App\Models\BookingCategory;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class BookingCategoryController extends Controller
{
    public $categoryList ;
    public $accountList = [];
    public $filter = false;

    public $filterNames = [
        'venw' => 'Verlies en winst',
        'btw' => 'Btw',
        'all' => 'In en uit',
        'inout' => 'In en uit',
    ];


    public function oncategory($sCategory)
    {
        session(['method' => 'oncategory']);

        $oCategory = BookingCategory::where('slug', $sCategory)->first();

        if ($oCategory) {
            session(['viewscope' => $oCategory->id]);
            return view('bookings.index', ['method' => 'oncategory', 'include_children' => false, 'category' => $oCategory]);
        } else {
            return view('bookings.sorry');
        }
    }

    /**
     *
     */
    public function listCategories()
    {
        $this->setCategoryList();
        return $this->categoryList;
    }

    public function setCategoryList()
    {
        $this->categoryList = BookingCategory::getAll();
    }




    public function getSummary($filter = false)
    {
        if ($filter == false) {
            $filter = 'venw';
            session(['filter' => $filter]);
        }

        $this->setCategoryList();

        $summary = [];
        $totals = [];
        $totals['name'] = 'totals';
        $totals['debet'] = 0;
        $totals['credit'] = 0;

        if ($filter == 'btw') {

            // get the category wiht named_id = btw
            $btw_cat = BookingCategory::where('named_id', 'btw')->first();
            $btw9_cat = BookingCategory::where('named_id', 'btw9')->first();
            $btw_uit_cat = BookingCategory::where('named_id', 'btw-uit')->first();
            $btw9_uit_cat = BookingCategory::where('named_id', 'btw-uit9')->first();

            // get the sum of the bookings for this category
            if ($btw_cat) {
                $nBtwDebet = Booking::period()->where('category', $btw_cat->id)->orderBy('date')->orderBy('id')->sum('amount');
            }
            if ($btw9_cat) {
                $nBtwDebet9 = Booking::period()->where('category', $btw9_cat->id)->orderBy('date')->orderBy('id')->sum('amount');
            }
            if ($btw_uit_cat) {
                $nBtwCredit = Booking::period()->where('category', $btw_uit_cat->id)->orderBy('date')->orderBy('id')->sum('amount');
            }
            if ($btw9_uit_cat) {
                $nBtwCredit += Booking::period()->where('category', $btw9_uit_cat->id)->orderBy('date')->orderBy('id')->sum('amount');
            }
            $nBtwVerschil = ($nBtwDebet + $nBtwDebet9) - $nBtwCredit;

            $totals['nBtwDebet'] = $nBtwDebet;
            $totals['nBtwDebet9'] = $nBtwDebet9;
            $totals['nBtwCredit'] = $nBtwCredit;
            $totals['nBtwVerschil'] = $nBtwVerschil;
        }




        $totals_cats = Booking::period()
            ->whereIn('category', $this->categoryList->pluck('id'))
            ->selectRaw('category, sum(case when polarity = 1 then amount else 0 end) as debet, sum(case when polarity = -1 then amount else 0 end) as credit')
            ->groupBy('category')
            ->get()
            ->pluck(null, 'category');


        foreach ($this->categoryList as $category) {

            // cross-posting altijd overslaan?
            if ($category->slug == 'cross-posting') {
                continue;
            }

            // if $category_key is in accountList, skip it
            if ($filter == 'venw' and $category->loss_profit_overview == 0) {
                continue;
            }

            // for vat overview
            if ($filter == 'btw' and $category->vat_overview == 0) {
                continue;
            }

            if ($category->id == '') {
                $category->name = 'onbekend';
            }

            if (isset($totals_cats[$category->id])) {
                $debet = $totals_cats[$category->id]['debet'];
                $credit = $totals_cats[$category->id]['credit'];
            } else {
                $debet = 0;
                $credit = 0;
            }


            if ($debet > 0) {
                $totals['debet'] += $debet;
                $summary['debet'][$category->id]['name'] = $category->name;
                $summary['debet'][$category->id]['nDebet'] = $debet;
                $summary['debet'][$category->id]['debet'] = $debet;
            }



            if ($credit > 0) {
                $totals['credit'] += $credit;
                $summary['credit'][$category->id]['name'] = $category->name;
                $summary['credit'][$category->id]['nCredit'] = $credit;
                $summary['credit'][$category->id]['credit'] = $credit;
            }
        }

        if ($filter != 'venw' and $filter != 'btw') {

            // extra category for bookings without a category
            $debet = Booking::period()->whereNull('category')->orderBy('date')->orderBy('id')->where('polarity', '1')->sum('amount');
            if ($debet > 0) {
                $totals['debet'] += $debet;
                $summary['debet'][0]['name'] = 'Geen categorie';
                $summary['debet'][0]['nDebet'] = $debet;
                $summary['debet'][0]['debet'] = $debet;
            }

            $credit = Booking::period()->whereNull('category')->orderBy('date')->orderBy('id')->where('polarity', '-1')->sum('amount');
            if ($credit > 0) {
                $totals['credit'] += $credit;
                $summary['credit'][0]['name'] = 'Geen categorie';
                $summary['credit'][0]['nCredit'] = $credit;
                $summary['credit'][0]['credit'] = $credit;
            }
        }





        if (isset($summary['debet'])) {
            usort($summary['debet'], function ($a, $b) {
                return $b['nDebet'] <=> $a['nDebet'];
            });
        }

        if (isset($summary['credit'])) {
            usort($summary['credit'], function ($a, $b) {
                return $b['nCredit'] <=> $a['nCredit'];
            });
        }

        $totals['nDebet'] = $totals['debet'];
        $totals['nCredit'] = $totals['credit'];
        $totals['result'] = $totals['debet'] - $totals['credit'];


        // add the totals to the summary array
        $summary['totals'] = $totals;

        return $summary;
    }



    /**
     * summary of category ins and outs
     */
    public function summary($filter = false)
    {
        session(['filter' => $filter]);
        $summary = $this->getSummary($filter);



        // how many days in the year are we?
        $nDaysInAYear = 365;

        if (Carbon::parse(Session::get('stopDate')) > Carbon::now()) {
            $nPeriodDays = Carbon::parse(Session::get('startDate'))->diffInDays(Carbon::now());
        } else {
            $nPeriodDays = Carbon::parse(Session::get('startDate'))->diffInDays(Carbon::parse(Session::get('stopDate')));
        }

        // so the total per day is?
        if ($nPeriodDays != 0) {
            $summary['totals']['resultPerDay'] = $summary['totals']['result'] / $nPeriodDays;
        } else {
            $summary['totals']['resultPerDay'] = 0;
        }

        // so the total per month is?
        $summary['totals']['resultPerMonth'] = $summary['totals']['resultPerDay'] * 30;

        // so that would be per year?
        $summary['totals']['resultPerYear'] = $summary['totals']['resultPerDay'] * $nDaysInAYear;


        return view('bookings.summary', ['summary' => $summary]);
    }



    public function create()
    {
        return view('categories.create');
    }




    // edit
    public function edit($id)
    {
        $category = BookingCategory::find($id);
        return view('categories.edit', ['category' => $category]);
    }


    public function summaryXlsx($filter = false)
    {
        session(['filter' => $filter]);
        return Excel::download(new SummaryExport(), 'summary-' . $filter . '.xlsx');
    }
}
