<?php

use App\Helpers\RouteHelper;
use App\Http\Controllers\Inventory\Master\BrandController;
use App\Http\Controllers\Inventory\Master\CategoryController;
use App\Http\Controllers\Inventory\Master\GroupController;
use App\Http\Controllers\Inventory\Master\SubGroupController;
use App\Http\Controllers\Inventory\Master\TypeController;
use App\Http\Controllers\Inventory\Master\UomController;
use App\Http\Controllers\Inventory\Master\SizeController;
use App\Http\Controllers\Inventory\Master\SizeGroupController;
use App\Http\Controllers\Inventory\Master\ColorController;
use App\Http\Controllers\Inventory\Master\ColorGroupController;
use App\Http\Controllers\Inventory\Master\AdjustmentTypeController;
use App\Http\Controllers\Inventory\Master\PriceTypeController;
use App\Http\Controllers\Inventory\Master\PurchasePriceController;
use App\Http\Controllers\Inventory\Master\SalesPriceController;
use App\Http\Controllers\Inventory\Master\WarehouseController;
use App\Http\Controllers\Inventory\Master\WarehouseTypeController;
use App\Http\Controllers\Inventory\Master\RackController;
use App\Http\Controllers\Inventory\Master\ProductController;

Route::middleware('auth')->group(function () {
    
    Route::resource(TypeController::URL, TypeController::class);
    Route::resource(BrandController::URL, BrandController::class);
    Route::resource(CategoryController::URL, CategoryController::class);
    Route::resource(SubGroupController::URL, SubGroupController::class);
    Route::resource(GroupController::URL, GroupController::class);
    Route::resource(UomController::URL, UomController::class);
    Route::resource(SizeController::URL, SizeController::class);
    Route::resource(SizeGroupController::URL, SizeGroupController::class);
    Route::resource(ColorController::URL, ColorController::class);
    Route::resource(ColorGroupController::URL, ColorGroupController::class);
    Route::resource(AdjustmentTypeController::URL, AdjustmentTypeController::class);
    Route::resource(ProductController::URL, ProductController::class);
    
    //melebihi 32 karakter dibuat parameter
    Route::resource(PriceTypeController::URL, PriceTypeController::class, [
        'parameters' => [
            PriceTypeController::URL => preg_replace('/^([^-]+-){2}/', '', PriceTypeController::URL)
        ]
    ]);

        // Route::resource(PurchasePriceController::URL, PurchasePriceController::class, [
        //     'parameters' => [   
        //         PurchasePriceController::URL => preg_replace('/^([^-]+-){2}/', '', PurchasePriceController::URL)
        //     ]
        // ]);

        // Route::resource(SalesPriceController::URL, SalesPriceController::class, [
        //     'parameters' => [
        //         SalesPriceController::URL => preg_replace('/^([^-]+-){2}/', '', SalesPriceController::URL)
        //     ]
        // ]);

    Route::resource(WarehouseController::URL, WarehouseController::class, [
        'parameters' => [
            WarehouseController::URL => preg_replace('/^([^-]+-){2}/', '', WarehouseController::URL)
        ]
    ]);

    Route::resource(WarehouseTypeController::URL, WarehouseTypeController::class, [
        'parameters' => [
            WarehouseTypeController::URL => preg_replace('/^([^-]+-){2}/', '', WarehouseTypeController::URL)
        ]
    ]);

    Route::resource(RackController::URL, RackController::class, [
        'parameters' => [
            RackController::URL => preg_replace('/^([^-]+-){2}/', '', RackController::URL)
        ]
    ]);

});
