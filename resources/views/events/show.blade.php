<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $event->name }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('scanner.index') }}" class="px-4 py-2 text-sm bg-purple-600 text-white rounded-md hover:bg-purple-700">Scan Kehadiran</a>
                <a href="{{ route('events.edit', $event) }}" class="px-4 py-2 text-sm bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Edit</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-4 space-y-1">
                <p class="text-gray-600">{{ $event->date->format('d M Y, H:i') }} · {{ $event->location }}</p>
                <p class="text-gray-600">Kuota terisi: {{ $event->registrations->count() }} / {{ $event->quota }}</p>
                @if ($event->description)
                    <p class="text-gray-700 pt-2">{{ $event->description }}</p>
                @endif
            </div>

            <div class="bg-white shadow-sm rounded-lg p-4">
                <h3 class="font-semibold mb-2">Link Pendaftaran Publik</h3>
                <div class="flex flex-col sm:flex-row gap-2">
                    <input id="public-link" type="text" readonly value="{{ route('registration.show', $event) }}"
                        class="flex-1 rounded-md border-gray-300 bg-gray-50 text-sm">
                    <button type="button" id="copy-btn" onclick="copyLink()"
                        class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Salin Link</button>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-4">
                <h3 class="font-semibold mb-3">Daftar Peserta ({{ $event->registrations->count() }})</h3>

                @forelse ($event->registrations as $registration)
                    <div class="border-b last:border-0 py-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                        <div>
                            <p class="font-medium text-gray-900">{{ $registration->participant->name }}</p>
                            <p class="text-sm text-gray-500">{{ $registration->participant->email }} · {{ $registration->participant->phone }}</p>
                        </div>
                        <span class="text-sm font-medium {{ $registration->attendance_status === 'hadir' ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $registration->attendance_status === 'hadir' ? 'Sudah Hadir' : 'Belum Hadir' }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada peserta yang daftar.</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function copyLink() {
            const input = document.getElementById('public-link');
            const btn = document.getElementById('copy-btn');
            const done = () => {
                btn.innerText = 'Tersalin!';
                setTimeout(() => btn.innerText = 'Salin Link', 2000);
            };

            if (navigator.clipboard) {
                navigator.clipboard.writeText(input.value).then(done);
            } else {
                input.select();
                document.execCommand('copy');
                done();
            }
        }
    </script>
</x-app-layout>