<?php
namespace App\Http\Controllers;

use App\Exports\PeminjamanExport;
use App\Models\Transaksi;
use App\Models\Buku;
use App\Models\Anggota;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $this->validateFilter($request);
        $transaksis = $this->filteredQuery($request)->paginate(10)->appends($request->query());
        $summary = $this->summary($request);
        $bukus = Buku::orderBy('judul')->get();
        $anggota = Anggota::orderBy('nama')->get();
        return view('laporan.index', compact('transaksis', 'summary', 'bukus', 'anggota'));
    }

    public function pdf(Request $request)
    {
        $this->validateFilter($request);
        $transaksis = $this->filteredQuery($request)->get();
        $summary = $this->summary($request);
        $filters = $request->only(['keyword', 'status', 'buku_id', 'anggota_id', 'tanggal_mulai', 'tanggal_selesai']);
        $pdf = Pdf::loadView('laporan.pdf', compact('transaksis', 'summary', 'filters'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-peminjaman-' . now()->format('YmdHis') . '.pdf');
    }

    public function excel(Request $request)
    {
        $this->validateFilter($request);
        $filters = $request->only(['keyword', 'status', 'buku_id', 'anggota_id', 'tanggal_mulai', 'tanggal_selesai']);
        return Excel::download(new PeminjamanExport($filters), 'laporan-peminjaman-' . now()->format('YmdHis') . '.xlsx');
    }

    private function filteredQuery(Request $request)
    {
        return Transaksi::with(['buku', 'anggota'])
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->when($request->filled('buku_id'), fn($q) => $q->where('buku_id', $request->buku_id))
            ->when($request->filled('anggota_id'), fn($q) => $q->where('anggota_id', $request->anggota_id))
            ->when($request->filled('tanggal_mulai'), fn($q) => $q->whereDate('tanggal_pinjam', '>=', $request->tanggal_mulai))
            ->when($request->filled('tanggal_selesai'), fn($q) => $q->whereDate('tanggal_pinjam', '<=', $request->tanggal_selesai))
            ->when($request->filled('keyword'), function ($q) use ($request) {
                $kw = $request->keyword;
                $q->whereHas('buku', fn($b) => $b->where('judul', 'like', "%$kw%"))
                    ->orWhereHas('anggota', fn($a) => $a->where('nama', 'like', "%$kw%"));
            })
            ->orderByDesc('tanggal_pinjam');
    }

    private function summary(Request $request): array
    {
        $base = $this->filteredQuery($request);
        return [
            'total' => (clone $base)->count(),
            'dipinjam' => (clone $base)->where('status', 'dipinjam')->count(),
            'dikembalikan' => (clone $base)->where('status', 'dikembalikan')->count(),
            'terlambat' => (clone $base)->where('status', 'dipinjam')->whereDate('tanggal_kembali_rencana', '<', today())->count(),
        ];
    }

    private function validateFilter(Request $request): void
    {
        $request->validate([
            'keyword' => 'nullable|string|max:100',
            'status' => 'nullable|in:dipinjam,dikembalikan',
            'buku_id' => 'nullable|exists:bukus,id',
            'anggota_id' => 'nullable|exists:anggotas,id',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);
    }
}