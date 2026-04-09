<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        // $category = [
        //     ['nama' => 'Makanan', 'tipe' => 'Expense'],
        //     ['nama' => 'Transportasi', 'tipe' => 'Expense'],
        //     ['nama' => 'Gaji', 'tipe' => 'Expense'],
        //     ['nama' => 'Sewa Rumah', 'tipe' => 'Expense']
        // ];

        $category = Category::all();

        return view('categories', compact('category'));
    }
}
