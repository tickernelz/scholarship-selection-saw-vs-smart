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
}
