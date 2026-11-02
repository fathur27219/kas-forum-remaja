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
        @include('layouts.sidebar')

        <main class="flex-1 p-6 lg:p-10">

            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Data Kas Organisasi</h1>
                    <p class="text-sm text-gray-500">Kelola catatan uang masuk dan uang keluar kas.</p>
                </div>

                @auth
                <button onclick="openAddModal()"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                    + Tambah Transaksi
                </button>
                @endauth
            </div>

            {{-- Notifikasi berhasil --}}
            @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-5">
                {{ session('success') }}
            </div>
            @endif

            {{-- Notifikasi validasi --}}
            @if($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-5">
                <p class="font-semibold mb-1">Terjadi kesalahan:</p>
                <ul class="list-disc pl-5 text-sm">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

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
                                @auth
                                <th class="py-3 px-6 text-center">Aksi</th>
                                @endauth
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @forelse($transactions as $trx)
                            <tr>
                                <td class="py-4 px-6">{{ $trx->transaction_date }}</td>

                                <td class="py-4 px-6 font-medium">
                                    {{ $trx->category }}
                                </td>

                                <td class="py-4 px-6">
                                    @if($trx->type == 'in')
                                    <span class="bg-green-100 text-green-700 py-1 px-3 rounded-full text-xs font-semibold">
                                        Masuk
                                    </span>
                                    @else
                                    <span class="bg-red-100 text-red-700 py-1 px-3 rounded-full text-xs font-semibold">
                                        Keluar
                                    </span>
                                    @endif
                                </td>

                                <td class="py-4 px-6 font-bold {{ $trx->type == 'in' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $trx->type == 'in' ? '+' : '-' }}
                                    Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </td>

                                <td class="py-4 px-6 text-gray-500">
                                    {{ $trx->description ?? '-' }}
                                </td>

                                @auth
                                <td class="py-4 px-6 text-center whitespace-nowrap">

                                    {{-- Tombol Edit --}}
                                    <button
                                        type="button"
                                        onclick="openEditModal(this)"
                                        data-update-url="{{ route('transactions.update', $trx->id) }}"
                                        data-type="{{ $trx->type }}"
                                        data-category="{{ $trx->category }}"
                                        data-amount="{{ $trx->amount }}"
                                        data-date="{{ \Carbon\Carbon::parse($trx->transaction_date)->format('Y-m-d') }}"
                                        data-description="{{ $trx->description }}"
                                        class="text-blue-600 hover:text-blue-800 hover:underline text-xs mr-2">
                                        Edit
                                    </button>

                                    {{-- Form Hapus --}}
                                    <form
                                        action="{{ route('transactions.destroy', $trx->id) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 hover:underline text-xs">
                                            Hapus
                                        </button>
                                    </form>

                                </td>
                                @endauth
                            </tr>

                            @empty
                            <tr>
                                <td colspan="@auth 6 @else 5 @endauth"
                                    class="py-6 px-6 text-center text-gray-400">
                                    Belum ada data transaksi yang tercatat.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    {{-- MODAL TAMBAH DAN EDIT --}}
    <div id="transactionModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">

        <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-xl">

            <div class="flex justify-between items-center mb-4 border-b pb-3">
                <h3 id="modalTitle" class="font-bold text-lg text-gray-800">
                    Tambah Transaksi Baru
                </h3>

                <button type="button" onclick="closeModal()"
                    class="text-gray-400 hover:text-gray-600 font-bold text-xl">
                    &times;
                </button>
            </div>

            <form id="transactionForm"
                action="{{ route('transactions.store') }}"
                method="POST">

                @csrf

                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="space-y-4">

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">
                            Tipe Transaksi
                        </label>

                        <select name="type" id="type"
                            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm"
                            required>
                            <option value="in">Kas Masuk (Pemasukan)</option>
                            <option value="out">Kas Keluar (Pengeluaran)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">
                            Kategori
                        </label>

                        <input type="text" name="category" id="category"
                            placeholder="Contoh: Iuran Bulanan / Konsumsi Rapat"
                            required
                            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">
                            Nominal (Rp)
                        </label>

                        <input type="number" name="amount" id="amount"
                            placeholder="Contoh: 15000"
                            min="0"
                            required
                            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">
                            Tanggal
                        </label>

                        <input type="date" name="transaction_date" id="transaction_date"
                            value="{{ date('Y-m-d') }}"
                            required
                            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">
                            Keterangan (Opsional)
                        </label>

                        <textarea name="description" id="description"
                            rows="2"
                            placeholder="Catatan tambahan..."
                            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm"></textarea>
                    </div>

                </div>

                <div class="flex justify-end space-x-2 mt-6">

                    <button type="button" onclick="closeModal()"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold">
                        Batal
                    </button>

                    <button type="submit" id="submitButton"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                        Simpan
                    </button>

                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('transactionModal');
        const form = document.getElementById('transactionForm');

        function openAddModal() {
            form.reset();

            form.action = "{{ route('transactions.store') }}";
            document.getElementById('formMethod').value = 'POST';

            document.getElementById('modalTitle').textContent = 'Tambah Transaksi Baru';
            document.getElementById('submitButton').textContent = 'Simpan';
            document.getElementById('transaction_date').value = new Date().toISOString().split('T')[0];

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function openEditModal(button) {
            const data = button.dataset;

            form.action = data.updateUrl;
            document.getElementById('formMethod').value = 'PUT';

            document.getElementById('type').value = data.type;
            document.getElementById('category').value = data.category;
            document.getElementById('amount').value = data.amount;
            document.getElementById('transaction_date').value = data.date;
            document.getElementById('description').value = data.description || '';

            document.getElementById('modalTitle').textContent = 'Edit Transaksi';
            document.getElementById('submitButton').textContent = 'Simpan Perubahan';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

</body>

</html>