<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = ['nama_kelas', 'guru_id', 'mata_pelajaran', 'hari', 'jam_mulai', 'jam_selesai'];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    // Relasi: Kelas ini memiliki Siswa siapa saja?
    public function siswa()
    {
        // Hanya mengambil user yang role-nya 'siswa'
        return $this->hasMany(User::class, 'kelas_id')->where('role', 'siswa');
    }

    public function jadwal()
    {
        return $this->hasOne(Jadwal::class, 'kelas_id');
    }
}
