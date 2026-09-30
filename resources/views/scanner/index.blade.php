<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Scan Kehadiran</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white shadow-sm rounded-xl p-5">
                <p class="text-sm text-gray-600 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-pink-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Arahkan kamera ke QR Code pada e-ticket peserta.
                </p>

                <div class="relative rounded-lg overflow-hidden border-2 border-pink-200">
                    <div id="reader" class="w-full"></div>
                </div>

                <div id="result" class="mt-4 p-4 rounded-lg hidden text-sm font-medium text-center"></div>
            </div>

            <div class="bg-white shadow-sm rounded-xl p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Riwayat Scan Terakhir</h3>
                <ul id="riwayat" class="space-y-2 text-sm text-gray-500">
                    <li class="text-gray-400 italic">Belum ada aktivitas scan pada sesi ini.</li>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        const resultDiv = document.getElementById('result');
        const riwayatEl = document.getElementById('riwayat');
        const html5QrCode = new Html5Qrcode("reader");
        let isProcessing = false;
        let riwayatKosong = true;

        function showResult(success, mesyellow) {
            resultDiv.classList.remove('hidden', 'bg-yellow-100', 'text-yellow-800', 'bg-red-100', 'text-red-800');
            resultDiv.classList.add(...(success ? ['bg-yellow-100', 'text-yellow-800'] : ['bg-red-100', 'text-red-800']));
            resultDiv.innerText = (success ? '✅ ' : '⚠️ ') + mesyellow;
            tambahRiwayat(success, mesyellow);
        }

        function tambahRiwayat(success, mesyellow) {
            if (riwayatKosong) {
                riwayatEl.innerHTML = '';
                riwayatKosong = false;
            }
            const item = document.createElement('li');
            item.className = 'flex items-center gap-2';
            const waktu = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            item.innerHTML = `<span>${success ? '✅' : '⚠️'}</span><span class="text-gray-400">${waktu}</span><span class="flex-1 truncate">${mesyellow}</span>`;
            riwayatEl.prepend(item);
        }

        function onScanSuccess(decodedText) {
            if (isProcessing) return;
            isProcessing = true;
            html5QrCode.pause(true);

            fetch("{{ route('attendance.scan') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: JSON.stringify({ qr_code_hash: decodedText }),
            })
            .then(response => response.json())
            .then(data => showResult(data.success, data.mesyellow))
            .catch(() => showResult(false, 'Terjadi kesalahan jaringan. Coba scan ulang.'))
            .finally(() => {
                setTimeout(() => {
                    html5QrCode.resume();
                    isProcessing = false;
                }, 3000);
            });
        }

        html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: { width: 250, height: 250 } },
            onScanSuccess
        );
    </script>
</x-app-layout>