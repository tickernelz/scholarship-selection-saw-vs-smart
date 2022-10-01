<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Berkas;
use App\Models\Kriteria;
use App\Models\Mahasiswa;
use App\Models\Skor;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class BeasiswaController extends Controller
{
    public function index()
    {
        $judul = 'Daftar Beasiswa';
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $kriteria = Kriteria::all();
        $beasiswa = Beasiswa::where('mahasiswa_id', $mahasiswa->id)->get();
        $data_berkas = Berkas::where('mahasiswa_id', $mahasiswa->id)->get();
        if ($data_berkas == '[]') {
            $berkas = new Berkas();
            $berkas->mahasiswa_id = $mahasiswa->id;
            $berkas->save();
        } else {
            $berkas = Berkas::where('mahasiswa_id', $mahasiswa->id)->first();
        }

        return view('admin.beasiswa.index', compact('beasiswa', 'judul', 'berkas', 'mahasiswa', 'kriteria'));
    }

    public function index_saw(Request $request)
    {
        $request->session()->put('is_smart', false);
        $request->session()->put('is_saw', true);
        $judul = 'List Beasiswa';
        $beasiswa = Beasiswa::with('mahasiswas', 'kriterias', 'subkriteria')->whereHas('mahasiswas', function ($query) {
            $query->where('is_beasiswa_send', 1);
        })->get();
        $data_kriteria = Kriteria::all();

        if ($beasiswa->count() == 0) {
            $data = null;
            return view('admin.beasiswa.index-admin', compact('judul', 'beasiswa', 'data_kriteria', 'data'));
        }

        // Matrix
        $matrix = [];
        foreach ($beasiswa as $b) {
            $matrix[$b->kriteria_id][$b->mahasiswa_id] = $b->subkriteria->bobot;
        }

        $transpose_matrix = self::transpose($matrix);

        // Normalisasi SAW
        $normalisasi = [];
        foreach ($matrix as $m => $value) {
            // Cek Tipe Kriteria
            $kriteria = Kriteria::find($m);
            if ($kriteria->tipe == 'benefit') {
                $max = max($value);
                foreach ($value as $v => $nilai) {
                    $normalisasi[$m][$v] = $nilai / $max;
                }
            } else {
                $min = min($value);
                foreach ($value as $v => $nilai) {
                    $normalisasi[$m][$v] = $min / $nilai;
                }
            }
        }

        $transpose_matrix_normalisasi = self::transpose($normalisasi);

        // Proses Perangkingan Per Mahasiswa
        $perangkingan = [];
        foreach ($normalisasi as $n => $value) {
            $kriteria = Kriteria::find($n);
            foreach ($value as $v => $nilai) {
                $perangkingan[$v][$n] = $nilai * ($kriteria->bobot / 100);
            }
        }

        // Proses Perangkingan Akhir
        $perangkingan_akhir = [];
        foreach ($perangkingan as $p => $value) {
            $jumlah = 0;
            foreach ($value as $v) {
                $jumlah += $v;
            }
            $perangkingan_akhir[$p] = $jumlah;
        }
        arsort($perangkingan_akhir);

        // Save Skor To Mahasiswa
        foreach ($perangkingan_akhir as $p => $value) {
            $mahasiswa = Mahasiswa::find($p);
            $skor = Skor::where('mahasiswa_id', $mahasiswa->id)->first();
            if ($skor == null) {
                $skor = new Skor();
                $skor->mahasiswa_id = $mahasiswa->id;
            }
            $skor->skor_saw = $value;
            $skor->save();
        }

        $data = Mahasiswa::where('is_beasiswa_send', 1)->get();

        return view('admin.beasiswa.index-admin', compact('data', 'judul', 'transpose_matrix', 'transpose_matrix_normalisasi', 'perangkingan', 'data_kriteria'));
    }

    public function index_smart(Request $request)
    {
        $request->session()->put('is_smart', true);
        $request->session()->put('is_saw', false);
        $judul = 'List Beasiswa';
        $beasiswa = Beasiswa::with('mahasiswas', 'kriterias', 'subkriteria')->whereHas('mahasiswas', function ($query) {
            $query->where('is_beasiswa_send', 1);
        })->get();
        $data_kriteria = Kriteria::all();

        if ($beasiswa->count() == 0) {
            $data = null;
            return view('admin.beasiswa.index-admin', compact('judul', 'beasiswa', 'data_kriteria', 'data'));
        }

        // Matrix
        $matrix = [];
        foreach ($beasiswa as $b) {
            $matrix[$b->kriteria_id][$b->mahasiswa_id] = $b->subkriteria->bobot;
        }

        $transpose_matrix = self::transpose($matrix);

        // Normalisasi SMART
        $normalisasi = [];
        foreach ($matrix as $m => $value) {
            // Cek Tipe Kriteria
            $kriteria = Kriteria::find($m);
            $max = max($value);
            $min = min($value);
            if ($kriteria->tipe == 'benefit') {
                foreach ($value as $v => $nilai) {
                    if ($max == $min) {
                        $normalisasi[$m][$v] = 0;
                    } else {
                        $normalisasi[$m][$v] = ($nilai - $min) / ($max - $min);
                    }
                }
            } else {
                foreach ($value as $v => $nilai) {
                    if ($max == $min) {
                        $normalisasi[$m][$v] = 0;
                    } else {
                        $normalisasi[$m][$v] = ($max - $nilai) / ($max - $min);
                    }
                }
            }
        }

        $transpose_matrix_normalisasi = self::transpose($normalisasi);

        // Nilai Utility
        $perangkingan = [];
        foreach ($normalisasi as $n => $value) {
            $kriteria = Kriteria::find($n);
            foreach ($value as $v => $nilai) {
                $perangkingan[$v][$n] = $nilai * ($kriteria->bobot / 100);
            }
        }

        // Proses Perangkingan Akhir
        $perangkingan_akhir = [];
        foreach ($perangkingan as $u => $value) {
            $jumlah = 0;
            foreach ($value as $v) {
                $jumlah += $v;
            }
            $perangkingan_akhir[$u] = $jumlah;
        }
        arsort($perangkingan_akhir);

        // Save Skor To Mahasiswa
        foreach ($perangkingan_akhir as $p => $value) {
            $mahasiswa = Mahasiswa::find($p);
            $skor = Skor::where('mahasiswa_id', $mahasiswa->id)->first();
            if ($skor == null) {
                $skor = new Skor();
                $skor->mahasiswa_id = $mahasiswa->id;
            }
            $skor->skor_smart = $value;
            $skor->save();
        }

        $data = Mahasiswa::where('is_beasiswa_send', 1)->get();

        return view('admin.beasiswa.index-admin', compact('data', 'judul', 'data_kriteria', 'transpose_matrix', 'transpose_matrix_normalisasi', 'perangkingan',));
    }

    public function send()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $mahasiswa->is_beasiswa_send = true;
        $save = $mahasiswa->save();

        if ($save) {
            return redirect()->route('get.admin.daftar-beasiswa.index')->with('success', 'Berhasil mengirim beasiswa');
        } else {
            return redirect()->route('get.admin.daftar-beasiswa.index')->with('error', 'Gagal mengirim beasiswa');
        }
    }

    public function createStepOne()
    {
        $user = Auth::user();
        $judul = 'Daftar Beasiswa';
        $data = Berkas::where('mahasiswa_id', $user->mahasiswa->id)->get();
        if ($data == '[]') {
            $berkas = new Berkas();
            $berkas->mahasiswa_id = $user->mahasiswa->id;
            $berkas->save();
        }
        $data = Berkas::where('mahasiswa_id', $user->mahasiswa->id)->first();

        return view('admin.beasiswa.step-one', compact('judul', 'data'));
    }


    public function postStepOne(Request $request)
    {
        $user = Auth::user();
        $data = Berkas::where('mahasiswa_id', $user->mahasiswa->id)->first();
        $request->validate([
            'berkas' => 'nullable|mimes:pdf|max:10000',
        ]);

        // Cek apakah ada berkas?
        if ($request->hasFile('berkas')) {
            // Hapus Berkas Lama (Jika Ada)
            $namaberkas = $data->file;
            if (is_file(public_path('beasiswa') . '/' . $namaberkas)) {
                unlink(public_path('beasiswa') . '/' . $namaberkas);
            }
            // Upload File Baru
            $fileName = time() . '_' . $request->berkas->getClientOriginalName();
            $request->berkas->move(public_path('beasiswa'), $fileName);
            $data->file = $fileName;
        }
        $data->save();

        return redirect()->route('get.admin.daftar-beasiswa.step-two');
    }

    public function createStepTwo()
    {
        $judul = 'Daftar Beasiswa';
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        return view('admin.beasiswa.step-two', compact('mahasiswa', 'judul'));
    }

    public function postStepTwo(Request $request)
    {
        $user = Auth::user();
        $data = Mahasiswa::firstWhere('id', $user->mahasiswa->id);

        $request->validate([
            'name' => 'required|string',
            'semester' => 'required|numeric',
            'ukt' => 'required|numeric',
        ]);

        $data->user->name = $request->name;
        $data->semester = $request->semester;
        $data->ukt = $request->ukt;
        $data->save();

        return redirect()->route('get.admin.daftar-beasiswa.step-three');
    }

    public function createStepThree()
    {
        $judul = 'Daftar Beasiswa';
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $beasiswa = Beasiswa::where('mahasiswa_id', $user->mahasiswa->id)->get();
        $kriteria = Kriteria::all();

        return view('admin.beasiswa.step-three', compact('mahasiswa', 'judul', 'kriteria', 'beasiswa'));
    }

    public function postStepThree(Request $request)
    {
        $user = Auth::user();
        $data = Mahasiswa::firstWhere('id', $user->mahasiswa->id);
        $beasiswa = Beasiswa::where('mahasiswa_id', $user->mahasiswa->id)->get();
        $kriteria = Kriteria::all();

        $request->validate([
            'subkriteria' => 'required|array',
            'subkriteria.*' => 'required|numeric',
        ]);

        // Cek apakah sudah ada beasiswa?
        if ($beasiswa == '[]') {
            // Jika belum ada, maka buat beasiswa baru
            foreach ($kriteria as $k) {
                $beasiswa = new Beasiswa();
                $beasiswa->mahasiswa_id = $data->id;
                $beasiswa->kriteria_id = $k->id;
                $beasiswa->subkriteria_id = $request->subkriteria[$k->id];
                $beasiswa->save();
            }
        } else {
            // Jika sudah ada, maka update beasiswa
            foreach ($kriteria as $k) {
                $beasiswa = Beasiswa::where('mahasiswa_id', $data->id)->where('kriteria_id', $k->id)->first();
                $beasiswa->subkriteria_id = $request->subkriteria[$k->id];
                $beasiswa->save();
            }
        }

        return redirect()->route('get.admin.daftar-beasiswa.index');
    }

    public function ajax_modal(Request $request)
    {
        $data = Mahasiswa::where('id', $request->id)->first();
        $data_json = json_decode($data);
        return response()->json($data_json);
    }

    public function terima(Request $request)
    {
        $data = Mahasiswa::where('id', $request->id_mahasiswa_terima)->first();
        $user = User::where('id', $data->user_id)->first();
        EmailController::accept_beasiswa($user->id, $request->ukt);
        $data->is_beasiswa_approved = true;
        $data->save();
        return redirect()->back()->with('success', 'Berhasil menerima beasiswa');
    }

    public function tolak(Request $request)
    {
        $data = Mahasiswa::where('id', $request->id_mahasiswa_tolak)->first();
        $user = User::where('id', $data->user_id)->first();
        EmailController::reject_beasiswa($user->id, $request->alasan);
        $data->is_beasiswa_send = false;
        $data->is_beasiswa_approved = false;
        $data->save();
        // Delete Beasiswa
        $beasiswa = Beasiswa::where('mahasiswa_id', $data->id)->get();
        foreach ($beasiswa as $b) {
            $b->delete();
        }
        return redirect()->back()->with('success', 'Berhasil menolak beasiswa');
    }

    public function transpose($array)
    {
        array_unshift($array, null);
        return call_user_func_array('array_map', $array);
    }
}
