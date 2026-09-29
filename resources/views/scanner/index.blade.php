<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Scan Kehadiran</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-4">
                <p class="text-sm text-gray-600 mb-3">Arahkan kamera ke QR Code pada e-ticket peserta.</p>
                <div id="reader" class="w-full"></div>
                <div id="result" class="mt-4 p-4 rounded-md hidden"></div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        const resultDiv = document.getElementById('result');
        const html5QrCode = new Html5Qrcode("reader");
        let isProcessing = false;

        function showResult(success, message) {
            resultDiv.classList.remove('hidden', 'bg-green-100', 'text-green-800', 'bg-red-100', 'text-red-800');
            resultDiv.classList.add(...(success ? ['bg-green-100', 'text-green-800'] : ['bg-red-100', 'text-red-800']));
            resultDiv.innerText = message;
        }

        function onScanSuccess(decodedText) {
            if (isProcessing) return;
            isProcessing = true;
            html5QrCode.pause(true); // hentikan kamera sementara

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
            .then(data => showResult(data.success, data.message))
            .catch(() => showResult(false, 'Terjadi kesalahan jaringan. Coba scan ulang.'))
            .finally(() => {
                // lanjutkan scan setelah 3 detik
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