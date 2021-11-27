<?php

use App\Models\produk;
use App\Models\deposit;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\ProdukController;

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

Route::get('/', [LoginController::class, 'index'])->middleware('guest');
Route::post('/', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboardDeposit', function(){
    $data = deposit::all();
    return view('dashboard.deposit', compact('data'));
})->middleware('auth');

Route::post('/dashboardDeposit', function () {
    deposit::create([
        'nominal' => request('nominal')
    ]);
    return redirect('/dashboardDeposit');
});

Route::resource('dashboardProduk', ProdukController::class)->middleware('auth');


Route::get('/dashboardPenjualan', function(){
    return view('dashboard.penjualan');
})->middleware('auth');