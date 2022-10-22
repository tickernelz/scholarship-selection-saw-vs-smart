<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Berkas;
use App\Models\Kriteria;
use App\Models\Mahasiswa;
use App\Models\Skor;

class ArsipController extends Controller
{
    public function index_saw()
    {
        $judul = 'Arsip SAW';
        $data = Skor::with('mahasiswa')->onlyArchived()->get();
        $route_now = 'get.admin.arsip.beasiswa.saw';

        return view('admin.arsip.index', compact('judul', 'data', 'route_now'));
    }

    public function index_smart()
    {
        $judul = 'Arsip SMART';
        $data = Skor::with('mahasiswa')->onlyArchived()->get();
        $route_now = 'get.admin.arsip.beasiswa.smart';

        return view('admin.arsip.index', compact('judul', 'data', 'route_now'));
    }

    public function detail_saw($id)
    {
        $judul = 'Detail Perhitungan SAW';
        $beasiswa = Beasiswa::where('mahasiswa_id', $id)->onlyArchived()->get();
        $kriteria = Kriteria::all();
        $berkas = Berkas::where('mahasiswa_id', $id)->onlyArchived()->get();
        $mahasiswa = Mahasiswa::where('id', $id)->onlyArchived()->first();
        $skor = Skor::where('mahasiswa_id', $id)->onlyArchived()->first();
        $is_saw = true;
        $is_smart = false;

        return view('admin.arsip.detail', compact('beasiswa', 'kriteria', 'berkas', 'judul', 'mahasiswa', 'skor', 'is_saw', 'is_smart'));
    }

    public function detail_smart($id)
    {
        $judul = 'Detail Perhitungan SMART';
        $beasiswa = Beasiswa::where('mahasiswa_id', $id)->onlyArchived()->get();
        $kriteria = Kriteria::all();
        $berkas = Berkas::where('mahasiswa_id', $id)->onlyArchived()->get();
        $mahasiswa = Mahasiswa::where('id', $id)->onlyArchived()->first();
        $skor = Skor::where('mahasiswa_id', $id)->onlyArchived()->first();
        $is_saw = false;
        $is_smart = true;

        return view('admin.arsip.detail', compact('beasiswa', 'kriteria', 'berkas', 'judul', 'mahasiswa', 'skor', 'is_saw', 'is_smart'));
    }
}
