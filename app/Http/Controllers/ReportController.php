<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    private function buildQuery(Request $request)
    {
        $query    = Transaction::with('category');
        $dateFrom = $request->get('date_from');
        $dateTo   = $request->get('date_to');

        if ($dateFrom) {
            $query->whereDate('trans_date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('trans_date', '<=', $dateTo);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $dateFrom     = $request->get('date_from', '');
        $dateTo       = $request->get('date_to', '');

        $transactions = $this->buildQuery($request)
            ->orderBy('trans_date', 'desc')
            ->get();

        $totalIncome  = $transactions->filter(fn($t) => ($t->category->type ?? '') === 'income')->sum('amount');
        $totalExpense = $transactions->filter(fn($t) => ($t->category->type ?? '') === 'expense')->sum('amount');
        $netProfit    = $totalIncome - $totalExpense;

        return view('reports', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'netProfit',
            'dateFrom',
            'dateTo'
        ));
    }

    public function exportPdf(Request $request)
    {
        $dateFrom     = $request->get('date_from', '');
        $dateTo       = $request->get('date_to', '');

        $transactions = $this->buildQuery($request)
            ->orderBy('trans_date', 'desc')
            ->get();

        $totalIncome  = $transactions->filter(fn($t) => ($t->category->type ?? '') === 'income')->sum('amount');
        $totalExpense = $transactions->filter(fn($t) => ($t->category->type ?? '') === 'expense')->sum('amount');
        $netProfit    = $totalIncome - $totalExpense;

        // Buat label periode untuk PDF
        if ($dateFrom || $dateTo) {
            $from        = $dateFrom ? \Carbon\Carbon::parse($dateFrom)->format('d M Y') : '...';
            $to          = $dateTo   ? \Carbon\Carbon::parse($dateTo)->format('d M Y')   : '...';
            $filterLabel = "{$from} – {$to}";
        } else {
            $filterLabel = 'Semua Periode';
        }

        $pdf = Pdf::loadView('reports_pdf', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'netProfit',
            'filterLabel'
        ))->setPaper('a4', 'portrait');

        $filename = 'laporan-keuangan-' . now()->format('Ymd-His') . '.pdf';

        return $pdf->stream($filename);
    }
}