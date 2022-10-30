<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelArchivable\Archivable;
use NumberFormatter;

class Mahasiswa extends Model
{
    use Archivable;

    protected $guarded = [
        'id',
    ];

    public function ukt()
    {
        $fmt = numfmt_create('id_ID', NumberFormatter::CURRENCY);
        return numfmt_format_currency($fmt, $this->ukt, "IDR");
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function userArchived()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->onlyArchived();
    }

    public function beasiswa()
    {
        return $this->hasMany(Beasiswa::class, 'mahasiswa_id', 'id');
    }

    public function beasiswaArchived()
    {
        return $this->hasMany(Beasiswa::class, 'mahasiswa_id', 'id')->onlyArchived();
    }

    public function berkas()
    {
        return $this->hasMany(Berkas::class, 'mahasiswa_id', 'id');
    }

    public function berkasArchived()
    {
        return $this->hasMany(Berkas::class, 'mahasiswa_id', 'id')->onlyArchived();
    }

    public function skor()
    {
        return $this->hasOne(Skor::class, 'mahasiswa_id', 'id');
    }

    public function skorArchived()
    {
        return $this->hasOne(Skor::class, 'mahasiswa_id', 'id')->onlyArchived();
    }

    public function tahun_akademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'id', 'tahun_akademik_id');
    }
}
