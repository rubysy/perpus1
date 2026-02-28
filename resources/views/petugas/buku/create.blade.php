<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Buku
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 bg-white border-b border-gray-200">
            <form method="POST" action="{{ route('petugas.buku.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Column 1 -->
                    <div>
                        <div class="mb-4">
                            <label for="judul" class="block font-medium text-sm text-gray-700">Judul Buku</label>
                            <input id="judul" type="text" name="judul" value="{{ old('judul') }}" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                            @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="penulis" class="block font-medium text-sm text-gray-700">Penulis</label>
                            <input id="penulis" type="text" name="penulis" value="{{ old('penulis') }}" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                            @error('penulis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="penerbit" class="block font-medium text-sm text-gray-700">Penerbit</label>
                            <input id="penerbit" type="text" name="penerbit" value="{{ old('penerbit') }}" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                            @error('penerbit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="isbn" class="block font-medium text-sm text-gray-700">ISBN</label>
                                <input id="isbn" type="text" name="isbn" value="{{ old('isbn') }}" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                                @error('isbn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="tahun_terbit" class="block font-medium text-sm text-gray-700">Tahun Terbit</label>
                                <input id="tahun_terbit" type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                                @error('tahun_terbit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="stok" class="block font-medium text-sm text-gray-700">Stok</label>
                            <input id="stok" type="number" min="0" name="stok" value="{{ old('stok', 0) }}" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                            @error('stok') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div>
                        <div class="mb-4 bg-gray-50 p-4 rounded-md border border-gray-200">
                            <label class="block font-medium text-sm text-gray-700 mb-2">Kategori Buku (Pilih minimal 1)</label>
                            <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto p-2">
                                @foreach($kategori as $kat)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="kategori[]" value="{{ $kat->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ (is_array(old('kategori')) && in_array($kat->id, old('kategori'))) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600">{{ $kat->nama }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="cover" class="block font-medium text-sm text-gray-700">Cover Buku (Opsional)</label>
                            <input id="cover" type="file" name="cover" accept="image/*" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            @error('cover') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="block font-medium text-sm text-gray-700">Deskripsi</label>
                            <textarea id="deskripsi" name="deskripsi" rows="5" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6 pt-4 border-t border-gray-200">
                    <a href="{{ route('petugas.buku.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Simpan Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
