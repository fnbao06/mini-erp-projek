<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;

Route::get('/', [DashboardController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');  

Route::get('/transactions', function(){
    return view('transactions');
})->name('transactions'); 

Route::get('/categories', [CategoryController::class, 'index'])->name('categories'); 