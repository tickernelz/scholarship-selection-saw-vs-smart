<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Berkas;
use App\Models\Kriteria;
use App\Models\Mahasiswa;
use App\Models\Pengaturan;
use App\Models\Skor;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class BeasiswaController extends Controller
{
    public function index()
    {
        $judul = 'Daftar';
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $kriteria = Kriteria::all();
        $beasiswa = Beasiswa::where('mahasiswa_id', $mahasiswa->id)->get();
        $berkas = Berkas::where('mahasiswa_id', $user->mahasiswa->id)->get();

        return view('admin.beasiswa.index', compact('beasiswa', 'judul', 'berkas', 'mahasiswa', 'kriteria'));
    }

    public function index_saw(Request $request)
    {
        $request->session()->put('is_smart', false);
        $request->session()->put('is_saw', true);
        $judul = 'List Perhitungan SAW';
        $beasiswa = Beasiswa::with('mahasiswas', 'kriterias', 'subkriteria')->whereHas('mahasiswas', function ($query) {
            $query->where('is_beasiswa_send', 1);
        })->get();
        $data_kriteria = Kriteria::all();
        $route_now = Route::currentRouteName();

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
                    if ($max == 0) {
                        $normalisasi[$m][$v] = 1;
                    } else {
                        $normalisasi[$m][$v] = $nilai / $max;
                    }
                }
            } else {
                $min = min($value);
                foreach ($value as $v => $nilai) {
                    if ($nilai == 0) {
                        $normalisasi[$m][$v] = 1;
                    } else {
                        $normalisasi[$m][$v] = $min / $nilai;
                    }
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
                $skor->tahun_akademik_id = $mahasiswa->tahun_akademik_id;
            }
            $skor->skor_saw = $value;
            $skor->save();
        }

        $data = Mahasiswa::where('is_beasiswa_send', 1)->get();

        return view('admin.beasiswa.index-admin', compact('data', 'judul', 'transpose_matrix', 'transpose_matrix_normalisasi', 'perangkingan', 'data_kriteria', 'route_now'));
    }

    public function index_smart(Request $request)
    {
        $request->session()->put('is_smart', true);
        $request->session()->put('is_saw', false);
        $judul = 'List Perhitungan SMART';
        $beasiswa = Beasiswa::with('mahasiswas', 'kriterias', 'subkriteria')->whereHas('mahasiswas', function ($query) {
            $query->where('is_beasiswa_send', 1);
        })->get();
        $data_kriteria = Kriteria::all();
        $route_now = Route::currentRouteName();

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
                        $normalisasi[$m][$v] = 1;
                    } else {
                        $normalisasi[$m][$v] = ($nilai - $min) / ($max - $min);
                    }
                }
            } else {
                foreach ($value as $v => $nilai) {
                    if ($max == $min) {
                        $normalisasi[$m][$v] = 1;
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
                $skor->tahun_akademik_id = $mahasiswa->tahun_akademik_id;
            }
            $skor->skor_smart = $value;
            $skor->save();
        }

        $data = Mahasiswa::where('is_beasiswa_send', 1)->get();

        return view('admin.beasiswa.index-admin', compact('data', 'judul', 'data_kriteria', 'transpose_matrix', 'transpose_matrix_normalisasi', 'perangkingan', 'route_now'));
    }

    public function send()
    {
        $pengaturan = Pengaturan::first();
        if ($pengaturan->batas_pengajuan <= Carbon::now()) {
            return redirect()->back()->with('error', 'Batas Pengajuan Penurunan UKT Sudah Lewat');
        }
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $mahasiswa->is_beasiswa_send = true;
        $save = $mahasiswa->save();

        if ($save) {
            return redirect()->route('get.admin.daftar-beasiswa.index')->with('success', 'Berhasil mengirim penurunan UKT');
        } else {
            return redirect()->route('get.admin.daftar-beasiswa.index')->with('error', 'Gagal mengirim penurunan UKT');
        }
    }

    public function createStepOne()
    {
        $user = Auth::user();
        $judul = 'Daftar';
        $data = Berkas::where('mahasiswa_id', $user->mahasiswa->id)->get();
        if ($data == '[]') {
            $berkas = new Berkas();
            $berkas->mahasiswa_id = $user->mahasiswa->id;
            $berkas->tahun_akademik_id = $user->mahasiswa->tahun_akademik_id;
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
        $judul = 'Daftar';
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        return view('admin.beasiswa.step-two', compact('mahasiswa', 'judul'));
    }

    public function postStepTwo(Request $request)
    {
        $user = Auth::user();
        $data = Mahasiswa::firstWhere('id', $user->mahasiswa->id);
        $semester = Pengaturan::first()->semester;
        $semester_is_odd = $semester == 'Ganjil' || $semester == 'ganjil';
        $semester_is_even = $semester == 'Genap' || $semester == 'genap';

        $request->validate([
            'name' => 'required|string',
            'semester' => 'required|integer|min:3|max:9|',
            'ukt' => 'required|numeric',
        ]);

        $req_semester = $request->semester;
        $is_req_semester = false;

        if ($semester_is_odd) {
            $is_req_semester = $req_semester % 2 == 1;
        } else if ($semester_is_even) {
            $is_req_semester = $req_semester % 2 == 0;
        }

        if (!$is_req_semester) {
            return redirect()->back()->with('error', 'Semester yang anda masukkan tidak sesuai dengan semester saat ini');
        }

        $data->user->name = $request->name;
        $data->semester = $req_semester;
        $data->ukt = $request->ukt;
        $data->save();

        return redirect()->route('get.admin.daftar-beasiswa.step-three');
    }

    public function createStepThree()
    {
        $judul = 'Daftar';
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $beasiswa = Beasiswa::where('mahasiswa_id', $user->mahasiswa->id)->get();
        $kriteria = Kriteria::all();
        $berkas = Berkas::where('mahasiswa_id', $user->mahasiswa->id)->get();

        return view('admin.beasiswa.step-three', compact('mahasiswa', 'judul', 'kriteria', 'beasiswa', 'berkas'));
    }

    public function postStepThree(Request $request)
    {
        $user = Auth::user();
        $data = Mahasiswa::firstWhere('id', $user->mahasiswa->id);
        $beasiswa = Beasiswa::where('mahasiswa_id', $user->mahasiswa->id)->get();
        $kriteria = Kriteria::all();
        $berkas = Berkas::where('mahasiswa_id', $user->mahasiswa->id)->get();

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
                $beasiswa->tahun_akademik_id = $data->tahun_akademik_id;
                $beasiswa->save();
                // Cek apakah ada berkas?
                if ($request->hasFile('berkas')) {
                    if (array_key_exists($k->id, $request->berkas)) {
                        // Upload File Baru
                        $fileName = time() . '_' . $data->id . '_' . $k->id . '_' . $request->berkas[$k->id]->getClientOriginalName();
                        Storage::disk('local')->putFileAs('public/beasiswa', $request->berkas[$k->id], $fileName);
                        $berkas = Berkas::where([
                            ['mahasiswa_id', $data->id],
                            ['kriteria_id', $k->id],
                        ])->first();
                        if ($berkas == null) {
                            $berkas = new Berkas();
                            $berkas->mahasiswa_id = $data->id;
                            $berkas->kriteria_id = $k->id;
                            $berkas->tahun_akademik_id = $data->tahun_akademik_id;
                        }
                        $berkas->file = $fileName;
                        $berkas->save();
                    }
                }
            }
        } else {
            // Jika sudah ada, maka update beasiswa
            foreach ($kriteria as $k) {
                $beasiswa = Beasiswa::where('mahasiswa_id', $data->id)->where('kriteria_id', $k->id)->first();
                $beasiswa->subkriteria_id = $request->subkriteria[$k->id];
                $beasiswa->save();
                // Cek apakah ada berkas?
                if ($request->hasFile('berkas')) {
                    if (array_key_exists($k->id, $request->berkas)) {
                        // Hapus Berkas Lama (Jika Ada)
                        $namaberkas = $berkas->where('kriteria_id', $k->id)->first();
                        if ($namaberkas != null) {
                            if (Storage::disk('local')->exists('public/beasiswa/' . $namaberkas->file)) {
                                unlink(storage_path('app/public/beasiswa') . '/' . $namaberkas->file);
                            }
                        }
                        // Upload File Baru
                        $fileName = time() . '_' . $data->id . '_' . $k->id . '_' . $request->berkas[$k->id]->getClientOriginalName();
                        Storage::disk('local')->putFileAs('public/beasiswa', $request->berkas[$k->id], $fileName);
                        $berkas = Berkas::where([
                            ['mahasiswa_id', $data->id],
                            ['kriteria_id', $k->id],
                        ])->first();
                        if ($berkas == null) {
                            $berkas = new Berkas();
                            $berkas->mahasiswa_id = $data->id;
                            $berkas->kriteria_id = $k->id;
                            $berkas->tahun_akademik_id = $data->tahun_akademik_id;
                        }
                        $berkas->file = $fileName;
                        $berkas->save();
                    }
                }
            }
        }

        return redirect()->route('get.admin.daftar-beasiswa.index');
    }

    public function detail_saw($id)
    {
        $judul = 'Detail Perhitungan SAW';
        $beasiswa = Beasiswa::where('mahasiswa_id', $id)->get();
        $kriteria = Kriteria::all();
        $berkas = Berkas::where('mahasiswa_id', $id)->get();
        $mahasiswa = Mahasiswa::where('id', $id)->first();
        $is_saw = true;
        $is_smart = false;

        return view('admin.beasiswa.detail', compact('beasiswa', 'kriteria', 'berkas', 'judul', 'mahasiswa', 'is_saw', 'is_smart'));
    }

    public function detail_smart($id)
    {
        $judul = 'Detail Perhitungan SMART';
        $beasiswa = Beasiswa::where('mahasiswa_id', $id)->get();
        $kriteria = Kriteria::all();
        $berkas = Berkas::where('mahasiswa_id', $id)->get();
        $mahasiswa = Mahasiswa::where('id', $id)->first();
        $is_saw = false;
        $is_smart = true;

        return view('admin.beasiswa.detail', compact('beasiswa', 'kriteria', 'berkas', 'judul', 'mahasiswa', 'is_saw', 'is_smart'));
    }

    public function download($id)
    {
        $berkas = Berkas::find($id);
        $filePath = storage_path('app/public/beasiswa/' . $berkas->file);
        return response()->download($filePath);
    }

    public function hapusFile($id)
    {
        $berkas = Berkas::find($id);
        if (Storage::disk('local')->exists('public/beasiswa/' . $berkas->file)) {
            unlink(storage_path('app/public/beasiswa') . '/' . $berkas->file);
        }
        $berkas->delete();
        return redirect()->back();
    }

    public function readFile($id)
    {
        $berkas = Berkas::find($id);
        $filePath = storage_path('app/public/beasiswa/' . $berkas->file);
        return response()->download($filePath, $berkas->file, [
            'Content-Type' => 'application/pdf',
        ], 'inline');
    }

    public function ajax_modal(Request $request)
    {
        $data = Mahasiswa::where('id', $request->id)->first();
        $data_json = [
            'id' => $data->id,
            'ukt_awal' => $data->ukt,
            'ukt' => $data->ukt / 2,
        ];
        return response()->json($data_json);
    }

    public function terima(Request $request)
    {
        $data = Mahasiswa::where('id', $request->id_mahasiswa_terima)->first();
        $user = User::where('id', $data->user_id)->first();
        EmailController::accept_beasiswa($user->id, $request->ukt);
        $data->is_beasiswa_approved = true;
        $data->ukt_penurunan = $request->ukt;
        $data->save();
        return redirect()->back()->with('success', 'Berhasil menerima penurunan UKT');
    }

    public function tolak(Request $request)
    {
        $data = Mahasiswa::where('id', $request->id_mahasiswa_tolak)->first();
        $user = User::where('id', $data->user_id)->first();
        EmailController::reject_beasiswa($user->id, $request->alasan);
        $data->is_beasiswa_send = false;
        $data->is_beasiswa_approved = false;
        $data->is_beasiswa_declined = true;
        $data->save();
        // Delete Beasiswa
        $beasiswa = Beasiswa::where('mahasiswa_id', $data->id)->get();
        foreach ($beasiswa as $b) {
            $b->delete();
        }
        return redirect()->back()->with('success', 'Berhasil menolak penurunan UKT');
    }

    public function transpose($array)
    {
        array_unshift($array, null);
        return call_user_func_array('array_map', $array);
    }
}
