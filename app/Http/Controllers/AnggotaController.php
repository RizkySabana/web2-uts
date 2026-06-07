<?php
namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = Anggota::latest();
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($d) use ($q) {
                $d->where('nama', 'like', "%$q%")
                    ->orWhere('nomor_anggota', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%");
            });
        }
        return view('anggota.index', [
            'anggota' => $query->paginate(10)->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_anggota' => 'required|string|max:20|unique:anggotas',
            'nama' => 'required|string|max:150',
            'email' => 'nullable|email|max:150',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tanggal_daftar' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
        ]);
        Anggota::create($data);
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->load('transaksis.buku');
        return view('anggota.show', compact('anggota'));
    }

    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);
        $data = $request->validate([
            'nomor_anggota' => 'required|string|max:20|unique:anggotas,nomor_anggota,' . $anggota->id,
            'nama' => 'required|string|max:150',
            'email' => 'nullable|email|max:150',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tanggal_daftar' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
        ]);
        $anggota->update($data);
        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }
}