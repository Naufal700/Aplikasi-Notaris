<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\JenisAkta;

class JenisAktaController extends Controller
{
    // Menampilkan daftar dengan search & pagination
    public function index(Request $request)
    {
        $search = $request->input('search');

        $jenisAkta = JenisAkta::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('master-data.jenis-akta.index', compact('jenisAkta', 'search'));
    }

    // Menampilkan form create
    public function create()
    {
        return view('jenis_akta.create');
    }

    // Simpan data
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        JenisAkta::create($request->all());

        return redirect()->route('jenis_akta.index')->with('success', 'Data berhasil ditambahkan.');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $jenisAkta = JenisAkta::findOrFail($id);
        return view('jenis_akta.edit', compact('jenisAkta'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $jenisAkta = JenisAkta::findOrFail($id);
        $jenisAkta->update($request->all());

        return redirect()->route('jenis_akta.index')->with('success', 'Data berhasil diupdate.');
    }

    // Hapus data
    public function destroy($id)
    {
        $jenisAkta = JenisAkta::findOrFail($id);
        $jenisAkta->delete();

        return redirect()->route('jenis_akta.index')->with('success', 'Data berhasil dihapus.');
    }
}
