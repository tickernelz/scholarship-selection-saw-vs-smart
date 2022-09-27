<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Mahasiswa;
use Auth;
use Illuminate\Http\Request;

class BeasiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $judul = 'Daftar Beasiswa';
        $beasiswa = Beasiswa::where('mahasiswa_id', $user->mahasiswa->id)->get();

        return view('admin.beasiswa.index', compact('beasiswa', 'judul'));
    }

    public function createStepOne()
    {
        $user = Auth::user();
        $judul = 'Daftar Beasiswa';
        $data = Beasiswa::where('mahasiswa_id', $user->mahasiswa->id)->get();
        if ($data == '[]') {
            $beasiswa = new Beasiswa();
            $beasiswa->mahasiswa_id = $user->mahasiswa->id;
            $beasiswa->save();
        } else {
            $beasiswa = Beasiswa::where('mahasiswa_id', $user->mahasiswa->id)->first();
        }

        return view('admin.beasiswa.step-one', compact('judul', 'beasiswa'));
    }


    public function postStepOne(Request $request)
    {
        $user = Auth::user();
        $data = Beasiswa::where('mahasiswa_id', $user->mahasiswa->id)->first();
        $request->validate([
            'berkas' => 'nullable|mimes:pdf|max:10000',
        ]);

        // Cek apakah ada berkas?
        if ($request->hasFile('berkas')) {
            // Hapus Berkas Lama (Jika Ada)
            $namaberkas = $data->berkas;
            if (is_file(public_path('beasiswa') . '/' . $namaberkas)) {
                unlink(public_path('beasiswa') . '/' . $namaberkas);
            }
            // Upload File Baru
            $fileName = time() . '_' . $request->berkas->getClientOriginalName();
            $request->berkas->move(public_path('beasiswa'), $fileName);
            $data->berkas = $fileName;
        }
        $data->save();

        return redirect()->route('get.admin.daftar-beasiswa.step-two');
    }

    public function createStepTwo()
    {
        $judul = 'Daftar Beasiswa';
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        return view('admin.beasiswa.step-two',compact( 'mahasiswa', 'judul'));
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

        return redirect()->route('products.create.step.three');
    }
}
