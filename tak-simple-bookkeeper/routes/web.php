<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DebiteurenController;
use App\Http\Controllers\CategoryController;
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

// Route::get('/test', function (Request $request) {
//     $uri = $request->fullUrl();
//     return $uri;
// });

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
    Route::get('/booking/{booking}', [BookingController::class, 'edit'])->name('bookings.edit');

    Route::get('/importeren', [ImportController::class, 'index'])->name('importing');
    Route::post('dropzone/store', [ImportController::class, 'store'])->name('dropzone.store');

    Route::get('/debiteuren', [DebiteurenController::class, 'index'])->name('debiteuren.index');
    Route::get('/category/{category}', [CategoryController::class, 'oncategory'])->name('category.oncategory');
});

// useless routes
// Just to demo sidebar dropdown links active states.
Route::get('/buttons/text', function () {
    return view('buttons-showcase.text');
})->middleware(['auth'])->name('buttons.text');

Route::get('/buttons/icon', function () {
    return view('buttons-showcase.icon');
})->middleware(['auth'])->name('buttons.icon');

Route::get('/buttons/text-icon', function () {
    return view('buttons-showcase.text-icon');
})->middleware(['auth'])->name('buttons.text-icon');




require __DIR__ . '/auth.php';
