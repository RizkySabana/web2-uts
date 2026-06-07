<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Anggota;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(['email' => 'admin@perpus.test'], [
            'name' => 'Admin Perpustakaan',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'anggota_id' => null,
        ]);

        // Buat akun untuk setiap anggota yang ada
        $anggotas = Anggota::all();
        foreach ($anggotas as $anggota) {
            $email = strtolower(str_replace(' ', '.', $anggota->nama)) . '@perpus.test';
            User::updateOrCreate(['email' => $email], [
                'name' => $anggota->nama,
                'password' => Hash::make('password123'),
                'role' => 'anggota',
                'anggota_id' => $anggota->id,
            ]);
        }
    }
}