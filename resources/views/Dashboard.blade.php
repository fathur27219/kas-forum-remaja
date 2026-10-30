<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kas Remaja</title>
    <!-- Memuat Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex min-h-screen">
        <!-- SIDEBAR -->
        @include('layouts.sidebar')

        <!-- KONTEN UTAMA -->
        <main class="flex-1 p-6 lg:p-10">
            <!-- Header Halaman -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                <p class="text-sm text-gray-500">Ringkasan arus kas dan keuangan organisasi.</p>
            </div>

            <!-- KARTU STATISTIK (Grid 3 Kolom) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Saldo -->
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                    <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Total Saldo Kas</h3>
                    <p class="text-2xl font-bold text-gray-800 mt-2">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</p>
                </div>

                <!-- Pemasukan -->
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
                    <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Total Masuk</h3>
                    <p class="text-2xl font-bold text-blue-600 mt-2">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</p>
                </div>

                <!-- Pengeluaran -->
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-red-500">
                    <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Total Keluar</h3>
                    <p class="text-2xl font-bold text-red-600 mt-2">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- TABEL TRANSAKSI TERAKHIR -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800">Riwayat Transaksi Terbaru</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                <th class="py-3 px-6">Tanggal</th>
                                <th class="py-3 px-6">Kategori</th>
                                <th class="py-3 px-6">Tipe</th>
                                <th class="py-3 px-6">Nominal</th>
                                <th class="py-3 px-6">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @forelse($latestTransactions as $trx)
                            <tr>
                                <td class="py-4 px-6">{{ $trx->transaction_date }}</td>
                                <td class="py-4 px-6 font-medium">{{ $trx->category }}</td>
                                <td class="py-4 px-6">
                                    @if($trx->type == 'in')
                                    <span class="bg-green-100 text-green-700 py-1 px-3 rounded-full text-xs font-semibold">Masuk</span>
                                    @else
                                    <span class="bg-red-100 text-red-700 py-1 px-3 rounded-full text-xs font-semibold">Keluar</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 font-bold {{ $trx->type == 'in' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $trx->type == 'in' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 text-gray-500">{{ $trx->description ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-6 px-6 text-center text-gray-400">Belum ada data transaksi yang tercatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

</body>

</html>