<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $event->name }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('scanner.index') }}" class="px-4 py-2 text-sm bg-purple-600 text-white rounded-lg hover:bg-purple-700">Scan Kehadiran</a>
                <a href="{{ route('events.edit', $event) }}" class="px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Edit</a>
            </div>
        </div>
    </x-slot>

    @php
        $jumlahTerdaftar = $event->registrations->count();
        $persenKuota = $event->quota > 0 ? min(100, round($jumlahTerdaftar / $event->quota * 100)) : 0;
    @endphp

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md text-sm">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow-sm rounded-xl p-5 space-y-3">
                <p class="text-gray-600">📅 {{ $event->date->format('d M Y, H:i') }} · 📍 {{ $event->location }}</p>
                @if ($event->description)
                    <p class="text-gray-700">{{ $event->description }}</p>
                @endif

                <div>
                    <div class="flex justify-between text-sm text-gray-500 mb-1">
                        <span>Kuota terisi</span>
                        <span>{{ $jumlahTerdaftar }} / {{ $event->quota }}</span>
                    </div>
                    <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-indigo-500" style="width: {{ $persenKuota }}%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-xl p-5">
                <h3 class="font-semibold mb-2">Link Pendaftaran Publik</h3>
                <div class="flex flex-col sm:flex-row gap-2">
                    <input id="public-link" type="text" readonly value="{{ route('registration.show', $event) }}"
                        class="flex-1 rounded-lg border-gray-300 bg-gray-50 text-sm">
                    <button type="button" id="copy-btn" onclick="copyLink()"
                        class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Salin Link</button>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-xl p-5">
                <div class="flex items-center justify-between mb-3 gap-2 flex-wrap">
                    <h3 class="font-semibold">Daftar Peserta ({{ $jumlahTerdaftar }})</h3>
                    <input type="text" id="cari-peserta" oninput="cariPeserta()" placeholder="Cari nama peserta..."
                        class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div id="daftar-peserta">
                    @forelse ($event->registrations as $registration)
                        @php
                            $inisial = collect(explode(' ', $registration->participant->name))->map(fn ($k) => strtoupper($k[0] ?? ''))->take(2)->join('');
                            $hadir = $registration->attendance_status === 'hadir';
                        @endphp
                        <div class="peserta-item border-b last:border-0 py-3 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-semibold shrink-0">
                                    {{ $inisial }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-gray-900 truncate">{{ $registration->participant->name }}</p>
                                    <p class="text-sm text-gray-500 truncate">{{ $registration->participant->email }}</p>
                                </div>
                            </div>
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full shrink-0 {{ $hadir ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $hadir ? 'Sudah Hadir' : 'Belum Hadir' }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-6">Belum ada peserta yang daftar.</p>
                    @endforelse
                </div>
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

        function cariPeserta() {
            const kata = document.getElementById('cari-peserta').value.toLowerCase();
            document.querySelectorAll('.peserta-item').forEach(item => {
                item.style.display = item.innerText.toLowerCase().includes(kata) ? '' : 'none';
            });
        }
    </script>
</x-app-layout>