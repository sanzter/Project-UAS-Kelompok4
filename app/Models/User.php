<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'kelas_id', // ← Tambahan baru agar siswa bisa masuk kelas
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // -------------------------------------------------------
    // Ubah kolom login dari 'email' ke 'username'
    // -------------------------------------------------------
    public function getAuthIdentifierName(): string
    {
        return 'username'; // Laravel pakai kolom ini untuk Auth::attempt()
    }

    // -------------------------------------------------------
    // Role Helpers
    // -------------------------------------------------------

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }
    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    public function roleName(): string
    {
        return match ($this->role) {
            'admin' => 'Administrator',
            'guru'  => 'Guru',
            'siswa' => 'Siswa',
            default => 'Pengguna',
        };
    }

    public function dashboardRoute(): string
    {
        return match ($this->role) {
            'admin' => route('admin.dashboard'),
            'guru'  => route('guru.dashboard'),
            'siswa' => route('siswa.dashboard'),
            default => route('login'),
        };
    }

    // -------------------------------------------------------
    // Relasi Database
    // -------------------------------------------------------

    // Untuk Guru: Guru mengajar kelas apa saja?
    public function kelasDiampu()
    {
        return $this->hasMany(Kelas::class, 'guru_id');
    }

    // Untuk Siswa: Siswa ini berada di kelas mana? (Tambahan Baru)
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}