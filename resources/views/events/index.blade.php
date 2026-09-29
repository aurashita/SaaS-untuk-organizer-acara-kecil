<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Event</h2>
            <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                + Buat Event
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md">{{ session('success') }}</div>
            @endif

            @forelse ($events as $event)
                <div class="bg-white shadow-sm rounded-lg p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <a href="{{ route('events.show', $event) }}" class="block">
                        <p class="font-semibold text-gray-900">{{ $event->name }}</p>
                        <p class="text-sm text-gray-500">{{ $event->date->format('d M Y, H:i') }} · {{ $event->location }}</p>
                    </a>
                    <div class="flex gap-2">
                        <a href="{{ route('events.edit', $event) }}" class="px-3 py-1.5 text-sm bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Edit</a>
                        <form method="POST" action="{{ route('events.destroy', $event) }}" onsubmit="return confirm('Yakin hapus event ini? Data pendaftar juga akan terhapus.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 text-sm bg-red-600 text-white rounded-md hover:bg-red-700">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white shadow-sm rounded-lg p-6 text-center text-gray-500">Belum ada event.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>