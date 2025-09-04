<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Staf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StafController extends Controller
{
    // Tampil daftar staf dengan search & pagination
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = Staf::query();

        if ($search) {
            $query->where('nama', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        $staf = $query->orderBy('id', 'desc')->paginate(10);

        return view('master-data.staf.index', compact('staf', 'search'));
    }

    // Simpan staf baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:staf,email',
            'telepon' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'role' => 'required|in:admin,notaris,staff',
            'password' => 'required|string|min:6',
        ]);

        Staf::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'jabatan' => $request->jabatan,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Staf berhasil ditambahkan!');
    }

    // Update staf
    public function update(Request $request, $id)
    {
        $staf = Staf::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:staf,email,' . $staf->id,
            'telepon' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'role' => 'required|in:admin,notaris,staff',
            'password' => 'nullable|string|min:6',
        ]);

        $staf->nama = $request->nama;
        $staf->email = $request->email;
        $staf->telepon = $request->telepon;
        $staf->jabatan = $request->jabatan;
        $staf->role = $request->role;

        if ($request->password) {
            $staf->password = Hash::make($request->password);
        }

        $staf->save();

        return redirect()->back()->with('success', 'Staf berhasil diperbarui!');
    }

    // Hapus staf
    public function destroy($id)
    {
        $staf = Staf::findOrFail($id);
        $staf->delete();

        return redirect()->back()->with('success', 'Staf berhasil dihapus!');
    }
}
