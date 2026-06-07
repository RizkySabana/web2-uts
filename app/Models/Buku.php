<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_buku',
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'kategori',
        'stok_total',
        'stok_tersedia',
        'cover_path',
        'deskripsi',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}