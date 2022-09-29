<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subkriteria extends Model
{
    protected $table = 'subkriteria';
    protected $guarded = [];
    public $timestamps = false;

    public function kriteria()
    {
        return $this->hasOne(Kriteria::class, 'id', 'kriteria_id');
    }
}
