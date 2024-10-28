<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BantuanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\PendudukController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [AuthController::class, 'login'])->name('view-login');
Route::post('/auth', [AuthController::class, 'auth'])->name('function-login');
Route::post('/logout', [AuthController::class, 'logout'])->name('function-logout');


Route::group(['middleware' => 'auth.check'], function () {

    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('view-dashboard');

    // Jenis Barang routes
    Route::resource('jenis-barang', JenisBarangController::class);

    //Barang
    Route::resource('barang',  BarangController::class);

    //kelompok
    Route::resource('kelompok', KelompokController::class);

    //Penduduk
    Route::resource('penduduk', PendudukController::class);

    Route::resource('bantuan', BantuanController::class);
});
