<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beasiswa extends Model
{
    use HasFactory;

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
}
