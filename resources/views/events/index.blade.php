<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Event</h2>
            <a href="{{ route('events.create') }}" class="inline-flex items-center gap-1 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                <span class="text-lg leading-none">+</span> Buat Event
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md text-sm">{{ session('success') }}</div>
            @endif

            @forelse ($events as $event)
                @php
                    $sudahLewat = $event->date->isPast();
                    $penuh = $event->registrations->count() >= $event->quota;
                @endphp
                <div class="bg-white shadow-sm rounded-xl p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <a href="{{ route('events.show', $event) }}" class="block flex-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <p class="font-semibold text-gray-900">{{ $event->name }}</p>
                            @if ($sudahLewat)
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-gray-100 text-gray-500">Selesai</span>
                            @elseif ($penuh)
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-red-100 text-red-600">Kuota Penuh</span>
                            @else
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-green-100 text-green-700">Terbuka</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 mt-1">{{ $event->date->format('d M Y, H:i') }} · {{ $event->location }}</p>
                        <p class="text-sm text-gray-400 mt-1">{{ $event->registrations->count() }} / {{ $event->quota }} peserta terdaftar</p>
                    </a>
                    <div class="flex gap-2 shrink-0">
                        <a href="{{ route('events.edit', $event) }}" class="px-3 py-1.5 text-sm bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Edit</a>
                        <form method="POST" action="{{ route('events.destroy', $event) }}" onsubmit="return confirm('Yakin hapus event ini? Data pendaftar juga akan terhapus.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 text-sm bg-red-600 text-white rounded-md hover:bg-red-700">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white shadow-sm rounded-xl p-10 text-center">
                    <p class="text-gray-500 mb-3">Belum ada event yang kamu buat.</p>
                    <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                        + Buat Event Pertama
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>