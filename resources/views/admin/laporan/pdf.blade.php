<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Peminjaman Perpustakaan</h1>
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="20%">Peminjam</th>
                <th width="30%">Judul Buku</th>
                <th width="15%" class="text-center">Tgl Pinjam</th>
                <th width="15%" class="text-center">Batas Kembali</th>
                <th width="15%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->buku->judul }}</td>
                    <td class="text-center">{{ $item->tanggal_pinjam->format('d/m/Y') }}</td>
                    <td class="text-center">{{ $item->getBatasKembali()->format('d/m/Y') }}</td>
                    <td class="text-center">{{ ucfirst(str_replace('_', ' ', $item->status)) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data peminjaman</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ $peminjaman->count() }} peminjaman</p>
    </div>
</body>
</html>
