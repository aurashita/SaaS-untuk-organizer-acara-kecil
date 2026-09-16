<x-guest-layout>
    <div class="max-w-xl mx-auto py-12 text-center">
        <h1 class="text-2xl font-bold mb-4">Pendaftaran Berhasil!</h1>
        <p>Kode tiket kamu: <strong>{{ $registration->qr_code_hash }}</strong></p>
        <p class="text-sm text-gray-500 mt-2">(QR Code visual akan ditambahkan di Sprint 3)</p>
    </div>
</x-guest-layout>
