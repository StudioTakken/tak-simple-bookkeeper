<?php

namespace App\Http\Controllers;

use App\Exports\SummaryExport;
use App\Models\Booking;
use App\Models\BookingCategory;
use Maatwebsite\Excel\Facades\Excel;

class BookingCategoryController extends Controller
{
    public $categoryList = [];
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

        $this->setCategoryList($filter);

        $summary = [];
        $totals = [];
        $totals['name'] = 'totals';
        $totals['debet'] = 0;
        $totals['credit'] = 0;

        foreach ($this->categoryList as $category) {

            // if $category_key is in accountList, skip it
            if ($filter == 'venw' and $category->loss_and_provit == 0) {
                continue;
            }

            // for vat overview
            if ($filter == 'btw' and $category->vat_overview == 0) {
                continue;
            }

            if ($category->id == '') {
                $category->name = 'onbekend';
            }

            // get the sum of the bookings for this category where plus_min_int is 1
            $debet = Booking::period()->where('category', $category->id)->orderBy('date')->orderBy('id')->where('plus_min_int', '1')->sum('amount_inc');

            if ($debet > 0) {
                $totals['debet'] += $debet;
                $summary['debet'][$category->id]['name'] = $category->name;
                $summary['debet'][$category->id]['debetNr'] = $debet;
                $debet = number_format($debet / 100, 2, ',', '.');
                $summary['debet'][$category->id]['debet'] = $debet;
            }

            // get the sum of the bookings for this category where plus_min_int is -1
            $credit = Booking::period()->where('category', $category->id)->orderBy('date')->orderBy('id')->where('plus_min_int', '-1')->sum('amount_inc');

            if ($credit > 0) {
                $totals['credit'] += $credit;
                $summary['credit'][$category->id]['name'] = $category->name;
                $summary['credit'][$category->id]['creditNr'] = $credit;
                $credit = number_format($credit / 100, 2, ',', '.');
                $summary['credit'][$category->id]['credit'] = $credit;
            }
        }

        if (isset($summary['debet'])) {
            usort($summary['debet'], function ($a, $b) {
                return $b['debetNr'] <=> $a['debetNr'];
            });
        }

        if (isset($summary['credit'])) {
            usort($summary['credit'], function ($a, $b) {
                return $b['creditNr'] <=> $a['creditNr'];
            });
        }

        $totals['debetNr'] = $totals['debet'];
        $totals['creditNr'] = $totals['credit'];
        $totals['debet'] = number_format($totals['debet'] / 100, 2, ',', '.');
        $totals['credit'] = number_format($totals['credit'] / 100, 2, ',', '.');


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
        return view('bookings.summary', ['summary' => $summary]);
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
        return Excel::download(new SummaryExport, 'summary-' . $filter . '.xlsx');
    }
}
