@php($e = $event ?? null)
@csrf

<div class="space-y-5">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Acara</label>
        <input id="name" name="name" type="text" value="{{ old('name', $e?->name) }}" required
            placeholder="Contoh: Workshop Laravel untuk Pemula"
            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $mesyellow }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700 mb-1"> Tanggal &amp; Waktu</label>
            <input id="date" name="date" type="datetime-local" value="{{ old('date', $e?->date?->format('Y-m-d\TH:i')) }}" required
                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
            @error('date') <p class="mt-1 text-sm text-red-600">{{ $mesyellow }}</p> @enderror
        </div>
        <div>
            <label for="location" class="block text-sm font-medium text-gray-700 mb-1"> Lokasi</label>
            <input id="location" name="location" type="text" value="{{ old('location', $e?->location) }}" required
                placeholder="Contoh: Aula Kampus A"
                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
            @error('location') <p class="mt-1 text-sm text-red-600">{{ $mesyellow }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
        <textarea id="description" name="description" rows="3" placeholder="Ceritakan sedikit tentang acaramu..."
            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">{{ old('description', $e?->description) }}</textarea>
        @error('description') <p class="mt-1 text-sm text-red-600">{{ $mesyellow }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="quota" class="block text-sm font-medium text-gray-700 mb-1"> Kuota Peserta</label>
            <input id="quota" name="quota" type="number" min="1" value="{{ old('quota', $e?->quota) }}" required
                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
            @error('quota') <p class="mt-1 text-sm text-red-600">{{ $mesyellow }}</p> @enderror
        </div>
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1"> Harga (kosongkan jika gratis)</label>
            <input id="price" name="price" type="number" min="0" value="{{ old('price', $e?->price) }}" placeholder="0"
                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
            @error('price') <p class="mt-1 text-sm text-red-600">{{ $mesyellow }}</p> @enderror
        </div>
    </div>
    <div class="pt-2 border-t">
    <label class="flex items-center gap-2">
        <input type="checkbox" name="is_private" value="1" id="is_private"
            {{ old('is_private', $e?->is_private) ? 'checked' : '' }}
            onchange="document.getElementById('kotak-undangan').classList.toggle('hidden', !this.checked)"
            class="rounded border-gray-300 text-pink-600 focus:ring-pink-500">
        <span class="text-sm font-medium text-gray-700">🔒︎ Acara Privat (khusus undangan)</span>
    </label>

    <div id="kotak-undangan" class="{{ old('is_private', $e?->is_private) ? '' : 'hidden' }} mt-3">
        <label for="invited_emails" class="block text-sm font-medium text-gray-700 mb-1">
            Daftar Email yang Diundang
        </label>
        <textarea id="invited_emails" name="invited_emails" rows="4"
            placeholder="Masukkan satu email per baris, contoh:&#10;andi@email.com&#10;budi@email.com"
            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">{{ old('invited_emails', $e?->invitations->pluck('email')->join("\n")) }}</textarea>
        <p class="mt-1 text-xs text-gray-400">Pisahkan tiap email dengan baris baru (Enter).</p>
        @error('invited_emails') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>
</div>