<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    // Mengizinkan kolom ini diisi secara massal
    protected $fillable = [
        'kelas_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'mata_pelajaran',

    ];

    // Relasi: Jadwal ini milik Kelas apa?
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}