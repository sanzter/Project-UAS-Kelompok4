<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // -------------------------------------------------------
    // Dashboard Admin
    // -------------------------------------------------------
    public function dashboard()
    {
        $totalKelas = Kelas::distinct()->count('nama_kelas');

        return view('admin.dashboard', [
            'totalUser'   => User::query()->count(),
            'totalGuru'   => User::query()->where('role', 'guru')->count(),
            'totalSiswa'  => User::query()->where('role', 'siswa')->count(),
            'rataRata'    => round(Grade::query()->avg('nilai') ?? 0, 1),
            'totalNilai'  => Grade::query()->count(),
            'totalKelas'  => $totalKelas,
            'totalMapel'  => $totalMapel = Kelas::query()->distinct('mata_pelajaran')->count('mata_pelajaran'),
            'siswaRendah' => Grade::query()->where('nilai', '<', 75)->count(),
            'userTerbaru' => User::query()->latest()->take(5)->get(),
        ]);
    }

    // -------------------------------------------------------
    // Kelola User
    // -------------------------------------------------------
    public function kelolaUser()
    {
        $users = User::query()->when(
            request('role'),
            fn($q) => $q->where('role', request('role'))
        )
            ->latest()
            ->paginate(15);

        return view('admin.kelola-user', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:admin,guru,siswa']);

        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'Tidak bisa mengubah role akun sendiri.']);
        }

        $user->update(['role' => $request->role]);
        return back()->with('success', "Role {$user->name} berhasil diubah.");
    }

    public function deleteUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'Tidak bisa menghapus akun sendiri.']);
        }

        $name = $user->name;
        $user->delete();
        return back()->with('success', "Akun \"{$name}\" berhasil dihapus.");
    }

    // -------------------------------------------------------
    // Tambah Akun Guru (hanya Admin yang bisa)
    // -------------------------------------------------------
    public function tambahGuru()
    {
        return view('admin.tambah-guru');
    }

    public function storeGuru(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'unique:users,username',
                'regex:/^[a-zA-Z0-9._]+$/',
            ],
            'password' => 'required|string|min:8',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.min'      => 'Username minimal 3 karakter.',
            'username.unique'   => 'Username sudah digunakan.',
            'username.regex'    => 'Username hanya boleh huruf, angka, titik, dan underscore.',
            'password.min'      => 'Password minimal 8 karakter.',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => strtolower($request->username),
            'password' => bcrypt($request->password),
            'role'     => 'guru', // hardcoded, tidak bisa dimanipulasi
        ]);

        return redirect()
            ->route('admin.kelola-user')
            ->with('success', "Akun guru \"{$request->name}\" berhasil dibuat.");
    }

    // -------------------------------------------------------
    // Analitik
    // -------------------------------------------------------
    public function analitik()
    {
        $gradesData  = Grade::query()->select('nama_siswa', 'nilai')->latest()->take(20)->get();
        $distribusi = Grade::query()
            ->select('mata_pelajaran', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('mata_pelajaran')
            ->pluck('total', 'mata_pelajaran');
        $topSubject = $distribusi->count() > 0 ? $distribusi->keys()->first() : '-';
        $totalGrades = Grade::query()->count();

        return view('admin.analitik', compact(
            'gradesData',
            'distribusi',
            'topSubject',
            'totalGrades'
        ));
    }

    // -------------------------------------------------------
    // Semua Nilai
    // -------------------------------------------------------
    public function nilai()
    {
        $grades = Grade::query()->latest()->paginate(20);
        return view('admin.nilai', compact('grades'));
    }

    // -------------------------------------------------------
    // Kelas
    // -------------------------------------------------------


    public function kelas()
    {
        // Tambahkan 'jadwal' di dalam with()
        $kelasList = Kelas::with(['guru', 'jadwal'])->latest()->get();
        $gurus = User::query()->where('role', 'guru')->orderBy('name')->get();

        return view('admin.kelas', compact('kelasList', 'gurus'));
    }

    public function storeKelas(Request $request)
    {
        $request->validate([
            'nama_kelas'     => 'required|string|max:255',
            'guru_id'        => 'required|exists:users,id',
            'mata_pelajaran' => 'required|string|max:255',
            'hari'           => 'required|string',
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required|after:jam_mulai',
        ]);

        // 1. Simpan ke tabel Kelas
        $kelas = Kelas::create([
            'nama_kelas'     => $request->nama_kelas,
            'guru_id'        => $request->guru_id,
            'mata_pelajaran' => $request->mata_pelajaran,
        ]);

        // 2. Simpan ke tabel Jadwals menggunakan ID kelas yang baru dibuat
        \App\Models\Jadwal::create([
            'kelas_id'    => $kelas->id,
            'hari'        => $request->hari,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'mata_pelajaran' => $request->mata_pelajaran,
        ]);

        return back()->with('success', 'Data kelas dan jadwal berhasil ditambahkan!');
    }

    // -------------------------------------------------------
    // Reset Kelas Siswa
    // -------------------------------------------------------
    public function resetKelasSiswa($id)
    {
        $siswa = \App\Models\User::findOrFail($id);

        // Pastikan yang direset benar-benar role siswa
        if ($siswa->role === 'siswa') {
            // Kosongkan kelasnya
            $siswa->kelas_id = null;
            $siswa->status_keluar = false; // Kembalikan ke false setelah reset
            $siswa->save();

            return back()->with('success', "Kelas untuk siswa {$siswa->name} berhasil direset. Siswa akan diminta memilih kelas baru saat login.");
        }

        return back()->with('error', 'Hanya akun siswa yang dapat direset kelasnya.');
    }

    // -------------------------------------------------------
    // Halaman Kelola Siswa
    // -------------------------------------------------------
    public function kelolaSiswa()
    {
        // Mengambil semua user yang memiliki role 'siswa', beserta data kelasnya
        $siswas = \App\Models\User::where('role', 'siswa')->with('kelas')->latest()->get();

        return view('admin.kelola-siswa', compact('siswas'));
    }

    public function destroyKelas($id)
    {
        $kelas = Kelas::findOrFail($id);

        // Simpan nama kelas untuk notifikasi
        $nama_kelas = $kelas->nama_kelas;

        $kelas->delete();

        return back()->with('success', "Kelas {$nama_kelas} berhasil dihapus!");
    }
}
