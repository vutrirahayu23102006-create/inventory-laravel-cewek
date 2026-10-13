<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard.page');

Route::resource('products', ProductController::class);
