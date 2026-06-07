<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'buku_id',
        'anggota_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'tanggal_kembali_rencana' => 'date',
            'tanggal_kembali_aktual' => 'date',
        ];
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}