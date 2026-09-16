<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-4">Scan QR Code Peserta</h1>

            <div id="reader" class="w-full"></div>

            <div id="result" class="mt-4 p-4 rounded hidden"></div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            fetch("{{ route('attendance.scan') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: JSON.stringify({ qr_code_hash: decodedText }),
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('result');
                resultDiv.classList.remove('hidden', 'bg-green-100', 'bg-red-100');
                resultDiv.classList.add(data.success ? 'bg-green-100' : 'bg-red-100');
                resultDiv.innerText = data.message;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        const html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 250 },
            onScanSuccess
        );
    </script>
</x-app-layout>