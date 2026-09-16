<x-guest-layout>
    <div class="max-w-xl mx-auto py-12">
        <h1 class="text-2xl font-bold mb-4">Daftar: {{ $event->name }}</h1>
        <p class="mb-4">{{ $event->date }} — {{ $event->location }}</p>

        <form method="POST" action="{{ route('registration.store', $event) }}">
            @csrf
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="w-full border rounded p-2 mb-3" required>

            <label>Email</label>
            <input type="email" name="email" class="w-full border rounded p-2 mb-3" required>

            <label>Nomor WhatsApp</label>
            <input type="text" name="phone" class="w-full border rounded p-2 mb-3" required>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Daftar Sekarang</button>
        </form>
    </div>
</x-guest-layout>