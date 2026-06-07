<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman Buku</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
        }

        h1 {
            margin: 0;
            font-size: 18px;
            color: #1B6B5A;
        }

        .subtitle {
            color: #6B7280;
            font-size: 11px;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
        }

        .summary td {
            border: 1px solid #D4C9B0;
            padding: 6px 10px;
            background: #F5F0E8;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data th {
            background: #1B6B5A;
            color: white;
            padding: 6px 8px;
            font-size: 11px;
        }

        table.data td {
            border: 1px solid #D4C9B0;
            padding: 5px 8px;
        }

        table.data tr:nth-child(even) td {
            background: #F5F0E8;
        }

        .footer {
            margin-top: 16px;
            font-size: 10px;
            color: #6B7280;
            border-top: 1px solid #D4C9B0;
            padding-top: 8px;
        }
    </style>
</head>

<body>
    <h1>📚 Laporan Peminjaman Buku Perpustakaan</h1>
    <p class="subtitle">Tanggal cetak: {{ now()->format('d/m/Y H:i') }}</p>

    <table class="summary">
        <tr>
            <td>Total: <strong>{{ $summary['total'] }}</strong></td>
            <td>Dipinjam: <strong>{{ $summary['dipinjam'] }}</strong></td>
            <td>Dikembalikan: <strong>{{ $summary['dikembalikan'] }}</strong></td>
            <td>Terlambat: <strong>{{ $summary['terlambat'] }}</strong></td>
        </tr>
    </table>

    <p class="subtitle">
        Filter: {{ $filters['keyword'] ?? '-' }} |
        Status: {{ $filters['status'] ?? 'Semua' }} |
        Periode: {{ $filters['tanggal_mulai'] ?? '-' }} s.d. {{ $filters['tanggal_selesai'] ?? '-' }}
    </p>

    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Nama Anggota</th>
                <th>Tgl Pinjam</th>
                <th>Batas Kembali</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->buku->judul ?? '-' }}</td>
                    <td>{{ $item->anggota->nama ?? '-' }}</td>
                    <td>{{ $item->tanggal_pinjam?->format('d/m/Y') }}</td>
                    <td>{{ $item->tanggal_kembali_rencana?->format('d/m/Y') }}</td>
                    <td>{{ $item->tanggal_kembali_aktual?->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dibuat otomatis dari Sistem Peminjaman Buku Perpustakaan.
    </div>
</body>

</html>