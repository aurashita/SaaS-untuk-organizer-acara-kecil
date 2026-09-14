<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white shadow rounded p-6">
            <form method="POST" action="{{ route('events.store') }}">
                @csrf
                <label>Nama Event</label>
                <input type="text" name="name" class="w-full border rounded p-2 mb-3" required>

                <label>Tanggal & Waktu</label>
                <input type="datetime-local" name="date" class="w-full border rounded p-2 mb-3" required>

                <label>Lokasi</label>
                <input type="text" name="location" class="w-full border rounded p-2 mb-3" required>

                <label>Deskripsi</label>
                <textarea name="description" class="w-full border rounded p-2 mb-3"></textarea>

                <label>Kuota Peserta</label>
                <input type="number" name="quota" class="w-full border rounded p-2 mb-3" required>

                <label>Harga (kosongkan jika gratis)</label>
                <input type="number" name="price" class="w-full border rounded p-2 mb-3">

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            </form>
        </div>
    </div>
</x-app-layout>