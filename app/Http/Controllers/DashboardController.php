<?php
namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAnggota()) {
            return $this->dashboardAnggota($user);
        }

        return $this->dashboardAdmin();
    }

    private function dashboardAdmin()
    {
        $totalBuku = Buku::count();
        $totalAnggota = Anggota::count();
        $totalDipinjam = Transaksi::where('status', 'dipinjam')->count();
        $totalDikembalikan = Transaksi::where('status', 'dikembalikan')->count();
        $terlambat = Transaksi::where('status', 'dipinjam')
            ->whereDate('tanggal_kembali_rencana', '<', today())->count();

        $bulanLabels = [];
        $bulanValues = [];
        for ($i = 11; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $bulanLabels[] = $bulan->format('M Y');
            $bulanValues[] = Transaksi::whereYear('tanggal_pinjam', $bulan->year)
                ->whereMonth('tanggal_pinjam', $bulan->month)->count();
        }

        $statusLabels = ['Dipinjam', 'Dikembalikan'];
        $statusValues = [$totalDipinjam, $totalDikembalikan];
        $popularBuku = Buku::withCount('transaksis')->orderByDesc('transaksis_count')->take(5)->get();

        return view('dashboard.index', compact(
            'totalBuku',
            'totalAnggota',
            'totalDipinjam',
            'totalDikembalikan',
            'terlambat',
            'bulanLabels',
            'bulanValues',
            'statusLabels',
            'statusValues',
            'popularBuku'
        ));
    }

    private function dashboardAnggota($user)
    {
        $anggotaId = $user->anggota_id;
        $totalPinjam = Transaksi::where('anggota_id', $anggotaId)->count();
        $sedangDipinjam = Transaksi::where('anggota_id', $anggotaId)->where('status', 'dipinjam')->count();
        $sudahKembali = Transaksi::where('anggota_id', $anggotaId)->where('status', 'dikembalikan')->count();
        $terlambat = Transaksi::where('anggota_id', $anggotaId)
            ->where('status', 'dipinjam')
            ->whereDate('tanggal_kembali_rencana', '<', today())->count();

        $riwayat = Transaksi::with('buku')
            ->where('anggota_id', $anggotaId)
            ->latest()->take(5)->get();

        $anggota = $user->anggota;

        return view('dashboard.anggota', compact(
            'totalPinjam',
            'sedangDipinjam',
            'sudahKembali',
            'terlambat',
            'riwayat',
            'anggota'
        ));
    }
}