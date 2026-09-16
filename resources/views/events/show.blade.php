<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-2">{{ $event->name }}</h1>
            <p class="mb-6 text-gray-600">{{ $event->date }} — {{ $event->location }}</p>

            <div class="bg-white shadow rounded p-4">
                <h2 class="text-lg font-semibold mb-3">
                    Daftar Peserta ({{ $event->registrations->count() }})
                </h2>

                @forelse ($event->registrations as $registration)
                    <div class="border-b py-2 flex justify-between">
                        <span>{{ $registration->participant->name }} — {{ $registration->participant->email }}</span>
                        <span class="text-sm {{ $registration->attendance_status === 'hadir' ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $registration->attendance_status === 'hadir' ? 'Sudah Hadir' : 'Belum Hadir' }}
                        </span>
                    </div>
                @empty
                    <p>Belum ada peserta yang daftar.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>