<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Klien;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KlienTemplateExport;
use App\Imports\KlienImport;

class KlienController extends Controller
{
    public function index(Request $request)
    {
        $query = Klien::query(); // Mulai query baru

        // Filter search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('telepon', 'like', "%$search%");
            });
        }

        // Filter jenis klien
        if ($request->filled('jenis_klien')) {
            $query->where('jenis_klien', $request->jenis_klien);
        }

        // Urutkan berdasarkan nama
        $query->orderBy('nama');

        // Pagination 15 per halaman + query string tetap terbawa
        $klien = $query->paginate(15)->withQueryString();

        return view('master-data.klien.index', compact('klien'));
    }

    // Simpan klien baru (dari modal)
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|unique:klien,email',
            'telepon' => 'nullable|string|max:50',
        ]);

        Klien::create($request->all());

        return redirect()->route('klien.index')->with('success', 'Data klien berhasil ditambahkan.');
    }

    // Update data klien (dari modal)
    public function update(Request $request, $id)
    {
        $klien = Klien::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|unique:klien,email,' . $id,
            'telepon' => 'nullable|string|max:50',
        ]);

        $klien->update($request->all());

        return redirect()->route('klien.index')->with('success', 'Data klien berhasil diperbarui.');
    }

    // Hapus klien
    public function destroy($id)
    {
        $klien = Klien::findOrFail($id);
        $klien->delete();

        return redirect()->route('klien.index')->with('success', 'Data klien berhasil dihapus.');
    }

    // Download template Excel
    public function downloadTemplate()
    {
        return Excel::download(new KlienTemplateExport, 'template_klien.xlsx');
    }

    // Import data dari Excel
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new KlienImport, $request->file('file'));

        return redirect()->route('klien.index')->with('success', 'Data klien berhasil diimport.');
    }
}
