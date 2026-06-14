<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = ['nama_kelas', 'guru_id', 'mata_pelajaran'];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
