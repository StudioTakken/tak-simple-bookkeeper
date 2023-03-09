<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

class CategoryController extends BookingController
{

    public $categoryList;
    public $accountList;


    public function oncategory($sCategory)
    {

        $existing =  $this->listCategories();
        if (array_key_exists($sCategory, $existing)) {

            session(['viewscope' => $sCategory]);

            return view('bookings.index', ['method' => 'oncategory', 'include_children' => false]);
        } else {
            return view('bookings.sorry');
        }
    }

    /**
     * 
     */
    public function listCategories(): array
    {
        $this->setCategoryList();
        return $this->categoryList;
    }

    public function setCategoryList()
    {
        $this->categoryList = config('bookings.categories');
        $this->accountList = config('bookings.accounts');
    }



    public function summary()
    {
        $this->setCategoryList();


        $summery = [];
        $totals = [];
        $totals['debet'] = 0;
        $totals['credit'] = 0;

        foreach ($this->categoryList as $category_key => $category_name) {

            // if $category_key is in accountList, skip it
            if (array_key_exists($category_key, $this->accountList)) {
                continue;
            }



            $summery[$category_key]['name'] = $category_name;

            // get the sum of the bookings for this category where plus_min_int is 1
            $debet = Booking::period()->where('category', $category_key)->orderBy('date')->orderBy('id')->where('plus_min_int', '1')->sum('amount_inc');

            $totals['debet'] += $debet;
            if ($debet == 0) {
                $debet = '';
            } else {
                $debet = number_format($debet / 100, 2, ',', '.');
            }
            $summery[$category_key]['debet'] = $debet;

            // get the sum of the bookings for this category where plus_min_int is -1
            $credit = Booking::period()->where('category', $category_key)->orderBy('date')->orderBy('id')->where('plus_min_int', '-1')->sum('amount_inc');

            $totals['credit'] += $credit;

            if ($credit == 0) {
                $credit = '';
            } else {
                $credit = number_format($credit / 100, 2, ',', '.');
            }
            $summery[$category_key]['credit'] = $credit;
        }


        $totals['debet'] = number_format($totals['debet'] / 100, 2, ',', '.');
        $totals['credit'] = number_format($totals['credit'] / 100, 2, ',', '.');



        return view('bookings.summary', ['summery' => $summery, 'totals' => $totals]);
    }
}
