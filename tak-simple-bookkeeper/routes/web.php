<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DebiteurenController;
use App\Http\Controllers\BookingAccountController;
use App\Http\Controllers\BookingCategoryController;
use App\Http\Controllers\ImportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // create the bookings route
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings-import', [BookingController::class, 'import'])->name('bookings.import');

    Route::get('/importeren', [ImportController::class, 'index'])->name('importing');
    Route::post('dropzone/store', [ImportController::class, 'store'])->name('dropzone.store');

    Route::get('/account/{account}', [BookingAccountController::class, 'onaccount'])->name('account.onaccount');
    Route::get('/account/edit/{account}', [BookingAccountController::class, 'edit'])->name('accounts.edit');
    Route::get('/balance', [BookingAccountController::class, 'balance'])->name('balance');

    // a route voor balance xlsx
    Route::get('/balance-xlsx', [BookingAccountController::class, 'balanceXlsx'])->name('balance-xlsx');

    Route::get('/category/{category}', [BookingCategoryController::class, 'oncategory'])->name('category.oncategory');
    Route::get('/category/edit/{category}', [BookingCategoryController::class, 'edit'])->name('categories.edit');

    Route::get('/summary', [BookingCategoryController::class, 'summary'])->name('summary');
    Route::get('/summary/{filter}', [BookingCategoryController::class, 'summary'])->name('summary.filter');
});


require __DIR__ . '/auth.php';
