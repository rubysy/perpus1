<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Kategori
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-2xl mx-auto">
        <div class="p-6 bg-white border-b border-gray-200">
            <form method="POST" action="{{ route('petugas.kategori.update', $kategori->id) }}">
                @csrf
                @method('PUT')

                <div>
                    <label for="nama" class="block font-medium text-sm text-gray-700">Nama Kategori</label>
                    <input id="nama" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="nama" value="{{ old('nama', $kategori->nama) }}" required autofocus />
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a href="{{ route('petugas.kategori.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Update Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
