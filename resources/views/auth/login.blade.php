<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Kas Remaja RT 01</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-sm w-full max-w-md border border-gray-200">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">🔒 Login Admin</h2>
            <p class="text-sm text-gray-500 mt-1">Khusus Pengurus Kas Remaja RT 01</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Email Admin</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-green-500 outline-none">
            </div>

            <div class="mb-6">
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Password</label>
                <input type="password" name="password" required class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-green-500 outline-none">
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition text-sm shadow-sm">
                Masuk ke Sistem
            </button>
        </form>

        <div class="text-center mt-6">
            <a href="/" class="text-xs text-gray-500 hover:underline">← Kembali ke Dashboard Utama</a>
        </div>
    </div>

</body>
</html>