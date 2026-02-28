<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Peminjaman
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batas Kembali</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($peminjaman as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->user->name }}</div>
                                    <div class="text-xs text-gray-500">Peminjam: {{ $item->nama_peminjam }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $item->buku->judul }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->tanggal_pinjam->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->getBatasKembali()->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($item->status == 'menunggu') bg-yellow-100 text-yellow-800 
                                        @elseif($item->status == 'disetujui' || $item->status == 'dipinjam') bg-blue-100 text-blue-800
                                        @elseif($item->status == 'ditolak') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    @if($item->status === 'menunggu')
                                        <div class="flex items-center justify-center space-x-2">
                                            <form action="{{ route('petugas.peminjaman.approve', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Setujui peminjaman ini?');">
                                                @csrf
                                                <button type="submit" class="text-white bg-green-500 hover:bg-green-600 px-3 py-1 rounded shadow-sm text-xs font-semibold">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('petugas.peminjaman.reject', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak peminjaman ini?');">
                                                @csrf
                                                <button type="submit" class="text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded shadow-sm text-xs font-semibold">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs italic">Selesai/Diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada data peminjaman yang perlu diproses.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $peminjaman->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
