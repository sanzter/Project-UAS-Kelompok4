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
        $grades = Grade::query()->where('nama_siswa', $siswa->name)->get();

        // Mengelompokkan nilai berdasarkan mata_pelajaran dan mencari rata-ratanya
        $nilaiPerMapelGrouped = $grades->groupBy('mata_pelajaran')->map(function ($mapelGroup) {
            return (object) [
                'mata_pelajaran' => $mapelGroup->first()->mata_pelajaran,
                'nilai'          => round($mapelGroup->avg('nilai'), 1), // Rata-rata nilai per mapel
            ];
        })->values(); // Reset array keys

        return view('siswa.dashboard', [
            'namaKelas'      => $siswa->kelas->nama_kelas ?? 'Belum memilih kelas', // sesuaikan jika ada relasi kelas
            'rataRata'       => $grades->isNotEmpty() ? round($grades->avg('nilai'), 1) : null,
            'nilaiTertinggi' => $grades->isNotEmpty() ? $grades->max('nilai') : null,
            'nilaiMinimum'   => $grades->isNotEmpty() ? $grades->min('nilai') : null,
            'totalMapel'     => $nilaiPerMapelGrouped->count(),
            'nilaiPerMapel'  => $nilaiPerMapelGrouped, // Gunakan data yang sudah dikelompokkan
        ]);
    }

    // -------------------------------------------------------
    // Nilai Saya
    // -------------------------------------------------------
    public function nilaiSaya()
    {
        $siswa  = Auth::user();
        $grades = Grade::query()->where('nama_siswa', $siswa->name)->latest()->get();

        return view('siswa.nilai-saya', [
            'grades'         => $grades,
            'rataRata'       => $grades->isNotEmpty() ? round($grades->avg('nilai'), 1) : null,
            'nilaiTertinggi' => $grades->isNotEmpty() ? $grades->max('nilai') : null,
            'nilaiTerendah'  => $grades->isNotEmpty() ? $grades->min('nilai') : null,
        ]);
    }

    // -------------------------------------------------------
    // Kelas
    // -------------------------------------------------------
    public function kelas()
    {
        $user = auth()->user();

        // Jika siswa belum masuk kelas, arahkan ke pilih kelas
        if (!$user->kelas_id) {
            return redirect()->route('siswa.pilih-kelas');
        }

        // Ambil data kelas beserta guru pengampu dan daftar siswa di kelas tersebut
        $kelas = \App\Models\Kelas::with(['guru', 'siswa'])->findOrFail($user->kelas_id);

        return view('siswa.kelas', compact('kelas'));
    }

    // -------------------------------------------------------
    // Pemilihan Kelas oleh Siswa
    // -------------------------------------------------------
    public function pilihKelas()
    {
        $user = Auth::user();

        // Jika siswa sudah punya kelas, cegah mereka memilih lagi dan arahkan ke jadwal
        if ($user->kelas_id) {
            return redirect()->route('siswa.jadwal')->with('info', 'Anda sudah tergabung dalam kelas.');
        }

        // Ambil semua daftar kelas yang tersedia dari database
        $kelasList = \App\Models\Kelas::all();

        return view('siswa.pilih-kelas', compact('kelasList'));
    }

    public function simpanKelas(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id'
        ], [
            'kelas_id.required' => 'Anda harus memilih kelas terlebih dahulu.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak valid.'
        ]);

        $user = Auth::user();

        // Simpan pilihan kelas ke profil siswa
        $user->kelas_id = $request->kelas_id;
        $user->save();

        return redirect()->route('siswa.jadwal')->with('success', 'Selamat! Anda berhasil bergabung ke kelas.');
    }

    // -------------------------------------------------------
    // Jadwal Pelajaran Siswa
    // -------------------------------------------------------
    public function jadwal()
    {
        $user = Auth::user();

        // Jika siswa belum memilih kelas, paksa mereka ke halaman pemilihan kelas
        if (!$user->kelas_id) {
            return redirect()->route('siswa.pilih-kelas')->with('warning', 'Silakan pilih kelas terlebih dahulu untuk melihat jadwal Anda.');
        }

        // Ambil jadwal khusus untuk kelas yang dipilih siswa ini
        $jadwalsiswa = \App\Models\Jadwal::where('kelas_id', $user->kelas_id)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return view('siswa.jadwal', compact('jadwalsiswa'));
    }

    public function ajukanKeluar() 
    {
        // Ambil data user yang sedang login
        $user = auth()->user();
        
        // Ubah statusnya secara manual
        $user->status_keluar = true;
        
        // Simpan ke database
        $user->save();
        
        return back()->with('success', 'Permintaan keluar kelas telah dikirim ke Admin.');
    }
}
