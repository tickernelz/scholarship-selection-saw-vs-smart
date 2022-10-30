<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelArchivable\Archivable;

class Beasiswa extends Model
{
    use HasFactory, Archivable;

    protected $guarded = [
        'id',
    ];

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class, 'id', 'mahasiswa_id');
    }

    public function kriterias()
    {
        return $this->hasMany(Kriteria::class, 'id', 'kriteria_id');
    }

    public function subkriteria()
    {
        return $this->hasOne(Subkriteria::class, 'id', 'subkriteria_id');
    }

    public function tahun_akademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'id', 'tahun_akademik_id');
    }
}
