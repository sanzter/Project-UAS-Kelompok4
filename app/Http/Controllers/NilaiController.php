<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $grades = Grade::latest()->get();
        return view('dashboard.list', compact('grades'));
    }

    public function create()
    {
        return view('dashboard.nilai');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa'     => 'required|string|max:255',
            'mata_pelajaran' => 'required|string',
            'nilai'          => 'required|integer|min:0|max:100',
        ]);

        Grade::create([
            'nama_siswa'     => $request->nama_siswa,
            'mata_pelajaran' => $request->mata_pelajaran,
            'nilai'          => $request->nilai,
        ]);

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Grade::findOrFail($id)->delete();
        return redirect()->route('nilai.index')->with('success', 'Data berhasil dihapus!');
    }
}