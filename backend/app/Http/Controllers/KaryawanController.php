<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
     // Menampilkan semua karyawan
    public function index()
    {
        $karyawans = Karyawan::with(['unit', 'jabatan'])->get();
        return response()->json($karyawans);
    }

    // Menyimpan data karyawan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:karyawans,nip',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'npwp' => 'nullable|string',
            'agama' => 'nullable|string',
            'jenis_kelamin' => 'required|in:L,P',
            'unit_id' => 'required|exists:units,id',
            'jabatan_id' => 'required|exists:jabatans,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_karyawan', 'public');
            $validated['foto'] = $path;
        }

        $karyawan = Karyawan::create($validated);
        return response()->json($karyawan, 201);
    }

    // Menampilkan detail karyawan
    public function show($id)
    {
        $karyawan = Karyawan::with(['unit', 'jabatan'])->findOrFail($id);
        return response()->json($karyawan);
    }

    // Update data karyawan
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'npwp' => 'nullable|string',
            'agama' => 'nullable|string',
            'jenis_kelamin' => 'required|in:L,P',
            'unit_id' => 'required|exists:units,id',
            'jabatan_id' => 'required|exists:jabatans,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_karyawan', 'public');
            $validated['foto'] = $path;
        }

        $karyawan->update($validated);
        return response()->json($karyawan);
    }

    // Hapus karyawan
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return response()->json(['message' => 'Karyawan berhasil dihapus']);
    }
}
