<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;

// Halaman Publik (Bisa diakses siapa saja / Warga)
Route::get('/', [DashboardController::class, 'index']);
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/report/monthly', [ReportController::class, 'monthly'])->name('report.monthly');

// Route Login Admin
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Khusus Admin (Wajib Login dulu)
Route::middleware(['auth'])->group(function () {
    Route::post('/transactions', [TransactionController::class, 'store'])
        ->name('transactions.store');

    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])
        ->name('transactions.update');

    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])
        ->name('transactions.destroy');
});
