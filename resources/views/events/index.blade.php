<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('events.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                + Buat Event Baru
            </a>

            <div class="mt-4 bg-white shadow rounded p-4">
                @forelse ($events as $event)
                    <a href="{{ route('events.show', $event) }}" class="block border-b py-2 hover:bg-gray-50">
                        <strong>{{ $event->name }}</strong> — {{ $event->date }} — {{ $event->location }}
                    </a>
                @empty
                    <p>Belum ada event.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>