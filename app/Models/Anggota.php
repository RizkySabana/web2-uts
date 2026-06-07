<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_anggota',
        'nama',
        'email',
        'telepon',
        'alamat',
        'tanggal_daftar',
        'status',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}