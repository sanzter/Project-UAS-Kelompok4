@extends('layouts.dashboard')
@section('page-title', 'Kelas')
@section('dashboard-content')
<div class="mb-8">
    <h3 class="text-2xl font-bold text-slate-800">Direktori Kelas</h3>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($subjects as $subject)
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
        <div class="flex items-center mb-4">
            <div class="w-10 h-10 rounded-lg bg-cyan-600 flex items-center justify-center text-white mr-3">
                <i class="fas fa-school"></i>
            </div>
            <h4 class="font-bold text-gray-800">{{ $subject['name'] }}</h4>
        </div>
        <div class="space-y-2">
            @foreach($subject['rooms'] as $room)
            <div class="p-3 bg-cyan-50 rounded-lg border border-cyan-100">
                <div class="flex justify-between items-center mb-1">
                    <span class="font-bold text-cyan-700">{{ $room['code'] }}</span>
                    <span class="text-xs font-medium bg-white px-2 py-0.5 rounded-full text-cyan-600 border border-cyan-100">
                        Lantai {{ $room['floor'] }}
                    </span>
                </div>
                <div class="flex items-center text-xs text-gray-500">
                    <i class="fas fa-user-friends mr-1.5 text-cyan-400"></i>
                    <span>{{ $room['students'] }} Siswa terdaftar</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>
@endsection