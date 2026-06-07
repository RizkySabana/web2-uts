<?php
namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Buku;
use App\Models\Anggota;
use App\Services\PeminjamanService;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function __construct(private PeminjamanService $service)
    {
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Transaksi::with(['buku', 'anggota'])->latest();

        // Jika anggota, hanya tampilkan transaksi milik sendiri
        if ($user->isAnggota()) {
            $query->where('anggota_id', $user->anggota_id);
        }

        if ($request->filled('status'))
            $query->where('status', $request->status);
        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('buku', fn($b) => $b->where('judul', 'like', "%$q%"));
        }

        return view('transaksi.index', [
            'transaksis' => $query->paginate(10)->withQueryString(),
        ]);
    }

    public function create()
    {
        $user = auth()->user();

        // Jika anggota, langsung set anggota_id ke dirinya sendiri
        if ($user->isAnggota()) {
            $anggota = Anggota::where('id', $user->anggota_id)->get();
        } else {
            $anggota = Anggota::where('status', 'aktif')->orderBy('nama')->get();
        }

        return view('transaksi.create', [
            'bukus' => Buku::where('stok_tersedia', '>', 0)->orderBy('judul')->get(),
            'anggota' => $anggota,
            'isAnggota' => $user->isAnggota(),
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'anggota_id' => 'required|exists:anggotas,id',
        ]);

        // Pastikan anggota hanya bisa pinjam untuk dirinya sendiri
        if ($user->isAnggota() && $request->anggota_id != $user->anggota_id) {
            abort(403, 'Anda hanya bisa meminjam untuk diri sendiri.');
        }

        $berhasil = $this->service->pinjamBuku($request->buku_id, $request->anggota_id);

        if (!$berhasil) {
            return back()->withErrors(['buku_id' => 'Stok buku tidak tersedia.']);
        }
        return redirect()->route('transaksi.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function show(Transaksi $transaksi)
    {
        $user = auth()->user();

        // Anggota hanya bisa lihat transaksi milik sendiri
        if ($user->isAnggota() && $transaksi->anggota_id !== $user->anggota_id) {
            abort(403);
        }

        $transaksi->load(['buku', 'anggota']);
        return view('transaksi.show', compact('transaksi'));
    }

    public function kembali(Transaksi $transaksi)
    {
        $berhasil = $this->service->kembalikanBuku($transaksi->id);
        if (!$berhasil)
            return back()->withErrors(['error' => 'Pengembalian gagal.']);
        return redirect()->route('transaksi.index')->with('success', 'Buku berhasil dikembalikan.');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Data transaksi dihapus.');
    }
}