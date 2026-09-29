@php($e = $event ?? null)
@csrf

<div>
    <label for="name" class="block text-sm font-medium text-gray-700">Nama Acara</label>
    <input id="name" name="name" type="text" value="{{ old('name', $e?->name) }}" required
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="date" class="block text-sm font-medium text-gray-700">Tanggal & Waktu</label>
    <input id="date" name="date" type="datetime-local" value="{{ old('date', $e?->date?->format('Y-m-d\TH:i')) }}" required
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    @error('date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="location" class="block text-sm font-medium text-gray-700">Lokasi</label>
    <input id="location" name="location" type="text" value="{{ old('location', $e?->location) }}" required
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
    <textarea id="description" name="description" rows="3"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $e?->description) }}</textarea>
    @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label for="quota" class="block text-sm font-medium text-gray-700">Kuota Peserta</label>
        <input id="quota" name="quota" type="number" min="1" value="{{ old('quota', $e?->quota) }}" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('quota') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="price" class="block text-sm font-medium text-gray-700">Harga (kosongkan jika gratis)</label>
        <input id="price" name="price" type="number" min="0" value="{{ old('price', $e?->price) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>