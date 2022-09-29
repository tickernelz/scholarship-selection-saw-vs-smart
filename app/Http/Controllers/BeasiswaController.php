<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Berkas;
use App\Models\Kriteria;
use App\Models\Mahasiswa;
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
            $data = Berkas::where('mahasiswa_id', $user->mahasiswa->id)->first();
        } else {
            $data = Berkas::where('mahasiswa_id', $user->mahasiswa->id)->first();
        }

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
}
