<?php

use App\Helpers\RouteHelper;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserManagement\MenuController;
use App\Http\Controllers\UserManagement\RoleAndPermissionController;
use App\Http\Controllers\UserManagement\UserController;

Route::middleware('auth')->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource(UserController::URL, UserController::class);
    Route::resource(RoleAndPermissionController::URL, RoleAndPermissionController::class);
    Route::resource(MenuController::URL, MenuController::class);

});
