<x-guest-layout>
    <div class="space-y-4">
        <div>
            <h1 class="text-xl font-bold text-gray-900">{{ $event->name }}</h1>
            <p class="text-sm text-gray-600">
                {{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }} · {{ $event->location }}
            </p>
            @if ($event->description)
                <p class="mt-2 text-sm text-gray-700">{{ $event->description }}</p>
            @endif
            <p class="mt-2 text-sm font-medium {{ $sisaKuota > 0 ? 'text-green-700' : 'text-red-700' }}">
                {{ $sisaKuota > 0 ? 'Sisa kuota: ' . $sisaKuota : 'Kuota penuh' }}
            </p>
        </div>

        @error('quota')
            <div class="p-3 bg-red-100 text-red-800 rounded-md text-sm">{{ $message }}</div>
        @enderror

        <form method="POST" action="{{ route('registration.store', $event) }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit" @disabled($sisaKuota <= 0)
                class="w-full px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed">
                Daftar Sekarang
            </button>
        </form>
    </div>
</x-guest-layout>