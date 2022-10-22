<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelArchivable\Archivable;

class Berkas extends Model
{
    use Archivable;

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
