<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eventify - Pendaftaran Acara & Presensi QR Code</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white min-h-screen text-gray-800">
    <div class="min-h-screen flex flex-col">
        <nav class="max-w-5xl mx-auto w-full px-6 py-6 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-9 h-9 bg-pink-100 rounded-lg flex items-center justify-center text-lg">
                    ❤︎
                </div>
                <span class="font-bold text-lg text-gray-900">Eventify</span>
            </div>

            @if (Route::has('login'))
                <div class="flex gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-medium bg-pink-600 text-white rounded-lg hover:bg-pink-700">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:underline">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium bg-pink-600 text-white rounded-lg hover:bg-pink-700">Daftar</a>
                        @endif
                    @endauth
                </div>
            @endif
        </nav>

        <div class="flex-1 flex items-center">
            <div class="max-w-5xl mx-auto w-full px-6 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                <div>
                    <span class="inline-block text-xs font-semibold bg-pink-50 text-pink-700 px-3 py-1 rounded-full mb-4">Platform Manajemen Acara</span>
                    <h1 class="text-3xl sm:text-4xl font-bold leading-tight mb-4 text-gray-900">
                        Kelola Pendaftaran Acara & Presensi dengan QR Code
                    </h1>
                    <p class="text-gray-500 mb-6">
                        Buat acara, bagikan link pendaftaran, dan validasi kehadiran peserta secara instan hanya dengan memindai QR Code.
                    </p>
                    <div class="flex gap-3">
                        <a href="{{ route('register') }}" class="px-5 py-3 bg-pink-600 text-white font-medium rounded-lg hover:bg-pink-700">Mulai Sekarang</a>
                        <a href="{{ route('login') }}" class="px-5 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50">Masuk</a>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        <div class="text-2xl mb-2">🗐</div>
                        <p class="font-semibold text-gray-900">Pendaftaran Online</p>
                        <p class="text-sm text-gray-500">Peserta daftar lewat link unik per acara.</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        <div class="text-2xl mb-2">𖤘</div>
                        <p class="font-semibold text-gray-900">E-Ticket QR Code</p>
                        <p class="text-sm text-gray-500">Tiket otomatis dengan kode QR unik.</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        <div class="text-2xl mb-2">⛶</div>
                        <p class="font-semibold text-gray-900">Scan Kehadiran</p>
                        <p class="text-sm text-gray-500">Check-in cepat lewat kamera perangkat.</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        <div class="text-2xl mb-2">🔍︎</div>
                        <p class="font-semibold text-gray-900">Dashboard Ringkas</p>
                        <p class="text-sm text-gray-500">Pantau peserta dan kehadiran real-time.</p>
                    </div>
                </div>
            </div>
        </div>

        <footer class="text-center text-gray-400 text-sm py-6">
           
        </footer>
    </div>
</body>
</html>