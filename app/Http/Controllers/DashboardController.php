<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $grades = Grade::all();
        $totalSiswa     = $grades->count();
        $rataRata       = $totalSiswa > 0 ? round($grades->avg('nilai'), 1) : 0;
        $nilaiTertinggi = $totalSiswa > 0 ? $grades->max('nilai') : 0;

        return view('dashboard.home', compact('totalSiswa', 'rataRata', 'nilaiTertinggi'));
    }

    public function analitik()
    {
        $grades     = Grade::all();
        $gradesData = $grades->toArray();
        $distribusi = $grades->groupBy('mata_pelajaran')->map->count();
        $topSubject     = $distribusi->isNotEmpty() ? $distribusi->sortDesc()->keys()->first() : '-';
        $totalGrades    = $grades->count();
        $avg            = $totalGrades > 0 ? $grades->avg('nilai') : 0;
        $statusAkademik = $avg >= 75 ? 'Performa Sangat Baik' : 'Perlu Peningkatan';

        return view('dashboard.analitik', compact(
            'gradesData', 'distribusi', 'topSubject', 'totalGrades', 'statusAkademik'
        ));
    }

    public function kelas()
    {
        $subjectNames = ["Mathematics", "Physic", "Calculus", "Science", "History", "English", "Biology"];
        $subjects = collect($subjectNames)->map(function ($name) {
            $prefix = strtoupper(substr($name, 0, 1));
            $rooms = [];
            for ($i = 1; $i <= 5; $i++) {
                $rooms[] = ['code' => "{$prefix}0{$i}", 'floor' => rand(1, 5), 'students' => rand(10, 30)];
            }
            return ['name' => $name, 'rooms' => $rooms];
        });

        return view('dashboard.kelas', compact('subjects'));
    }
}