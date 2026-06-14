<?php

namespace App\Http\Controllers;

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
        return view('admin.dashboard', [
            'totalUser'   => User::count(),
            'totalGuru'   => User::where('role', 'guru')->count(),
            'totalSiswa'  => User::where('role', 'siswa')->count(),
            'rataRata'    => round(Grade::avg('nilai') ?? 0, 1),
            'totalNilai'  => Grade::count(),
            'totalKelas'  => 12,
            'totalMapel'  => Grade::distinct('mata_pelajaran')->count('mata_pelajaran'),
            'siswaRendah' => Grade::where('nilai', '<', 75)->count(),
            'userTerbaru' => User::latest()->take(5)->get(),
        ]);
    }

    // -------------------------------------------------------
    // Kelola User
    // -------------------------------------------------------
    public function kelolaUser()
    {
        $users = User::when(
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
                'required', 'string', 'min:3', 'max:30',
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
        $gradesData  = Grade::select('nama_siswa', 'nilai')->latest()->take(20)->get();
        $distribusi  = Grade::selectRaw('mata_pelajaran, count(*) as total')
                            ->groupBy('mata_pelajaran')
                            ->pluck('total', 'mata_pelajaran');
        $topSubject  = $distribusi->isNotEmpty() ? $distribusi->keys()->first() : '-';
        $totalGrades = Grade::count();

        return view('admin.analitik', compact(
            'gradesData', 'distribusi', 'topSubject', 'totalGrades'
        ));
    }

    // -------------------------------------------------------
    // Semua Nilai
    // -------------------------------------------------------
    public function nilai()
    {
        $grades = Grade::latest()->paginate(20);
        return view('admin.nilai', compact('grades'));
    }

    // -------------------------------------------------------
    // Kelas
    // -------------------------------------------------------
    public function kelas()
    {
        return view('admin.kelas');
    }
}
