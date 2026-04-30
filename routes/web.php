<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;

Route::get('/', [DashboardController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');  

Route::get('/transactions', [TransactionController::class, 'Transaction'])->name('transactions');
Route::post('/transactions',[TransactionController::class, 'Store'])->name('transactions.store');
Route::get('/transactions/{id}/edit', [TransactionController::class, 'Edit'])->name('transactions.edit');
Route::put('/transactions/{id}', [TransactionController::class, 'Update'])->name('transactions.update');
Route::delete('/transactions/{id}', [TransactionController::class, 'Destroy'])->name('transactions.destroy');

Route::get('/categories', [CategoryController::class, 'Category'])->name('categories'); 
Route::post('/categories', [CategoryController::class, 'Store'])->name('categories.store');
Route::get('/categories/{id}/edit', [CategoryController::class, 'Edit'])->name('categories.edit');
Route::put('/categories/{id}', [CategoryController::class, 'Update'])->name('categories.update');
Route::delete('/categories/{id}', [CategoryController::class, 'Destroy'])->name('categories.destroy');