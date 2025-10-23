<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MieGacoan\BillOfMaterialController;
use App\Http\Controllers\MieGacoan\PosController;
use App\Http\Controllers\MieGacoan\ProductController;
use App\Http\Controllers\SelfOrderController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::resources(['self-order' => SelfOrderController::class]);


Route::middleware('auth')->group(function () {

    Route::resource(ProductController::URL, ProductController::class);
    Route::resource(BillOfMaterialController::URL, BillOfMaterialController::class);
    Route::resource(PosController::URL, PosController::class);

});




