<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelArchivable\Archivable;

class Skor extends Model
{
    use HasFactory, Archivable;

    protected $guarded = [
        'id',
    ];

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'id', 'mahasiswa_id');
    }

    public function mahasiswaArchived()
    {
        return $this->hasOne(Mahasiswa::class, 'id', 'mahasiswa_id')->onlyArchived();
    }
}
