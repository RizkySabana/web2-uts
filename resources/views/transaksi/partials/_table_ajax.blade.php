<table class="table table-bordered table-striped" style="font-size:14px">
    <thead style="background:#1B6B5A;color:white">
        <tr>
            <th>Buku</th>
            <th>Anggota</th>
            <th>Tgl Pinjam</th>
            <th>Batas Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transaksis as $item)
            @php $terlambat = $item->status === 'dipinjam' && $item->tanggal_kembali_rencana < today(); @endphp
            <tr class="{{ $terlambat ? 'table-danger' : '' }}">
                <td>{{ $item->buku->judul ?? '-' }}</td>
                <td>{{ $item->anggota->nama ?? '-' }}</td>
                <td>{{ $item->tanggal_pinjam?->format('d/m/Y') }}</td>
                <td>{{ $item->tanggal_kembali_rencana?->format('d/m/Y') }}</td>
                <td>
                    @if($terlambat)
                        <span class="badge bg-danger">Terlambat</span>
                    @elseif($item->status === 'dipinjam')
                        <span class="badge bg-warning text-dark">Dipinjam</span>
                    @else
                        <span class="badge bg-success">Dikembalikan</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-sm btn-secondary btn-detail-ajax" data-id="{{ $item->id }}">Detail</button>
                    @if($item->status === 'dipinjam')
                        <button class="btn btn-sm btn-success btn-kembali-ajax" data-id="{{ $item->id }}">Kembalikan</button>
                    @endif
                    @if(auth()->user()->role === 'admin')
                        <button class="btn btn-sm btn-danger btn-delete-ajax" data-id="{{ $item->id }}">Hapus</button>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted py-3">Tidak ada data transaksi.</td>
            </tr>
        @endforelse
    </tbody>
</table>
<div style="margin-top:12px">
    {{ $transaksis->links('pagination::bootstrap-5') }}
</div>