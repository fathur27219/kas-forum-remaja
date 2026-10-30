<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kas Bulanan - Kas Remaja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white;
            }

            main {
                padding: 0 !important;
            }

            box-shadow {
                box-shadow: none !important;
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex min-h-screen">

        @include('layouts.sidebar')

        <!-- KONTEN UTAMA -->
        <main class="flex-1 p-6 lg:p-10">
                <div class="flex justify-between items-center mb-8 no-print">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Laporan Kas Bulanan</h1>
                        <p class="text-sm text-gray-500">Rekapitulasi pemasukan dan pengeluaran kas per bulan.</p>
                    </div>
                    <!-- Tombol Cetak / Print -->
                    <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm flex items-center gap-2">
                        🖨️ Cetak Laporan
                    </button>
                </div>

                <!-- FORM FILTER BULAN & TAHUN -->
                <form method="GET" action="{{ route('report.monthly') }}" class="flex flex-wrap items-end gap-4 mb-6 no-print">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Pilih Bulan</label>
                        <select name="month" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                            @for($i = 1; $i <= 12; $i++)
                                @php
                                $formattedMonth=sprintf('%02d', $i);
                                @endphp
                                <option value="{{ $formattedMonth }}" {{ $month == $formattedMonth ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                                @endfor
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Pilih Tahun</label>
                        <select name="year" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                            @for($y = date('Y'); $y >= 2024; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Tampilkan
                    </button>
                </form>


                <!-- KOP LAPORAN (Muncul saat dicetak atau dilihat) -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <div class="text-center border-b pb-4 mb-6">
                        <h2 class="text-xl font-bold text-gray-800 uppercase">Laporan Keuangan Kas Remaja RT 01</h2>
                        <p class="text-sm text-gray-500">Periode: {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</p>
                    </div>

                    <!-- Ringkasan Angka -->
                    <div class="grid grid-cols-3 gap-4 mb-6 text-center">
                        <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                            <p class="text-xs font-semibold text-green-600 uppercase">Total Masuk</p>
                            <p class="text-lg font-bold text-green-700 mt-1">Rp {{ number_format($totalIn, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg border border-red-100">
                            <p class="text-xs font-semibold text-red-600 uppercase">Total Keluar</p>
                            <p class="text-lg font-bold text-red-700 mt-1">Rp {{ number_format($totalOut, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <p class="text-xs font-semibold text-blue-600 uppercase">Sisa Saldo Periode Ini</p>
                            <p class="text-lg font-bold text-blue-700 mt-1">Rp {{ number_format($balance, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- TABEL LAPORAN -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse border border-gray-200 text-sm">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                                    <th class="border border-gray-200 py-3 px-4">Tanggal</th>
                                    <th class="border border-gray-200 py-3 px-4">Kategori</th>
                                    <th class="border border-gray-200 py-3 px-4">Tipe</th>
                                    <th class="border border-gray-200 py-3 px-4">Nominal</th>
                                    <th class="border border-gray-200 py-3 px-4">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-gray-700">
                                @forelse($transactions as $trx)
                                <tr>
                                    <td class="border border-gray-200 py-3 px-4">{{ $trx->transaction_date }}</td>
                                    <td class="border border-gray-200 py-3 px-4 font-medium">{{ $trx->category }}</td>
                                    <td class="border border-gray-200 py-3 px-4">
                                        @if($trx->type == 'in')
                                        <span class="text-green-600 font-semibold">Masuk</span>
                                        @else
                                        <span class="text-red-600 font-semibold">Keluar</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-200 py-3 px-4 font-bold {{ $trx->type == 'in' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $trx->type == 'in' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="border border-gray-200 py-3 px-4 text-gray-500">{{ $trx->description ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="border border-gray-200 py-6 text-center text-gray-400">Tidak ada transaksi tercatat pada bulan ini.</td>
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