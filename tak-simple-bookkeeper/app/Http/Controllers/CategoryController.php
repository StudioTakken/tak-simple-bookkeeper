<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

class CategoryController extends BookingController
{

    public $categoryList;


    public function oncategory($sCategory)
    {

        $existing =  $this->listCategories();
        if (array_key_exists($sCategory, $existing)) {
            return view('bookings.index', ['scope' => $sCategory]);
        } else {
            return view('bookings.sorry', ['scope' => $sCategory]);
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
    }
}
