<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Kelas;
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
        // Mengambil daftar nama kelas secara unik (menghilangkan duplikat)
        $kelasList = \App\Models\Kelas::select('nama_kelas')->distinct()->get();
        
        return view('siswa.pilih-kelas', compact('kelasList'));
    }

    public function simpanKelas(\Illuminate\Http\Request $request)
    {
        // Validasi yang dicari sekarang adalah nama_kelas
        $request->validate([
            'nama_kelas' => 'required|string'
        ]);

        // Karena 1 kelas punya banyak mapel, kita ambil ID dari mapel pertama saja
        // sebagai 'perwakilan' bahwa siswa tersebut masuk di kelas itu.
        $kelasPerwakilan = Kelas::where('nama_kelas', $request->nama_kelas)->first();

        if ($kelasPerwakilan) {
            auth()->user()->update([
                'kelas_id' => $kelasPerwakilan->id
            ]);
            return redirect()->route('siswa.dashboard')->with('success', 'Kelas berhasil dipilih!');
        }

        return back()->with('error', 'Kelas tidak ditemukan.');
    }

    // -------------------------------------------------------
    // Jadwal Pelajaran Siswa
    // -------------------------------------------------------
    public function jadwal()
    {
        $user = auth()->user();

        // Jika belum pilih kelas, arahkan ke halaman pilih
        if (!$user->kelas_id) {
            return redirect()->route('siswa.pilih-kelas');
        }

        // Ambil nama kelas siswa saat ini (Misal: "XII MIPA 1")
        $namaKelasSiswa = $user->kelas->nama_kelas;

        // Ambil SEMUA jadwal yang ditujukan untuk kelas dengan nama tersebut
        $jadwalSiswa = \App\Models\Jadwal::whereHas('kelas', function($query) use ($namaKelasSiswa) {
            $query->where('nama_kelas', $namaKelasSiswa);
        })->with('kelas.guru')->get();

        return view('siswa.jadwal', compact('jadwalSiswa'));
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
