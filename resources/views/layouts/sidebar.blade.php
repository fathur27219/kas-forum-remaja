<!-- SIDEBAR -->
<aside class="w-64 bg-gray-900 text-white p-4 flex flex-col justify-between hidden md:flex min-h-screen">
    <div>
        <!-- Nama Brand / Organisasi -->
        <div class="text-xl font-bold mb-8 px-2 tracking-wide text-green-400">
            KasRemaja RT 01
        </div>

        <!-- Menu Navigasi -->
        <nav class="space-y-2">
            <a href="/" class="block py-2.5 px-4 rounded transition hover:bg-gray-800 text-white font-semibold">
                Dashboard
            </a>
            <a href="/transactions" class="block py-2.5 px-4 rounded transition hover:bg-gray-800 text-gray-300">
                Data Kas
            </a>
            <a href="/report/monthly" class="block py-2.5 px-4 rounded transition hover:bg-gray-800 text-gray-300">
                Laporan Kas
            </a>
            <a href="#" class="block py-2.5 px-4 rounded transition hover:bg-gray-800 text-gray-300">
                Pengaturan
            </a>
        </nav>
    </div>
    <div class="p-4 border-t border-gray-200 mt-auto">
        @auth
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 font-semibold py-2 px-4 rounded-lg text-sm transition text-center">
                🚪 Logout Admin
            </button>
        </form>
        @else
        <a href="{{ route('login') }}" class="block w-full bg-green-50 hover:bg-green-100 text-green-700 font-semibold py-2 px-4 rounded-lg text-sm transition text-center">
            🔐 Login Admin
        </a>
        @endauth
    </div>

    <!-- Bagian Bawah Sidebar -->
    <div class="border-t border-gray-800 pt-4">
        <div class="text-sm text-gray-400 px-2 mb-2">Login sebagai: <span class="text-white font-medium">Admin</span></div>
    </div>
</aside>