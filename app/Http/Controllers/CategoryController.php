<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $category = [
            ['nama' => 'Makanan', 'tipe' => 'Expense'],
            ['nama' => 'Transportasi', 'tipe' => 'Expense'],
            ['nama' => 'Gaji', 'tipe' => 'Expense'],
            ['nama' => 'Sewa Rumah', 'tipe' => 'Expense']
        ];
        return view('categories', compact('category'));
    }
}
