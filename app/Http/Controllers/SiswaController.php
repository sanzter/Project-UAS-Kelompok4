<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    // -------------------------------------------------------
    // Dashboard Siswa
    // -------------------------------------------------------
    public function dashboard()
    {
        $siswa  = Auth::user();
        $grades = Grade::where('nama_siswa', $siswa->name)->get();

        return view('siswa.dashboard', [
            'namaKelas'      => 'X IPA 1', // sesuaikan jika ada relasi kelas
            'rataRata'       => $grades->isNotEmpty() ? round($grades->avg('nilai'), 1) : null,
            'nilaiTertinggi' => $grades->isNotEmpty() ? $grades->max('nilai') : null,
            'nilaiMinimum'   => $grades->isNotEmpty() ? $grades->min('nilai') : null,
            'totalMapel'     => $grades->unique('mata_pelajaran')->count(),
            'nilaiPerMapel'  => $grades,
        ]);
    }

    // -------------------------------------------------------
    // Nilai Saya
    // -------------------------------------------------------
    public function nilaiSaya()
    {
        $siswa  = Auth::user();
        $grades = Grade::where('nama_siswa', $siswa->name)->latest()->get();

        return view('siswa.nilai-saya', [
            'grades'         => $grades,
            'rataRata'       => $grades->isNotEmpty() ? round($grades->avg('nilai'), 1) : null,
            'nilaiTertinggi' => $grades->isNotEmpty() ? $grades->max('nilai') : null,
            'nilaiTerendah'  => $grades->isNotEmpty() ? $grades->min('nilai') : null,
        ]);
    }

    // -------------------------------------------------------
    // Jadwal
    // -------------------------------------------------------
    public function jadwal()
    {
        return view('siswa.jadwal');
    }

    // -------------------------------------------------------
    // Kelas
    // -------------------------------------------------------
    public function kelas()
    {
        return view('siswa.kelas');
    }
}
