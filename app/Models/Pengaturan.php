<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $guarded = [
        'id',
    ];

    public function getSemester()
    {
        if ($this->semester == 'ganjil') {
            return 'Ganjil';
        } else {
            return 'Genap';
        }
    }

    public function batasPengajuan()
    {
        // Set Locale
        setlocale(LC_TIME, 'id_ID');
        if ($this->batas_pengajuan == null) {
            return 'Belum diatur';
        } else {
            return strftime('%d %B %Y', strtotime($this->batas_pengajuan));
        }
    }
}
