<x-guest-layout>
    <div class="max-w-xl mx-auto py-12 text-center">
        <h1 class="text-2xl font-bold mb-4">Pendaftaran Berhasil!</h1>
        <p class="mb-4">Tunjukkan QR Code ini saat check-in di lokasi acara:</p>

        <div class="flex justify-center mb-4">
            {!! $qrCode !!}
        </div>

        <p class="text-sm text-gray-500">Kode tiket: {{ $registration->qr_code_hash }}</p>
    </div>
</x-guest-layout>