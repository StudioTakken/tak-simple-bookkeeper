<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingAccountController;
use App\Http\Controllers\BookingCategoryController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\DashboardController;

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

// skip the welcome page
// Route::get('/', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashhome');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // create the bookings route
    Route::get('/booking/{id}', [BookingController::class, 'edit'])->name('booking.edit');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings-import', [BookingController::class, 'import'])->name('bookings.import');
    Route::get('/bookings-prove-download/{id}', [BookingController::class, 'prove_download'])->name('bookings.prove-download');

    Route::get('/importeren', [ImportController::class, 'index'])->name('importing');
    Route::post('dropzone/store', [ImportController::class, 'store'])->name('dropzone.store');

    Route::get('/account/create', [BookingAccountController::class, 'create'])->name('account.create');
    // Route::post('/account/new', [BookingAccountController::class, 'create'])->name('account.create');

    Route::get('/account/{account}', [BookingAccountController::class, 'onaccount'])->name('account.onaccount');
    Route::get('/account/edit/{account}', [BookingAccountController::class, 'edit'])->name('accounts.edit');


    Route::get('/balance', [BookingAccountController::class, 'balance'])->name('balance');

    // a route voor balance xlsx
    Route::get('/balance-xlsx', [BookingAccountController::class, 'balanceXlsx'])->name('balance-xlsx');

    Route::get('/category/create', [BookingCategoryController::class, 'create'])->name('category.create');
    Route::get('/category/{category}', [BookingCategoryController::class, 'oncategory'])->name('category.oncategory');
    Route::get('/category/edit/{category}', [BookingCategoryController::class, 'edit'])->name('categories.edit');

    Route::get('/summary', [BookingCategoryController::class, 'summary'])->name('summary');
    Route::get('/summary/{filter}', [BookingCategoryController::class, 'summary'])->name('summary.filter');
    // route for summary xlsx
    Route::get('/summary-xlsx', [BookingCategoryController::class, 'summaryXlsx'])->name('summary-xlsx');
    Route::get('/summary-xlsx/{filter}', [BookingCategoryController::class, 'summaryXlsx'])->name('summary-xlsx.filter');
});


require __DIR__ . '/auth.php';
