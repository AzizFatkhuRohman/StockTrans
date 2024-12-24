<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VendorController;
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

Route::middleware('auth')->group(function(){
    Route::get('/',[HomeController::class,'index']);
    Route::get('profile',[HomeController::class,'profile']);
    Route::put('profile/{id}',[HomeController::class,'ubahProfile']);
    Route::put('profile/ubah-password/{id}',[HomeController::class,'ubahPassword']);
    Route::resource('vendor',VendorController::class);
    Route::post('vendor/import',[VendorController::class,'import']);
    Route::post('vendor/export',[VendorController::class,'export']);
    Route::get('api-vendor',[VendorController::class,'api'])->name('apivendor');
    Route::resource('customer',CustomerController::class);
    Route::post('customer/import',[CustomerController::class,'import']);
    Route::post('customer/export',[CustomerController::class,'export']);
    Route::get('apicustomer',[CustomerController::class,'api'])->name('apicustomer');
    Route::resource('product',ProductController::class);
    Route::post('product/export',[ProductController::class,'export']);
    Route::get('api-product',[ProductController::class,'api'])->name('apiproduct');
    Route::resource('transaction',TransactionController::class);
    Route::post('transaction/export',[TransactionController::class,'export']);
    Route::get('api-transaction',[TransactionController::class,'api'])->name('apitransaction');
});

Auth::routes([
    'register'=>false
]);
