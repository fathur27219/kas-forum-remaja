<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Periode;

class TransactionController extends Controller
{
    public function index()
    {
        // Mengambil seluruh data transaksi, diurutkan dari yang terbaru
        $transactions = Transaction::with('period', 'user')
            ->orderBy('transaction_date', 'desc')
            ->get();

        return view('transactions', compact('transactions'));
    }
    public function store(Request $request)
    {
        // Validasi data yang dikirim dari form modal
        $request->validate([
            'type' => 'required|in:in,out',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        // Simpan datanya ke database MySQL
        Transaction::create([
            'type' => $request->type,
            'category' => $request->category,
            'amount' => $request->amount,
            'transaction_date' => $request->transaction_date,
            'description' => $request->description,
            // 'user_id' => 1, // Di-set default ke ID admin pertama
            // 'period_id' => 1, // Sesuaikan jika ada relasi period, atau abaikan jika belum
        ]);

        // Redirect kembali ke halaman data kas
        return redirect('/transactions')->with('success', 'Transaksi berhasil ditambahkan!');
    }
}
