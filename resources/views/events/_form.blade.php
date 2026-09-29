@php($e = $event ?? null)
@csrf

<div class="space-y-5">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Acara</label>
        <input id="name" name="name" type="text" value="{{ old('name', $e?->name) }}" required
            placeholder="Contoh: Workshop Laravel untuk Pemula"
            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700 mb-1"> Tanggal &amp; Waktu</label>
            <input id="date" name="date" type="datetime-local" value="{{ old('date', $e?->date?->format('Y-m-d\TH:i')) }}" required
                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="location" class="block text-sm font-medium text-gray-700 mb-1"> Lokasi</label>
            <input id="location" name="location" type="text" value="{{ old('location', $e?->location) }}" required
                placeholder="Contoh: Aula Kampus A"
                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
        <textarea id="description" name="description" rows="3" placeholder="Ceritakan sedikit tentang acaramu..."
            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $e?->description) }}</textarea>
        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="quota" class="block text-sm font-medium text-gray-700 mb-1"> Kuota Peserta</label>
            <input id="quota" name="quota" type="number" min="1" value="{{ old('quota', $e?->quota) }}" required
                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('quota') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1"> Harga (kosongkan jika gratis)</label>
            <input id="price" name="price" type="number" min="0" value="{{ old('price', $e?->price) }}" placeholder="0"
                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>