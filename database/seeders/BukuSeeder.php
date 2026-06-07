<?php
namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode_buku' => 'BK-001', 'judul' => 'Pemrograman Laravel', 'pengarang' => 'Ahmad Zaki', 'penerbit' => 'Gramedia', 'tahun_terbit' => 2023, 'kategori' => 'Teknologi', 'stok_total' => 5, 'stok_tersedia' => 5],
            ['kode_buku' => 'BK-002', 'judul' => 'Basis Data Modern', 'pengarang' => 'Siti Rahayu', 'penerbit' => 'Erlangga', 'tahun_terbit' => 2022, 'kategori' => 'Teknologi', 'stok_total' => 3, 'stok_tersedia' => 3],
            ['kode_buku' => 'BK-003', 'judul' => 'Algoritma & Pemrograman', 'pengarang' => 'Budi Santoso', 'penerbit' => 'Andi', 'tahun_terbit' => 2021, 'kategori' => 'Teknologi', 'stok_total' => 4, 'stok_tersedia' => 4],
            ['kode_buku' => 'BK-004', 'judul' => 'Matematika Diskrit', 'pengarang' => 'Dr. Hartono', 'penerbit' => 'UI Press', 'tahun_terbit' => 2020, 'kategori' => 'Matematika', 'stok_total' => 6, 'stok_tersedia' => 6],
            ['kode_buku' => 'BK-005', 'judul' => 'Jaringan Komputer', 'pengarang' => 'Rina Wijaya', 'penerbit' => 'Gramedia', 'tahun_terbit' => 2023, 'kategori' => 'Teknologi', 'stok_total' => 2, 'stok_tersedia' => 2],
        ];
        foreach ($data as $item) {
            Buku::updateOrCreate(['kode_buku' => $item['kode_buku']], $item);
        }
    }
}