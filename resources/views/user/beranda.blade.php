<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Beranda Buku
        </h2>
    </x-slot>

    <!-- Search & Filter Form -->
    <div class="bg-white p-4 rounded-lg shadow-sm mb-6 border border-gray-100">
        <form action="{{ route('user.beranda') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-grow">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul buku atau penulis..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div class="md:w-64 flex-shrink-0">
                <select name="kategori" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-shrink-0">
                <button type="submit" class="w-full md:w-auto px-6 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition">Cari</button>
            </div>
        </form>
    </div>

    <!-- Book Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($buku as $item)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition">
                <div class="h-64 bg-gray-100 relative overflow-hidden group">
                    @if($item->cover)
                        <img src="{{ asset('storage/' . $item->cover) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                            <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <span>No Cover</span>
                        </div>
                    @endif
                    <!-- Hover Overlay for Detail action -->
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button onclick="showBukuDetail({{ $item->id }})" class="px-4 py-2 bg-white text-indigo-600 font-bold rounded-md hover:bg-indigo-50 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                            Lihat Detail
                        </button>
                    </div>
                </div>
                <div class="p-4 flex-grow flex flex-col">
                    <h3 class="font-bold text-lg text-gray-900 line-clamp-2" title="{{ $item->judul }}">{{ $item->judul }}</h3>
                    <p class="text-sm text-gray-500 mb-2">{{ $item->penulis }}</p>
                    
                    <div class="flex flex-wrap gap-1 mb-3">
                        @foreach($item->kategori->take(2) as $kat)
                            <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-xs rounded-full">{{ $kat->nama }}</span>
                        @endforeach
                        @if($item->kategori->count() > 2)
                            <span class="px-2 py-0.5 bg-gray-50 text-gray-600 text-xs rounded-full">+{{ $item->kategori->count() - 2 }}</span>
                        @endif
                    </div>
                    
                    <div class="mt-auto pt-3 border-t border-gray-100 flex justify-between items-center">
                        <div class="flex items-center text-yellow-400">
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="ml-1 text-sm text-gray-600">{{ number_format($item->averageRating(), 1) ?: '-' }}</span>
                        </div>
                        <span class="text-xs font-semibold {{ $item->stok > 0 ? 'text-green-600' : 'text-red-500' }}">
                            {{ $item->stok > 0 ? "Tersedia ({$item->stok})" : 'Habis' }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-lg shadow-sm">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada buku</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada buku yang sesuai dengan pencarian atau filter Anda.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $buku->links() }}
    </div>

    <!-- Modal Form Pinjam (Hidden by default) -->
    <template id="form-pinjam-template">
        <form id="formPinjam" class="text-left py-2">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Peminjam</label>
                <input type="text" id="pinjamNama" class="w-full rounded border-gray-300 px-3 py-2 border shadow-sm" value="{{ auth()->user()->name }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Langkap</label>
                <textarea id="pinjamAlamat" rows="3" class="w-full rounded border-gray-300 px-3 py-2 border shadow-sm" required>{{ auth()->user()->alamat }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Durasi Pinjam (Hari)</label>
                <input type="number" id="pinjamDurasi" min="1" max="14" value="7" class="w-full rounded border-gray-300 px-3 py-2 border shadow-sm" required>
                <p class="text-xs text-gray-500 mt-1">Maksimal 14 hari</p>
            </div>
        </form>
    </template>

    @push('scripts')
    <script>
        function showBukuDetail(id) {
            Swal.fire({
                title: 'Memuat Data...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/user/buku/${id}`)
                .then(response => response.json())
                .then(data => {
                    const b = data.buku;
                    // Format kategori
                    const kats = b.kategori.map(k => `<span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full mr-1 mb-1 inline-block">${k.nama}</span>`).join('');
                    
                    // Format ulasan
                    let ulasanHtml = '';
                    if(b.ulasan && b.ulasan.length > 0) {
                        ulasanHtml = `<div class="mt-4 pt-4 border-t border-gray-200 text-left max-h-40 overflow-y-auto w-full">
                            <h4 class="font-bold text-sm mb-2 text-gray-800">Ulasan Pembaca</h4>`;
                        b.ulasan.forEach(u => {
                            let stars = '★'.repeat(u.rating) + '☆'.repeat(5 - u.rating);
                            ulasanHtml += `<div class="mb-3 bg-gray-50 p-2 rounded">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-semibold text-xs text-gray-800">${u.user.name}</span>
                                    <span class="text-yellow-500 text-xs">${stars}</span>
                                </div>
                                <p class="text-xs text-gray-600 text-left">${u.komentar || '-'}</p>
                            </div>`;
                        });
                        ulasanHtml += `</div>`;
                    } else {
                        ulasanHtml = `<div class="mt-4 pt-4 border-t border-gray-200 text-left w-full"><p class="text-xs text-gray-500 italic">Belum ada ulasan</p></div>`;
                    }

                    // Cover HTML
                    let coverHtml = b.cover ? 
                        `<img src="/storage/${b.cover}" class="w-32 h-44 object-cover rounded shadow-md mx-auto mb-4">` : 
                        `<div class="w-32 h-44 bg-gray-200 mx-auto rounded mb-4 flex items-center justify-center text-gray-400">No Cover</div>`;

                    // Buttons Logic
                    let btnKoleksiText = data.is_koleksi ? 'Hapus Daftar Keinginan' : 'Tambah Keinginan';
                    let btnKoleksiClass = data.is_koleksi ? 'bg-gray-200 text-gray-700' : 'bg-pink-100 text-pink-700 border border-pink-300';
                    let btnKoleksiIcon = data.is_koleksi ? '♥' : '♡';

                    let btnPinjamHtml = '';
                    if (data.sedang_dipinjam) {
                        btnPinjamHtml = `<button disabled class="px-4 py-2 bg-gray-300 text-gray-600 rounded cursor-not-allowed">Sedang Dipinjam/Diproses</button>`;
                    } else if (b.stok <= 0) {
                        btnPinjamHtml = `<button disabled class="px-4 py-2 bg-red-300 text-red-800 rounded cursor-not-allowed">Stok Habis</button>`;
                    } else {
                        btnPinjamHtml = `<button onclick="prosesPinjam(${b.id})" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition font-semibold w-full sm:w-auto">Pinjam Buku Ini</button>`;
                    }

                    Swal.fire({
                        title: b.judul,
                        html: `
                            ${coverHtml}
                            <div class="text-sm text-gray-600 mb-2">Penulis: <strong>${b.penulis}</strong> | Penerbit: <strong>${b.penerbit}</strong></div>
                            <div class="text-sm text-gray-600 mb-3">Tahun: ${b.tahun_terbit || '-'} | ISBN: ${b.isbn || '-'} | Stok: ${b.stok}</div>
                            <div class="mb-4">${kats}</div>
                            <div class="text-left text-sm text-gray-700 mb-6 bg-gray-50 p-3 rounded border w-full max-h-32 overflow-y-auto">
                                ${b.deskripsi ? b.deskripsi.replace(/\n/g, '<br>') : 'Tidak ada deskripsi'}
                            </div>
                            
                            <div class="flex flex-col sm:flex-row gap-2 justify-center w-full mb-2">
                                <button onclick="toggleKoleksi(${b.id})" id="btnKoleksi" class="px-4 py-2 rounded transition font-medium w-full sm:w-auto flex items-center justify-center gap-1 ${btnKoleksiClass}">
                                    <span class="text-lg leading-none">${btnKoleksiIcon}</span> <span id="btnKoleksiTxt">${btnKoleksiText}</span>
                                </button>
                                ${btnPinjamHtml}
                            </div>
                            ${ulasanHtml}
                        `,
                        width: '600px',
                        showConfirmButton: false,
                        showCloseButton: true,
                        customClass: {
                            popup: 'rounded-xl shadow-2xl',
                            htmlContainer: 'w-full'
                        }
                    });
                })
                .catch(error => {
                    Swal.fire('Error', 'Gagal memuat detail buku', 'error');
                });
        }

        function toggleKoleksi(id) {
            Swal.showLoading();
            fetch(`/user/koleksi/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const btn = document.getElementById('btnKoleksi');
                const btnTxt = document.getElementById('btnKoleksiTxt');
                if(data.status === 'added') {
                    btn.className = 'px-4 py-2 rounded transition font-medium w-full sm:w-auto flex items-center justify-center gap-1 bg-gray-200 text-gray-700';
                    btn.innerHTML = '<span class="text-lg leading-none">♥</span> <span id="btnKoleksiTxt">Hapus Daftar Keinginan</span>';
                    Swal.mixin({toast: true, position: 'top-end', showConfirmButton: false, timer: 3000}).fire('Success', data.message, 'success');
                } else {
                    btn.className = 'px-4 py-2 rounded transition font-medium w-full sm:w-auto flex items-center justify-center gap-1 bg-pink-100 text-pink-700 border border-pink-300';
                    btn.innerHTML = '<span class="text-lg leading-none">♡</span> <span id="btnKoleksiTxt">Tambah Keinginan</span>';
                    Swal.mixin({toast: true, position: 'top-end', showConfirmButton: false, timer: 3000}).fire('Success', data.message, 'info');
                }
            });
        }

        function prosesPinjam(buku_id) {
            const templateHtml = document.getElementById('form-pinjam-template').innerHTML;
            
            Swal.fire({
                title: 'Form Peminjaman',
                html: templateHtml,
                showCancelButton: true,
                confirmButtonText: 'Ajukan Pinjaman',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#4f46e5',
                preConfirm: () => {
                    const nama = document.getElementById('pinjamNama').value;
                    const alamat = document.getElementById('pinjamAlamat').value;
                    const durasi = document.getElementById('pinjamDurasi').value;

                    if (!nama || !alamat || !durasi) {
                        Swal.showValidationMessage('Semua field harus diisi!');
                        return false;
                    }

                    if (durasi < 1 || durasi > 14) {
                        Swal.showValidationMessage('Durasi maksimal 14 hari!');
                        return false;
                    }

                    return { nama, alamat, durasi };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({title: 'Memproses...', didOpen: () => {Swal.showLoading();}});
                    
                    fetch(`/user/buku/${buku_id}/pinjam`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            nama_peminjam: result.value.nama,
                            alamat: result.value.alamat,
                            durasi_pinjam: result.value.durasi
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Berhasil!', data.message, 'success').then(() => {
                                window.location.href = '{{ route("user.history.index") }}';
                            });
                        } else {
                            Swal.fire('Gagal!', data.message || 'Terjadi kesalahan.', 'error');
                        }
                    })
                    .catch(err => {
                        Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                    });
                } else if(result.isDismissed) {
                    // re-open detail
                    showBukuDetail(buku_id);
                }
            });
        }
    </script>
    @endpush
</x-user-layout>
