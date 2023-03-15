<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingCategory;
use Illuminate\Http\Request;

class BookingCategoryController extends Controller
{
    public $categoryList = [];
    public $accountList = [];


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








    /**
     * summary of category ins and outs
     */
    public function summary($filter = false)
    {
        $this->setCategoryList();



        $summery = [];
        $totals = [];
        $totals['debet'] = 0;
        $totals['credit'] = 0;

        foreach ($this->categoryList as $category) {

            // kruispost hoeft nooit
            if ($category->named_id == 'kruispost') {
                //    continue;
            }

            // if $category_key is in accountList, skip it
            if ($filter == 'venw' and $category->loss_and_provit == 0) {
                continue;
            }

            // for vat overview
            if ($filter == 'btw' and $category->vat_overview == 0) {
                continue;
            }


            if ($category->named_id == 'unknown') {
                $category->named_id = '';
            }


            // get the sum of the bookings for this category where plus_min_int is 1
            $debet = Booking::period()->where('category', $category->named_id)->orderBy('date')->orderBy('id')->where('plus_min_int', '1')->sum('amount_inc');

            if ($debet > 0) {
                $totals['debet'] += $debet;
                $summery['debet'][$category->named_id]['name'] = $category->name;
                $summery['debet'][$category->named_id]['debetNr'] = $debet;
                $debet = number_format($debet / 100, 2, ',', '.');
                $summery['debet'][$category->named_id]['debet'] = $debet;
            }

            // get the sum of the bookings for this category where plus_min_int is -1
            $credit = Booking::period()->where('category', $category->named_id)->orderBy('date')->orderBy('id')->where('plus_min_int', '-1')->sum('amount_inc');

            if ($credit > 0) {
                $totals['credit'] += $credit;
                $summery['credit'][$category->named_id]['name'] = $category->name;
                $summery['credit'][$category->named_id]['creditNr'] = $credit;
                $credit = number_format($credit / 100, 2, ',', '.');
                $summery['credit'][$category->named_id]['credit'] = $credit;
            }
        }

        if (isset($summery['debet'])) {
            usort($summery['debet'], function ($a, $b) {
                return $b['debetNr'] <=> $a['debetNr'];
            });
        }

        if (isset($summery['credit'])) {
            usort($summery['credit'], function ($a, $b) {
                return $b['creditNr'] <=> $a['creditNr'];
            });
        }

        $totals['debet'] = number_format($totals['debet'] / 100, 2, ',', '.');
        $totals['credit'] = number_format($totals['credit'] / 100, 2, ',', '.');

        return view('bookings.summary', ['summery' => $summery, 'totals' => $totals]);
    }


    // edit 
    public function edit($id)
    {
        $category = BookingCategory::find($id);
        return view('categories.edit', ['category' => $category]);
    }
}
