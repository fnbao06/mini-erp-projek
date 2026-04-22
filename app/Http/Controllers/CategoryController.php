<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function Category(){
        // $category = [
        //     ['nama' => 'Makanan', 'tipe' => 'Expense'],
        //     ['nama' => 'Transportasi', 'tipe' => 'Expense'],
        //     ['nama' => 'Gaji', 'tipe' => 'Expense'],
        //     ['nama' => 'Sewa Rumah', 'tipe' => 'Expense']
        // ];

        $category = Category::withCount('transaction')->get();

        return view('categories', compact('category'));
    }

    public function Store(Request $request)
    {
        $validated = $request->validate([
            'cat_name' => 'required|string|max:255|unique:categories,cat_name',
            'type'     => 'required|in:income,expense',
        ]);

        try {
            Category::create([
                'cat_name' => $validated['cat_name'],
                'type'     => $validated['type'],
            ]);

            return redirect()->route('categories')
                             ->with('success', 'Kategori ' . $validated['cat_name'] . ' berhasil ditambahkan!');
                             
        } catch (\Exception $e) {
            // Jika terjadi error sistem
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }
}
