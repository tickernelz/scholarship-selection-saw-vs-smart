<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    protected $guarded = [
        'id',
    ];

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function beasiswas()
    {
        return $this->hasMany(Beasiswa::class);
    }

    public function berkas()
    {
        return $this->hasMany(Berkas::class);
    }

    public function skors()
    {
        return $this->hasMany(Skor::class);
    }
}
