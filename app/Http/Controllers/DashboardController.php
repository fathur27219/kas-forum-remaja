<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung total kas masuk dan keluar
        $totalMasuk = Transaction::where('type', 'in')->sum('amount');
        $totalKeluar = Transaction::where('type', 'out')->sum('amount');
        
        // Saldo akhir (Masuk - Keluar)
        $totalSaldo = $totalMasuk - $totalKeluar;

        // Mengambil 5 transaksi terakhir untuk ditampilkan di tabel dashboard
        $latestTransactions = Transaction::with('period', 'user')
            ->orderBy('transaction_date', 'desc')
            ->take(5)
            ->get();

        // Mengirim data ke view dashboard (nanti kita buat view-nya)
        return view('dashboard', compact('totalSaldo', 'totalMasuk', 'totalKeluar', 'latestTransactions'));
    }
}