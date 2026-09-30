<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Event</h2>
            <a href="{{ route('events.create') }}" class="inline-flex items-center gap-1 px-4 py-2 bg-pink-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-pink-700 hover:shadow-md transition">
                <span class="text-lg leading-none">+</span> Buat Event
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="p-4 bg-yellow-100 text-yellow-800 rounded-lg text-sm">{{ session('success') }}</div>
            @endif

            @forelse ($events as $event)
                @php
                    $sudahLewat = $event->date->isPast();
                    $penuh = $event->registrations->count() >= $event->quota;
                    $persen = $event->quota > 0 ? min(100, round($event->registrations->count() / $event->quota * 100)) : 0;
                @endphp
                <div class="bg-white shadow-sm rounded-xl p-5 border-l-4 {{ $sudahLewat ? 'border-gray-300' : ($penuh ? 'border-red-400' : 'border-yellow-400') }} hover:shadow-md transition">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <a href="{{ route('events.show', $event) }}" class="block flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <p class="font-semibold text-gray-900">{{ $event->name }}</p>
                                @if ($sudahLewat)
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-gray-100 text-gray-500">Selesai</span>
                                @elseif ($penuh)
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-red-100 text-red-600">Kuota Penuh</span>
                                @else
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700">Terbuka</span>
                                @endif
                            </div>

                            <div class="flex flex-wrap gap-x-4 gap-y-1 mt-2 text-sm text-gray-500">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $event->date->format('d M Y, H:i') }}
                                </span>
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $event->location }}
                                </span>
                            </div>

                            <div class="mt-3 max-w-xs">
                                <div class="flex justify-between text-xs text-gray-400 mb-1">
                                    <span>{{ $event->registrations->count() }} / {{ $event->quota }} peserta</span>
                                    <span>{{ $persen }}%</span>
                                </div>
                                <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full {{ $penuh ? 'bg-red-400' : 'bg-pink-500' }}" style="width: {{ $persen }}%"></div>
                                </div>
                            </div>
                        </a>

                        <div class="flex gap-2 shrink-0">
                            <a href="{{ route('events.edit', $event) }}" class="px-3 py-1.5 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">Edit</a>
                            <form method="POST" action="{{ route('events.destroy', $event) }}" onsubmit="return confirm('Yakin hapus event ini? Data pendaftar juga akan terhapus.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white shadow-sm rounded-xl p-10 text-center">
                    <p class="text-gray-500 mb-3">Belum ada event yang kamu buat.</p>
                    <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-pink-600 text-white text-sm font-medium rounded-lg hover:bg-pink-700">
                        + Buat Event Pertama
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>