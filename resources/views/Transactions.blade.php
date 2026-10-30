<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kas - Kas Remaja</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex min-h-screen">

        <!-- Panggil Sidebar -->
        @include('layouts.sidebar')

        <!-- KONTEN UTAMA -->
        <main class="flex-1 p-6 lg:p-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Data Kas Organisasi</h1>
                    <p class="text-sm text-gray-500">Kelola catatan uang masuk dan uang keluar kas.</p>
                </div>
                <!-- Tombol untuk Membuka Modal Form -->
                <button onclick="openModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                    + Tambah Transaksi
                </button>
            </div>

            <!-- TABEL SELURUH TRANSAKSI (Sama seperti sebelumnya) -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                <th class="py-3 px-6">Tanggal</th>
                                <th class="py-3 px-6">Kategori</th>
                                <th class="py-3 px-6">Tipe</th>
                                <th class="py-3 px-6">Nominal</th>
                                <th class="py-3 px-6">Keterangan</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @forelse($transactions as $trx)
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
                                <td class="py-4 px-6 text-center">
                                    <button class="text-blue-600 hover:underline text-xs mr-2">Edit</button>
                                    <button class="text-red-600 hover:underline text-xs">Hapus</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-6 px-6 text-center text-gray-400">Belum ada data transaksi yang tercatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL FORM TAMBAH TRANSAKSI (Hidden by default) -->
    <div id="transactionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-xl">
            <div class="flex justify-between items-center mb-4 border-b pb-3">
                <h3 class="font-bold text-lg text-gray-800">Tambah Transaksi Baru</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
            </div>

            <!-- Form Input -->
            <form action="#" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Tipe Transaksi</label>
                        <select name="type" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                            <option value="in">Kas Masuk (Pemasukan)</option>
                            <option value="out">Kas Keluar (Pengeluaran)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Kategori</label>
                        <input type="text" name="category" placeholder="Contoh: Iuran Bulanan / Konsumsi Rapat" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Nominal (Rp)</label>
                        <input type="number" name="amount" placeholder="Contoh: 15000" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Tanggal</label>
                        <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Keterangan (Opsional)</label>
                        <textarea name="description" rows="2" placeholder="Catatan tambahan..." class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none"></textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-2 mt-6">
                    <button type="button" onclick="closeModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition">Batal</button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Sederhana untuk Buka/Tutup Modal -->
    <script>
        function openModal() {
            document.getElementById('transactionModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('transactionModal').classList.add('hidden');
        }
    </script>

</body>

</html>