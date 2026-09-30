<x-guest-layout>
    <div class="-m-6 mb-6 sm:-m-8 sm:mb-6 bg-gradient-to-br from-pink-600 to-pink-600 text-white p-6 sm:p-8 rounded-t-xl">
        <p class="text-xs uppercase tracking-wide text-pink-100 mb-1">Formulir Pendaftaran</p>
        <h1 class="text-xl font-bold">{{ $event->name }}</h1>
        <p class="text-sm text-pink-100 mt-1">
            📅 {{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }} · 📍 {{ $event->location }}
        </p>
    </div>

    <div class="space-y-4">
        @if ($event->description)
            <p class="text-sm text-gray-600">{{ $event->description }}</p>
        @endif

        <div class="flex items-center gap-2">
            <span class="text-sm font-medium px-2.5 py-1 rounded-full {{ $sisaKuota > 0 ? 'bg-sky-100 text-sky-700' : 'bg-red-100 text-red-700' }}">
                {{ $sisaKuota > 0 ? "Sisa kuota: $sisaKuota" : 'Kuota Penuh' }}
            </span>
        </div>

        @error('quota')
            <div class="p-3 bg-red-100 text-red-800 rounded-lg text-sm">{{ $message }}</div>
        @enderror

        <form method="POST" action="{{ route('registration.store', $event) }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone') }}" required
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit" @disabled($sisaKuota <= 0)
                class="w-full px-4 py-2.5 bg-pink-600 text-white font-medium rounded-lg hover:bg-pink-700 disabled:opacity-50 disabled:cursor-not-allowed">
                Daftar Sekarang
            </button>
        </form>
    </div>
</x-guest-layout>