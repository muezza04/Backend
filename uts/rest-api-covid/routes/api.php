<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatienstController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

# Membuat authentication group
Route::middleware(['auth:sanctum'])->group(function(){
    # Get All Resource / Membuat route untuk memanggil semua data menggunakan get
    Route::get('/patients', [PatienstController::class, 'index']);

    # Add Resource / Membuat route tambah data pasien covid menggunakan post
    Route::post('/patients', [PatienstController::class, 'store']);

    # Get Detail Resource / Membuat route untuk menampilkan detail data pasien covid menggunakan get
    Route::get('/patients/{id}', [PatienstController::class, 'show']);

    # Edit Resource / Membuat route untuk mengedit data pasien covid menggunakan put
    Route::put('/patients/{id}', [PatienstController::class, 'update']);

    # Delete Resource / Membuat route untuk menghapus data pasien covid menggunakan delete
    Route::delete('/patients/{id}', [PatienstController::class, 'destroy']);

    # Search Resource by name / Memcari data nama pasien covid menggunakan get
    Route::get('/patients/search/{name}', [PatienstController::class, 'search']);

    # Get Positif Resource / Menampikan data pasien covid positif menggunakan get
    Route::get('/patients/status/positive', [PatienstController::class, 'positive']);

    # Get Recovered Resource / Menampilkan data pasien covid sembuh menggunakan get
    Route::get('/patients/status/recovered', [PatienstController::class, 'recovered']);

    # Get Dead Resource / Menampikan data pasien covid meninggal menggunakan get
    Route::get('/patients/status/dead', [PatienstController::class, 'dead']);
});

# Register / Membuat register login menggunakan route post untuk authentication
Route::post('/register', [AuthController::class, 'register']);

# Login / Untuk membuat token login menggunakan route post untuk authentication
Route::post('/login', [AuthController::class, 'login']);
