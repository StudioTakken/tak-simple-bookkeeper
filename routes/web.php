<?php

use App\Http\Controllers\BackupController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingAccountController;
use App\Http\Controllers\BookingCategoryController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\DashboardController;
use App\Exports\InvoicePdfExport;
use Illuminate\Support\Facades\Artisan;

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
    // Route::get('/booking/{id}', [BookingController::class, 'edit'])->name('booking.edit');
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

    Route::get('/bookings-xlsx', [BookingController::class, 'bookingsXlsx'])->name('bookings-xlsx');


    Route::get('/backups', [BackupController::class, 'index'])->name('backups');
    Route::get('/backitup', [BackupController::class, 'backup'])->name('backitup');
    Route::get('/restore/{file}', [BackupController::class, 'restore'])->name('restore');


    Route::resource('invoices', InvoiceController::class);
    Route::post('/invoices_reset/{id}', [InvoiceController::class, 'reset'])->name('invoices.reset');




    // Route::post('invoice/download', [InvoiceController::class, 'download'])->name('invoice.download');
    Route::get('/pdf/{id}', [InvoicePdfExport::class, 'download'])->name('invoice.download');
    Route::get('/pdfpreview/{id}', [InvoicePdfExport::class, 'preview'])->name('invoice.preview');


    // Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    // Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    // Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    // Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
    // Route::get('/invoices/{id}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
    // Route::put('/invoices/{id}', [InvoiceController::class, 'update'])->name('invoices.update');
    // Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');

    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
    Route::get('/clients/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
});



require __DIR__ . '/auth.php';
