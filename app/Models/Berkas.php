<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    protected $guarded = [
        'id',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id', 'mahasiswa_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id', 'kriteria_id');
    }
}
