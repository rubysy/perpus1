<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            History Peminjaman
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            @if($history->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada history peminjaman</h3>
                    <p class="mt-1 text-sm text-gray-500">Silakan pinjam buku terlebih dahulu melalui halaman Beranda.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Buku</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batas Kembali</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($history as $item)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($item->buku->cover)
                                                <div class="flex-shrink-0 h-10 w-8 mr-3">
                                                    <img class="h-10 w-8 object-cover rounded" src="{{ asset('storage/' . $item->buku->cover) }}" alt="">
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $item->buku->judul }}</div>
                                                <div class="text-xs text-gray-500">{{ $item->durasi_pinjam }} Hari | Peminjam: {{ $item->nama_peminjam }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->tanggal_pinjam->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm {{ $item->getBatasKembali()->isPast() && !in_array($item->status, ['dikembalikan', 'ditolak', 'pengajuan_kembali']) ? 'text-red-600 font-bold' : 'text-gray-500' }}">
                                        {{ $item->getBatasKembali()->format('d M Y') }}
                                        @if($item->getBatasKembali()->isPast() && !in_array($item->status, ['dikembalikan', 'ditolak', 'pengajuan_kembali']))
                                            <span class="ml-1 text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-800">Terlambat</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <!-- Interactive Status Badge -->
                                        @if($item->status == 'menunggu')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 cursor-pointer" onclick="showProof('{{ $item->status }}')">
                                                Menunggu Persetujuan
                                            </span>
                                        @elseif($item->status == 'disetujui' || $item->status == 'dipinjam')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 cursor-pointer" onclick="showProof('{{ $item->status }}')">
                                                Sedang Dipinjam
                                            </span>
                                        @elseif($item->status == 'pengajuan_kembali')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 cursor-pointer" onclick="showProof('{{ $item->status }}')">
                                                Menunggu Verifikasi Kembali
                                            </span>
                                        @elseif($item->status == 'dikembalikan')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 cursor-pointer" onclick="showProof('{{ $item->status }}')">
                                                Selesai Dikembalikan
                                            </span>
                                        @elseif($item->status == 'ditolak')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 cursor-pointer" onclick="showProof('{{ $item->status }}')">
                                                Peminjaman Ditolak
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 cursor-pointer" onclick="showProof('{{ $item->status }}')">
                                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm font-medium">
                                        <div class="flex flex-col gap-2 w-full max-w-[150px] mx-auto">
                                            @if($item->status === 'dipinjam')
                                                <form action="{{ route('user.history.kembalikan', $item->id) }}" method="POST" onsubmit="return confirm('Ajukan pengembalian buku? Pastikan Anda sudah menyerahkan fisik buku ke petugas.');">
                                                    @csrf
                                                    <button type="submit" class="w-full text-white bg-orange-500 hover:bg-orange-600 px-3 py-1.5 rounded shadow-sm text-xs font-semibold">
                                                        Ajukan Kembali
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($item->status === 'dikembalikan')
                                                <!-- Cek jika ulasan sudah ada di relasi -->
                                                @if(!$item->ulasan)
                                                    <button type="button" onclick="bukaModalUlasan('{{ $item->id }}', '{{ addslashes($item->buku->judul) }}')" class="w-full text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-1.5 rounded shadow-sm text-xs font-semibold">
                                                        Beri Ulasan
                                                    </button>
                                                @else
                                                    <span class="text-xs text-green-600 font-semibold"><i class="fas fa-check"></i> Sudah Diulas</span>
                                                @endif
                                            @endif

                                            @if(in_array($item->status, ['ditolak', 'menunggu', 'pengajuan_kembali']))
                                                <span class="text-gray-400 text-xs italic">-</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $history->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Hidden Form for Ulasan with SweetAlert -->
    <template id="form-ulasan-template">
        <form id="ulasanForm" class="text-left py-2">
            <input type="hidden" id="peminjamanId">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Rating (1-5 Bintang)</label>
                <div class="flex justify-center space-x-2 text-2xl mb-2 cursor-pointer" id="starContainer">
                    <span data-val="1" class="text-gray-300">★</span>
                    <span data-val="2" class="text-gray-300">★</span>
                    <span data-val="3" class="text-gray-300">★</span>
                    <span data-val="4" class="text-gray-300">★</span>
                    <span data-val="5" class="text-gray-300">★</span>
                </div>
                <input type="hidden" id="ulasanRating" value="5" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Komentar & Ulasan (Opsional)</label>
                <textarea id="ulasanKomentar" rows="4" class="w-full rounded border-gray-300 px-3 py-2 border shadow-sm" placeholder="Bagikan kesan Anda tentang buku ini..."></textarea>
            </div>
        </form>
    </template>

    @push('scripts')
    <script>
        function showProof(status) {
            let title = 'Status Detail';
            let message = '';
            
            if(status === 'menunggu') message = 'Peminjaman Anda sedang menunggu persetujuan dari Admin atau Petugas.';
            if(status === 'disetujui' || status === 'dipinjam') message = 'Buku sedang Anda pinjam. Harap kembalikan tepat waktu.';
            if(status === 'pengajuan_kembali') message = 'Pengajuan kembali sedang diproses. Petugas sedang memverifikasi kondisi fisik buku.';
            if(status === 'dikembalikan') message = 'Buku telah berhasil dikembalikan, stok sudah bertambah. Terima kasih!';
            if(status === 'ditolak') message = 'Mohon maaf, pengajuan pinjaman Anda ditolak (kemungkinan stok habis/admin menolak).';

            Swal.fire({
                title: title,
                text: message,
                icon: 'info',
                confirmButtonColor: '#4f46e5'
            });
        }

        function bukaModalUlasan(pId, judul) {
            const templateHtml = document.getElementById('form-ulasan-template').innerHTML;
            
            Swal.fire({
                title: 'Beri Ulasan Buku',
                html: `<p class="text-sm text-gray-500 mb-4 px-2">Buku: <strong>${judul}</strong></p>${templateHtml}`,
                showCancelButton: true,
                confirmButtonText: 'Kirim Ulasan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#4f46e5',
                didOpen: () => {
                    document.getElementById('peminjamanId').value = pId;
                    
                    // Star rating logic
                    const stars = document.querySelectorAll('#starContainer span');
                    const ratingInput = document.getElementById('ulasanRating');
                    
                    // Initial highlight
                    highlightStars(parseInt(ratingInput.value));

                    stars.forEach(star => {
                        star.addEventListener('click', function() {
                            const val = this.getAttribute('data-val');
                            ratingInput.value = val;
                            highlightStars(val);
                        });
                        
                        // Hover effects
                        star.addEventListener('mouseover', function() {
                            highlightStars(this.getAttribute('data-val'));
                        });
                        
                        star.parentElement.addEventListener('mouseleave', function() {
                            highlightStars(ratingInput.value);
                        });
                    });

                    function highlightStars(val) {
                        stars.forEach(s => {
                            if(parseInt(s.getAttribute('data-val')) <= val) {
                                s.classList.remove('text-gray-300');
                                s.classList.add('text-yellow-400');
                            } else {
                                s.classList.remove('text-yellow-400');
                                s.classList.add('text-gray-300');
                            }
                        });
                    }
                },
                preConfirm: () => {
                    const rating = document.getElementById('ulasanRating').value;
                    const komentar = document.getElementById('ulasanKomentar').value;
                    
                    if (!rating) {
                        Swal.showValidationMessage('Rating wajib diisi!');
                        return false;
                    }
                    return { rating, komentar, peminjaman_id: pId };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Ciptakan dan submit form tersembunyi
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/user/ulasan/${result.value.peminjaman_id}`;
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    form.appendChild(csrfToken);
                    
                    const ratingField = document.createElement('input');
                    ratingField.type = 'hidden';
                    ratingField.name = 'rating';
                    ratingField.value = result.value.rating;
                    form.appendChild(ratingField);

                    const komentarField = document.createElement('input');
                    komentarField.type = 'hidden';
                    komentarField.name = 'komentar';
                    komentarField.value = result.value.komentar;
                    form.appendChild(komentarField);

                    document.body.appendChild(form);
                    Swal.fire({title: 'Mengirim...', didOpen: () => {Swal.showLoading();}});
                    form.submit();
                }
            });
        }
    </script>
    @endpush
</x-user-layout>
