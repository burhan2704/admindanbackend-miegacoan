<?php

use App\Http\Controllers\MieGacoan\Api\PointOfSaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('pos/list-stock-product', [PointOfSaleController::class, 'listStockProduct']);
Route::get('pos/scan-stock-barcode', [PointOfSaleController::class, 'scanStockBarcode']);
Route::post('pos/payment', [PointOfSaleController::class, 'createPointOfSale']);

