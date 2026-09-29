<x-guest-layout>
    <div class="-m-6 mb-0 sm:-m-8 sm:mb-0 bg-gradient-to-br from-green-500 to-emerald-600 text-white p-6 sm:p-8 rounded-t-xl text-center">
        <div class="text-3xl mb-1"></div>
        <h1 class="text-lg font-bold">Pendaftaran Berhasil!</h1>
    </div>

    <div class="border-2 border-dashed border-gray-300 rounded-b-xl -m-6 mt-0 sm:-m-8 sm:mt-0 p-6 space-y-4 text-center">
        <div>
            <p class="font-semibold text-gray-900">{{ $registration->event->name }}</p>
            <p class="text-sm text-gray-500">{{ $registration->participant->name }}</p>
        </div>

        <p class="text-sm text-gray-600">Tunjukkan QR Code ini saat check-in di lokasi acara.</p>

        <div id="qr-wrapper" class="flex justify-center py-2">
            {!! $qrCode !!}
        </div>

        <p class="text-xs text-gray-400 break-all font-mono">{{ $registration->qr_code_hash }}</p>

        <button type="button" onclick="downloadTicket()"
            class="w-full px-4 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700">
            ⬇ Unduh E-Ticket (PNG)
        </button>

        <p class="text-xs text-gray-400">Simpan tiketmu. Halaman ini juga bisa dibuka lagi lewat link yang sama.</p>
    </div>

    <script>
        function downloadTicket() {
            const svg = document.querySelector('#qr-wrapper svg');
            const svgString = new XMLSerializer().serializeToString(svg);
            const url = URL.createObjectURL(new Blob([svgString], { type: 'image/svg+xml;charset=utf-8' }));
            const img = new Image();

            img.onload = () => {
                const canvas = document.createElement('canvas');
                canvas.width = 600;
                canvas.height = 760;
                const ctx = canvas.getContext('2d');

                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, 50, 130, 500, 500);

                ctx.fillStyle = '#111827';
                ctx.textAlign = 'center';
                ctx.font = 'bold 28px sans-serif';
                ctx.fillText(@json($registration->event->name), 300, 60);
                ctx.font = '22px sans-serif';
                ctx.fillText(@json($registration->participant->name), 300, 100);
                ctx.font = '16px monospace';
                ctx.fillText(@json($registration->qr_code_hash), 300, 690);

                URL.revokeObjectURL(url);

                const link = document.createElement('a');
                link.download = 'e-ticket.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            };

            img.src = url;
        }
    </script>
</x-guest-layout>