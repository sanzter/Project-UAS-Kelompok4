<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    // -------------------------------------------------------
    // Dashboard Guru
    // -------------------------------------------------------
    public function dashboard()
    {
        $guru = Auth::user();

        return view('guru.dashboard', [
            'totalSiswa'   => User::query()->where('role', 'siswa')->count(),
            'totalKelas'   => $guru->kelasDiampu()->count(),
            'rataRata'     => round(Grade::query()->avg('nilai') ?? 0, 1),
            'dibawahKkm'   => Grade::query()->where('nilai', '<', 75)->count(),
            'nilaiTerbaru' => Grade::query()->latest()->take(5)->get(),
        ]);
    }

    // -------------------------------------------------------
    // Input Nilai
    // -------------------------------------------------------
    public function inputNilai()
    {
        // Ambil daftar nama siswa untuk dropdown
        $siswas = User::query()->where('role', 'siswa')->orderBy('name')->get();
        return view('guru.input-nilai', compact('siswas'));
    }

    public function storeNilai(Request $request)
    {
        $request->validate([
            'nama_siswa'     => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'nilai'          => 'required|integer|min:0|max:100',
        ], [
            'nama_siswa.required'     => 'Nama siswa wajib diisi.',
            'mata_pelajaran.required' => 'Mata pelajaran wajib dipilih.',
            'nilai.required'          => 'Nilai wajib diisi.',
            'nilai.min'               => 'Nilai minimal 0.',
            'nilai.max'               => 'Nilai maksimal 100.',
        ]);

        Grade::create($request->only('nama_siswa', 'mata_pelajaran', 'nilai'));

        return back()->with('success', 'Nilai berhasil disimpan.');
    }

    // -------------------------------------------------------
    // Daftar Nilai
    // -------------------------------------------------------
    public function daftarNilai()
    {
        $grades = Grade::query()->latest()->paginate(20);
        return view('guru.daftar-nilai', compact('grades'));
    }

    public function destroyNilai(Grade $grade)
    {
        $grade->delete();

        return back()->with('success', 'Data nilai berhasil dihapus.');
    }

    // -------------------------------------------------------
    // Kelas
    // -------------------------------------------------------
    public function kelas()
    {
        $kelasSaya = Auth::user()->kelasDiampu; // Ambil data dari relasi
        return view('guru.kelas', compact('kelasSaya'));
    }
}
