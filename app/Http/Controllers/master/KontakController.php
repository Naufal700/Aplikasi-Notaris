<?php

namespace App\Http\Controllers\master;

use App\Models\Master\Klien;
use Illuminate\Http\Request;
use App\Models\Master\Kontak;
use App\Http\Controllers\Controller;
use Exception;

class KontakController extends Controller
{
    // Menampilkan daftar kontak dengan pagination & search
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kontak = Kontak::with('klien')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('perusahaan', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString(); // biar query search ikut pagination

        // 🔥 ambil semua klien untuk dropdown modal create/edit
        $klien = Klien::orderBy('nama')->get(['id', 'nama']);

        return view('master-data.kontak.index', compact('kontak', 'klien', 'search'));
    }

    // Simpan kontak baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'perusahaan' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:100',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'klien_id' => 'nullable|exists:klien,id',
        ]);

        try {
            Kontak::create($request->all());
            return redirect()->route('kontak.index')->with('success', 'Kontak berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->route('kontak.index')->with('error', 'Gagal menambahkan kontak.');
        }
    }

    // Update kontak
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'perusahaan' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:100',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'klien_id' => 'nullable|exists:klien,id',
        ]);

        try {
            $kontak = Kontak::findOrFail($id);
            $kontak->update($request->all());

            return redirect()->route('kontak.index')->with('success', 'Kontak berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->route('kontak.index')->with('error', 'Gagal memperbarui kontak.');
        }
    }

    // Hapus kontak
    public function destroy($id)
    {
        try {
            $kontak = Kontak::findOrFail($id);
            $kontak->delete();

            return redirect()->route('kontak.index')->with('success', 'Kontak berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('kontak.index')->with('error', 'Gagal menghapus kontak.');
        }
    }
}
