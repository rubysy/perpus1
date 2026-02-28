<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Koleksi Pribadi
        </h2>
    </x-slot>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        @if($koleksi->isEmpty())
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                <h3 class="text-lg font-medium text-gray-900">Belum ada koleksi</h3>
                <p class="mt-1 text-sm text-gray-500">Anda belum menambahkan buku apapun ke daftar keinginan atau koleksi pribadi Anda.</p>
                <div class="mt-6">
                    <a href="{{ route('user.beranda') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cari Buku Sekarang
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($koleksi as $item)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition relative group" id="koleksi-card-{{ $item->buku_id }}">
                        
                        <!-- Remove button absolute top right -->
                        <button onclick="hapusKoleksi({{ $item->buku_id }})" class="absolute top-2 right-2 h-8 w-8 bg-white rounded-full flex items-center justify-center text-red-500 hover:text-red-700 hover:bg-red-50 shadow-md z-10 transition-colors" title="Hapus dari koleksi">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                        </button>

                        <div class="h-48 bg-gray-100 relative overflow-hidden">
                            @if($item->buku->cover)
                                <img src="{{ asset('storage/' . $item->buku->cover) }}" alt="{{ $item->buku->judul }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4 flex-grow flex flex-col">
                            <h3 class="font-bold text-md text-gray-900 line-clamp-2 mb-1" title="{{ $item->buku->judul }}">{{ $item->buku->judul }}</h3>
                            <p class="text-xs text-gray-500 mb-2">{{ $item->buku->penulis }}</p>
                            
                            <div class="mt-auto pt-3 border-t border-gray-100 flex justify-between items-center">
                                <span class="text-xs font-semibold {{ $item->buku->stok > 0 ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $item->buku->stok > 0 ? 'Stok Tersedia' : 'Habis' }}
                                </span>
                                <a href="{{ route('user.beranda') }}?search={{ urlencode($item->buku->judul) }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">Lihat Detail →</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $koleksi->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function hapusKoleksi(id) {
            Swal.fire({
                title: 'Hapus Buku?',
                text: "Anda yakin ingin menghapus buku ini dari koleksi pribadi?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    fetch(`/user/koleksi/${id}/toggle`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.status === 'removed') {
                            const card = document.getElementById(`koleksi-card-${id}`);
                            card.style.transition = "all 0.5s ease";
                            card.style.opacity = "0";
                            card.style.transform = "scale(0.9)";
                            setTimeout(() => {
                                card.remove();
                                // Refresh if empty
                                if(document.querySelectorAll('[id^="koleksi-card-"]').length === 0) {
                                    window.location.reload();
                                }
                            }, 500);
                            
                            Swal.mixin({toast: true, position: 'top-end', showConfirmButton: false, timer: 3000}).fire('Terhapus', data.message, 'success');
                        }
                    });
                }
            })
        }
    </script>
    @endpush
</x-user-layout>
