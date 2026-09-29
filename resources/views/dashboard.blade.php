<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Halo, {{ auth()->user()->name }} !</h1>
                <p class="text-gray-500">Berikut ringkasan acara yang kamu kelola.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <p class="text-sm text-gray-500">Total Event</p>
                    <p class="text-3xl font-bold text-indigo-600 mt-1">{{ $totalEvents }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <p class="text-sm text-gray-500">Total Peserta Terdaftar</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $totalPeserta }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <p class="text-sm text-gray-500">Sudah Check-in</p>
                    <p class="text-3xl font-bold text-purple-600 mt-1">{{ $totalHadir }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-semibold text-gray-800">Event Terbaru</h2>
                    <a href="{{ route('events.index') }}" class="text-sm text-indigo-600 hover:underline">Lihat semua</a>
                </div>

                @forelse ($eventTerbaru as $event)
                    <a href="{{ route('events.show', $event) }}" class="flex items-center justify-between py-3 border-b last:border-0 hover:bg-gray-50 -mx-2 px-2 rounded-md">
                        <div>
                            <p class="font-medium text-gray-900">{{ $event->name }}</p>
                            <p class="text-sm text-gray-500">{{ $event->date->format('d M Y, H:i') }} · {{ $event->location }}</p>
                        </div>
                        <span class="text-sm text-gray-400">{{ $event->registrations->count() }}/{{ $event->quota }} peserta</span>
                    </a>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500 mb-3">Kamu belum punya event.</p>
                        <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                            + Buat Event Pertamamu
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>