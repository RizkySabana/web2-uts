<?php
namespace App\Interfaces;

interface PeminjamanInterface
{
    public function pinjamBuku(int $bukuId, int $anggotaId): bool;
    public function kembalikanBuku(int $transaksiId): bool;
    public function cekKetersediaan(int $bukuId): bool;
}