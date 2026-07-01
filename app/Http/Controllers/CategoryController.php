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
            'cat_name' => 'required|string|max:20|unique:categories,cat_name',
            'type'     => 'required|in:income,expense',
        ]);

        try {
            Category::create($validated);

            return redirect()->back()
                             ->with('success', 'Kategori ' . $validated['cat_name'] . ' berhasil ditambahkan!');
                             
        } catch (\Exception $e) {
            // Jika terjadi error sistem
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    // Method untuk mengambil data kategori (biasanya untuk response JSON jika menggunakan modal)
    public function Edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function Update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            // Abaikan ID saat ini agar tidak terkena error 'unique' pada nama yang sama
            'cat_name' => 'required|string|max:20|unique:categories,cat_name,' . $id,
            'type'     => 'required|in:income,expense',
        ]);

        try {
            $category->update($validated);

            return redirect()->back()
                            ->with('success', 'Kategori ' . $category->cat_name . ' berhasil diperbarui!');
                            
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data.')->with('edit_id', $id);
        }
    }

    public function Destroy($id)
    {
        $category = Category::findOrFail($id);

        // Cek jumlah transaksi (usage)
        $usageCount = $category->transaction()->count();

        if ($usageCount > 0) {
            return redirect()->back()->with('error', "Kategori '{$category->cat_name}' tidak dapat dihapus karena masih digunakan oleh {$usageCount} transaksi.");
        }

        try {
            $category->forceDelete();
            return redirect()->back()->with('success', "Kategori '{$category->cat_name}' berhasil dihapus permanen.");

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
