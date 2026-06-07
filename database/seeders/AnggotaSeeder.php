<?php
namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Seeder;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nomor_anggota' => 'ANG-001', 'nama' => 'Budi Pratama', 'email' => 'budi@email.com', 'telepon' => '081234567890', 'tanggal_daftar' => '2024-01-10', 'status' => 'aktif'],
            ['nomor_anggota' => 'ANG-002', 'nama' => 'Siti Aminah', 'email' => 'siti@email.com', 'telepon' => '082345678901', 'tanggal_daftar' => '2024-02-15', 'status' => 'aktif'],
            ['nomor_anggota' => 'ANG-003', 'nama' => 'Rizky Maulana', 'email' => 'rizky@email.com', 'telepon' => '083456789012', 'tanggal_daftar' => '2024-03-20', 'status' => 'aktif'],
            ['nomor_anggota' => 'ANG-004', 'nama' => 'Dewi Sartika', 'email' => 'dewi@email.com', 'telepon' => '084567890123', 'tanggal_daftar' => '2024-04-05', 'status' => 'aktif'],
        ];
        foreach ($data as $item) {
            Anggota::updateOrCreate(['nomor_anggota' => $item['nomor_anggota']], $item);
        }
    }
}