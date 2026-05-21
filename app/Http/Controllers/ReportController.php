<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request){
        $selectedMonth = $request->get('month', date('m'));
        $selectedYear = $request->get('year', date('y'));

        $totalExpense = Transaction::whereMonth('trans_date', $selectedMonth)
            ->whereYear('trans_date', $selectedYear)
            ->whereHas('category', function($q){
                $q->where('type', 'expense');
            })->sum('amount');

        return view('reports', compact(
            'totalExpense',
            'selectedMonth',
            'selectedYear'
        ));
    }
}
