<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingCategory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

class CategoryController extends BookingController
{

    public $categoryList = [];
    public $accountList = [];


    public function oncategory($sCategory)
    {


        $oCategory = BookingCategory::where('named_id', $sCategory)->first();

        if ($oCategory) {

            session(['viewscope' => $oCategory->named_id]);

            return view('bookings.index', ['method' => 'oncategory', 'include_children' => false]);
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
    public function summary()
    {
        $this->setCategoryList();


        $summery = [];
        $totals = [];
        $totals['debet'] = 0;
        $totals['credit'] = 0;

        foreach ($this->categoryList as $category) {

            // if $category_key is in accountList, skip it
            if ($category->named_id == 'kruispost') {
                continue;
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


        usort($summery['debet'], function ($a, $b) {
            return $b['debetNr'] <=> $a['debetNr'];
        });

        usort($summery['credit'], function ($a, $b) {
            return $b['creditNr'] <=> $a['creditNr'];
        });

        $totals['debet'] = number_format($totals['debet'] / 100, 2, ',', '.');
        $totals['credit'] = number_format($totals['credit'] / 100, 2, ',', '.');

        return view('bookings.summary', ['summery' => $summery, 'totals' => $totals]);
    }
}
