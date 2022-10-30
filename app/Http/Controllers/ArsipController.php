<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Berkas;
use App\Models\Kriteria;
use App\Models\Mahasiswa;
use App\Models\Skor;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    public function cari_saw()
    {
        $judul = 'Arsip SAW';
        $data = TahunAkademik::all();
        $route_now = 'get.admin.arsip.beasiswa.saw';

        return view('admin.arsip.cari', compact('judul', 'route_now', 'data'));
    }

    public function index_saw(Request $request)
    {
        $judul = 'Arsip SAW';
        $tahun_akademik = TahunAkademik::where('id', $request->tahun_akademik_id)->first();
        $data = Skor::with('mahasiswa')->where('tahun_akademik_id', $tahun_akademik->id)->onlyArchived()->get();
        $route_now = 'get.admin.arsip.beasiswa.saw';

        return view('admin.arsip.index', compact('judul', 'data', 'route_now'));
    }

    public function cari_smart()
    {
        $judul = 'Arsip SMART';
        $data = TahunAkademik::all();
        $route_now = 'get.admin.arsip.beasiswa.smart';

        return view('admin.arsip.cari', compact('judul', 'route_now', 'data'));
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
