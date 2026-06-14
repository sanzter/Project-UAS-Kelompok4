@extends('layouts.admin')
@section('page-title', 'Kelola User')
@section('admin-content')

<div class="card-admin overflow-hidden">
    <div class="p-8 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Manajemen User</h3>
            <p class="text-slate-400 text-sm mt-0.5">Kelola akun admin, guru, dan siswa</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Filter Role --}}
            <form method="GET" action="{{ route('admin.kelola-user') }}" class="flex items-center gap-2">
                <select name="role" onchange="this.form.submit()"
                    class="text-sm px-4 py-2 bg-slate-100 rounded-xl border-0 outline-none text-slate-700 font-medium">
                    <option value="">Semua Role</option>
                    <option value="admin"  {{ request('role') === 'admin'  ? 'selected' : '' }}>Admin</option>
                    <option value="guru"   {{ request('role') === 'guru'   ? 'selected' : '' }}>Guru</option>
                    <option value="siswa"  {{ request('role') === 'siswa'  ? 'selected' : '' }}>Siswa</option>
                </select>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="mx-8 mt-4 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-600 text-sm font-medium">
        {{ session('success') }}
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Nama</th>
                    <th class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Email</th>
                    <th class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Role</th>
                    <th class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Bergabung</th>
                    <th class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($users as $user)
                <tr class="hover:bg-violet-50/50 transition">
                    <td class="px-8 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 bg-gradient-to-br from-violet-400 to-purple-500 rounded-xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="font-medium text-slate-800">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-4 text-slate-500 text-sm">{{ $user->email }}</td>
                    <td class="px-8 py-4">
                        <span class="text-xs font-bold px-3 py-1 rounded-full
                            {{ $user->role === 'admin' ? 'bg-violet-100 text-violet-700' :
                              ($user->role === 'guru'  ? 'bg-emerald-100 text-emerald-700' :
                                                         'bg-cyan-100 text-cyan-700') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-8 py-4 text-slate-400 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-8 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            {{-- Ubah Role --}}
                            <form method="POST" action="{{ route('admin.update-role', $user->id) }}">
                                @csrf
                                @method('PATCH')
                                <select name="role" onchange="this.form.submit()"
                                    class="text-xs px-3 py-1.5 bg-slate-100 rounded-lg border-0 outline-none text-slate-700 font-medium cursor-pointer">
                                    <option value="admin"  {{ $user->role === 'admin'  ? 'selected' : '' }}>Admin</option>
                                    <option value="guru"   {{ $user->role === 'guru'   ? 'selected' : '' }}>Guru</option>
                                    <option value="siswa"  {{ $user->role === 'siswa'  ? 'selected' : '' }}>Siswa</option>
                                </select>
                            </form>
                            {{-- Hapus --}}
                            @if($user->id !== Auth::id())
                            <form method="POST" action="{{ route('admin.delete-user', $user->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Hapus user {{ $user->name }}?')"
                                    class="text-rose-400 hover:text-rose-600 transition p-1.5 rounded-lg hover:bg-rose-50">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-12 text-center text-slate-400">Belum ada data user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="px-8 py-5 border-t border-slate-100">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection