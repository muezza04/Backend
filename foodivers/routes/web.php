<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;


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

// auth merah ini tidak masalah, karena memang dari sistemnya framework laravelnya seperti itu
Auth::routes();
 
// membuat route untuk index home dengan method get
Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
// membuat route untuk halaman pesan dengan method get
Route::get('pesan/{id}', [\App\Http\Controllers\PesanController::class, 'index']);
// membuat route pesan dengan method post
Route::post('pesan/{id}', [\App\Http\Controllers\PesanController::class, 'pesan']);
// membuat route checkout dengan method get
Route::get('checkout', [\App\Http\Controllers\PesanController::class, 'checkout']);
// membuat route untuk delete checkout dengan method delete dengan parameter id
Route::delete('checkout/{id}', [\App\Http\Controllers\PesanController::class, 'delete']);

// membuat route untuk proceed-checkout dengan method get
Route::get('proceed-checkout', [\App\Http\Controllers\PesanController::class, 'proceedcheckout']);

// membuat route untuk profile dengan method get
Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'index']);

// membuat route untuk edit profile
Route::post('profile', [\App\Http\Controllers\ProfileController::class, 'edit']);

// membuat route untuk halaman histori atau bukti pembayaran
Route::get('history', [\App\Http\Controllers\HistoryController::class, 'index']);

// membuat route untuk halaman histori detail
Route::get('history/{id}', [\App\Http\Controllers\HistoryController::class, 'detail']);