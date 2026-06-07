<?php
namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class PeminjamanExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithTitle
{
    public function __construct(private array $filters = [])
    {
    }

    public function query()
    {
        return Transaksi::with(['buku', 'anggota'])
            ->when($this->filters['status'] ?? null, fn($q, $s) => $q->where('status', $s))
            ->when($this->filters['buku_id'] ?? null, fn($q, $id) => $q->where('buku_id', $id))
            ->when($this->filters['anggota_id'] ?? null, fn($q, $id) => $q->where('anggota_id', $id))
            ->when($this->filters['tanggal_mulai'] ?? null, fn($q, $d) => $q->whereDate('tanggal_pinjam', '>=', $d))
            ->when($this->filters['tanggal_selesai'] ?? null, fn($q, $d) => $q->whereDate('tanggal_pinjam', '<=', $d))
            ->orderByDesc('tanggal_pinjam');
    }

    public function headings(): array
    {
        return ['No', 'Judul Buku', 'Nama Anggota', 'No. Anggota', 'Tgl Pinjam', 'Tgl Kembali Rencana', 'Tgl Kembali Aktual', 'Status'];
    }

    public function map($t): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $t->buku->judul ?? '-',
            $t->anggota->nama ?? '-',
            $t->anggota->nomor_anggota ?? '-',
            $t->tanggal_pinjam?->format('d-m-Y') ?? '-',
            $t->tanggal_kembali_rencana?->format('d-m-Y') ?? '-',
            $t->tanggal_kembali_aktual?->format('d-m-Y') ?? '-',
            $t->status,
        ];
    }

    public function title(): string
    {
        return 'Laporan Peminjaman';
    }
}