<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku', 20)->unique();
            $table->string('judul', 200);
            $table->string('pengarang', 150);
            $table->string('penerbit', 150)->nullable();
            $table->year('tahun_terbit')->nullable();
            $table->string('kategori', 100);
            $table->unsignedInteger('stok_total')->default(1);
            $table->unsignedInteger('stok_tersedia')->default(1);
            $table->string('cover_path')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};