<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Models\Master\TemplateDokumen;
use App\Models\Master\JenisAkta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateDokumenController extends Controller
{
    // Tampil daftar template dengan search & pagination
    public function index(Request $request)
    {
        $search = $request->get('search');
        $query = TemplateDokumen::with('jenisAkta');

        if ($search) {
            $query->where('nama_template', 'like', "%$search%");
        }

        $templateDokumen = $query->orderBy('id', 'desc')->paginate(10);
        return view('master-data.template-dokumen.index', compact('templateDokumen', 'search'));
    }

    // Simpan template baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:2048',
            'jenis_akta_id' => 'nullable|exists:jenis_akta,id',
        ]);

        $filePath = $request->file('file')->store('templates', 'public');

        TemplateDokumen::create([
            'nama_template' => $request->nama_template,
            'file_path' => $filePath,
            'jenis_akta_id' => $request->jenis_akta_id,
        ]);

        return redirect()->back()->with('success', 'Template berhasil ditambahkan!');
    }

    // Update template
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf|max:2048',
            'jenis_akta_id' => 'nullable|exists:jenis_akta,id',
        ]);

        $template = TemplateDokumen::findOrFail($id);

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($template->file_path && Storage::disk('public')->exists($template->file_path)) {
                Storage::disk('public')->delete($template->file_path);
            }
            $template->file_path = $request->file('file')->store('templates', 'public');
        }

        $template->nama_template = $request->nama_template;
        $template->jenis_akta_id = $request->jenis_akta_id;
        $template->save();

        return redirect()->back()->with('success', 'Template berhasil diperbarui!');
    }

    // Hapus template
    public function destroy($id)
    {
        $template = TemplateDokumen::findOrFail($id);
        if ($template->file_path && Storage::disk('public')->exists($template->file_path)) {
            Storage::disk('public')->delete($template->file_path);
        }
        $template->delete();

        return redirect()->back()->with('success', 'Template berhasil dihapus!');
    }
}
