<?php
namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Buku;
use App\Models\Anggota;
use App\Services\PeminjamanService;
use Illuminate\Http\Request;

class TransaksiAjaxController extends Controller
{
    public function __construct(private PeminjamanService $service)
    {
    }

    public function index()
    {
        $transaksis = Transaksi::with(['buku', 'anggota'])->latest()->paginate(10);
        $transaksis->withPath(route('ajax.transaksi.data'));
        $bukus = Buku::where('stok_tersedia', '>', 0)->orderBy('judul')->get();
        $anggota = Anggota::where('status', 'aktif')->orderBy('nama')->get();
        return view('transaksi.ajax', compact('transaksis', 'bukus', 'anggota'));
    }

    public function data(Request $request)
    {
        $transaksis = Transaksi::with(['buku', 'anggota'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->keyword, function ($q) use ($request) {
                $q->whereHas('buku', fn($b) => $b->where('judul', 'like', '%' . $request->keyword . '%'))
                    ->orWhereHas('anggota', fn($a) => $a->where('nama', 'like', '%' . $request->keyword . '%'));
            })
            ->latest()
            ->paginate(10)
            ->withPath(route('ajax.transaksi.data'))
            ->appends($request->query());

        $html = view('transaksi.partials._table_ajax', compact('transaksis'))->render();
        return response()->json(['html' => $html, 'total' => $transaksis->total()]);
    }

    public function detail(Transaksi $transaksi)
    {
        $transaksi->load(['buku', 'anggota']);
        return response()->json([
            'id' => $transaksi->id,
            'judul_buku' => $transaksi->buku->judul ?? '-',
            'nama_anggota' => $transaksi->anggota->nama ?? '-',
            'nomor_anggota' => $transaksi->anggota->nomor_anggota ?? '-',
            'tanggal_pinjam' => $transaksi->tanggal_pinjam?->format('d-m-Y'),
            'tanggal_kembali_rencana' => $transaksi->tanggal_kembali_rencana?->format('d-m-Y'),
            'tanggal_kembali_aktual' => $transaksi->tanggal_kembali_aktual?->format('d-m-Y') ?? '-',
            'status' => $transaksi->status,
            'terlambat' => $transaksi->status === 'dipinjam' && $transaksi->tanggal_kembali_rencana < today(),
            // Tambahan cover buku
            'cover_url' => $transaksi->buku?->cover_path
                ? route('storage.file', $transaksi->buku->cover_path)
                : null,
            'pengarang' => $transaksi->buku->pengarang ?? '-',
            'kategori' => $transaksi->buku->kategori ?? '-',
        ]);
    }

    public function kembali(Transaksi $transaksi)
    {
        $berhasil = $this->service->kembalikanBuku($transaksi->id);
        if (!$berhasil)
            return response()->json(['message' => 'Gagal mengembalikan buku.'], 422);
        return response()->json(['message' => 'Buku berhasil dikembalikan.']);
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return response()->json(['message' => 'Data transaksi berhasil dihapus.']);
    }
}