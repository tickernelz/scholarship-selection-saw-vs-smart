<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use NumberFormatter;

class Mahasiswa extends Model
{
    protected $guarded = [
        'id',
    ];

    public function ukt()
    {
        $fmt = numfmt_create( 'id_ID', NumberFormatter::CURRENCY );
        return numfmt_format_currency($fmt, $this->ukt, "IDR");
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function beasiswa()
    {
        return $this->hasMany(Beasiswa::class, 'mahasiswa_id', 'id');
    }

    public function berkas()
    {
        return $this->hasMany(Berkas::class, 'mahasiswa_id', 'id');
    }

    public function skor()
    {
        return $this->hasOne(Skor::class, 'mahasiswa_id', 'id');
    }
}
