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
        return $this->hasOne(Mahasiswa::class, 'id', 'mahasiswa_id');
    }
}
