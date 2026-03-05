<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function(){
    return view('dashboard');
})->name('dashboard');  

Route::get('/transactions', function(){
    return view('transactions');
})->name('transactions'); 

Route::get('/categories', function(){
    return view ('categories');
})->name('categories'); 