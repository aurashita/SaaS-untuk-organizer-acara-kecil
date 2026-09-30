<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Event</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('events.update', $event) }}" class="bg-white shadow-sm rounded-xl p-6 sm:p-8 space-y-6">
                @method('PUT')
                @include('events._form')

                <div class="flex justify-end gap-2 pt-2 border-t">
                    <a href="{{ route('events.show', $event) }}" class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Batal</a>
                    <button type="submit" class="px-4 py-2 text-sm bg-pink-600 text-white rounded-lg hover:bg-pink-700">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>