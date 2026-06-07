<?php
namespace App\Services;

use App\Interfaces\PeminjamanInterface;
use App\Models\Buku;
use App\Models\Transaksi;
use Carbon\Carbon;

class PeminjamanService implements PeminjamanInterface
{
    public function pinjamBuku(int $bukuId, int $anggotaId): bool
    {
        $buku = Buku::find($bukuId);
        if (!$buku || $buku->stok_tersedia <= 0)
            return false;

        Transaksi::create([
            'buku_id' => $bukuId,
            'anggota_id' => $anggotaId,
            'tanggal_pinjam' => Carbon::today(),
            'tanggal_kembali_rencana' => Carbon::today()->addDays(7),
            'status' => 'dipinjam',
        ]);

        $buku->decrement('stok_tersedia');
        return true;
    }

    public function kembalikanBuku(int $transaksiId): bool
    {
        $transaksi = Transaksi::find($transaksiId);
        if (!$transaksi || $transaksi->status === 'dikembalikan')
            return false;

        $transaksi->update([
            'tanggal_kembali_aktual' => Carbon::today(),
            'status' => 'dikembalikan',
        ]);

        $transaksi->buku->increment('stok_tersedia');
        return true;
    }

    public function cekKetersediaan(int $bukuId): bool
    {
        $buku = Buku::find($bukuId);
        return $buku && $buku->stok_tersedia > 0;
    }
}
