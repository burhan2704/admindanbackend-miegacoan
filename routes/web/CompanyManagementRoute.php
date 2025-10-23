<?php

use App\Http\Controllers\CompanyManagement\CompanyController;
use App\Http\Controllers\CompanyManagement\DepartmentController;
use App\Http\Controllers\CompanyManagement\LevelController;
use App\Http\Controllers\CompanyManagement\PositionController;

Route::middleware('auth')->group(function () {
   
    Route::resource(CompanyController::URL, CompanyController::class);
    Route::resource(DepartmentController::URL, DepartmentController::class);
    Route::resource(PositionController::URL, PositionController::class);
    Route::resource(LevelController::URL, LevelController::class);



});
