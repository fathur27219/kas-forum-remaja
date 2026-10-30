<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function monthly(Request $request)
    {
        // Ambil dari request, jika kosong gunakan bulan/tahun sekarang
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Debugging sementara kalau mau cek nilainya masuk atau nggak:
        // dd($month, $year); 

        $transactions = Transaction::whereYear('transaction_date', $year)
            // Gunakan casting atau pastikan formatnya string/integer yang pas
            ->whereMonth('transaction_date', (int) $month)
            ->orderBy('transaction_date', 'asc')
            ->get();

        $totalIn = $transactions->where('type', 'in')->sum('amount');
        $totalOut = $transactions->where('type', 'out')->sum('amount');
        $balance = $totalIn - $totalOut;

        return view('report.monthly', compact('transactions', 'totalIn', 'totalOut', 'balance', 'month', 'year'));
    }
}
