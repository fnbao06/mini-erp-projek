<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;

Route::get('/', [DashboardController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');  

Route::get('/transactions', [TransactionController::class, 'Transaction'])->name('transactions');
Route::post('/transactions',[TransactionController::class, 'Store'])->name('transactions.store');

Route::get('/categories', [CategoryController::class, 'Category'])->name('categories'); 
Route::post('/categories', [CategoryController::class, 'Store'])->name('categories.store'); 