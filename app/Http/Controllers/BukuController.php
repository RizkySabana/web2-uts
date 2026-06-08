<?php
namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::latest();
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($d) use ($q) {
                $d->where('judul', 'like', "%$q%")
                    ->orWhere('pengarang', 'like', "%$q%")
                    ->orWhere('kode_buku', 'like', "%$q%");
            });
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');
        return view('buku.index', [
            'bukus' => $query->paginate(5)->withQueryString(),
            'kategoris' => $kategoris,
        ]);
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_buku' => 'required|string|max:20|unique:bukus',
            'judul' => 'required|string|max:200',
            'pengarang' => 'required|string|max:150',
            'penerbit' => 'nullable|string|max:150',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'kategori' => 'required|string|max:100',
            'stok_total' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'cover' => 'nullable|image|max:2048',
        ]);

        $data['stok_tersedia'] = $data['stok_total'];
        unset($data['cover']);

        if ($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('buku/cover', 'public');
        }

        Buku::create($data);
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Buku $buku)
    {
        $buku->load('transaksis.anggota');
        return view('buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $data = $request->validate([
            'kode_buku' => 'required|string|max:20|unique:bukus,kode_buku,' . $buku->id,
            'judul' => 'required|string|max:200',
            'pengarang' => 'required|string|max:150',
            'penerbit' => 'nullable|string|max:150',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'kategori' => 'required|string|max:100',
            'stok_total' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'cover' => 'nullable|image|max:2048',
        ]);

        $selisih = $data['stok_total'] - $buku->stok_total;
        $data['stok_tersedia'] = max(0, $buku->stok_tersedia + $selisih);
        unset($data['cover']);

        if ($request->hasFile('cover')) {
            if ($buku->cover_path)
                Storage::disk('public')->delete($buku->cover_path);
            $data['cover_path'] = $request->file('cover')->store('buku/cover', 'public');
        }

        $buku->update($data);
        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->cover_path)
            Storage::disk('public')->delete($buku->cover_path);
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}