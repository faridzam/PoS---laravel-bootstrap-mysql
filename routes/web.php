<?php

use App\Models\produk;
use App\Models\deposit;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PenjualanController;

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

Route::resource('dashboardDeposit', DepositController::class)->middleware('auth');

Route::resource('dashboardProduk', ProdukController::class)->middleware('auth');

Route::resource('dashboardPenjualan', PenjualanController::class)->middleware('auth');
Route::get('cart', [PenjualanController::class, 'cart'])->name('cart');
Route::get('add-to-cart/{id}', [PenjualanController::class, 'addToCart'])->name('add.to.cart');
Route::patch('update-cart', [PenjualanController::class, 'update'])->name('update.cart');
Route::delete('remove-from-cart', [PenjualanController::class, 'remove'])->name('remove.from.cart');


Route::resource('dashboardInvoice', InvoiceController::class)->middleware('auth');

Route::get('printInvoice', [PrintController::class, 'printInvoice']);
Route::get('printDeposit', [PrintController::class, 'printDeposit']);
Route::get('printClosed', [PrintController::class, 'printClosed']);