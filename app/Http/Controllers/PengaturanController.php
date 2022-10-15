<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Berkas;
use App\Models\Mahasiswa;
use App\Models\Pengaturan;
use App\Models\Skor;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $judul = 'Pengaturan';
        $data = Pengaturan::first();
        $semester = ['ganjil' => 'Ganjil', 'genap' => 'Genap'];
        $selectedSemester = Pengaturan::where('semester', '!=', null)->first()->semester;
        $is_open = Pengaturan::where('is_open', '!=', null)->first()->is_open;
        $optionIsOpen = ['0' => 'Tutup', '1' => 'Buka'];

        return view('admin.pengaturan', compact('judul', 'data', 'semester', 'selectedSemester', 'is_open', 'optionIsOpen'));
    }

    public function reset_beasiswa()
    {
        $beasiswa = Beasiswa::get();
        $skor = Skor::get();
        $mahasiswa = Mahasiswa::get();
        foreach ($beasiswa as $b) {
            $b->delete();
        }
        foreach ($skor as $s) {
            $s->delete();
        }
        foreach ($mahasiswa as $m) {
            $m->is_beasiswa_send = 0;
            $m->is_beasiswa_approved = 0;
            $m->is_beasiswa_declined = 0;
            $m->save();
        }
        return redirect()->back()->with('success', 'Berhasil reset beasiswa');
    }

    public function reset_berkas()
    {
        $berkas = Berkas::get();
        foreach ($berkas as $b) {
            $namaberkas = $b->file;
            if (is_file(public_path('beasiswa') . '/' . $namaberkas)) {
                unlink(public_path('beasiswa') . '/' . $namaberkas);
            }
            $b->delete();
        }
        return redirect()->back()->with('success', 'Berhasil reset berkas');
    }

    public function update(Request $request, $id)
    {
        $data = Pengaturan::findOrFail($id);
        // Tempus to DateTime
        $batas_pengajuan = $data->convertBatasPengajuan($request->batas_pengajuan);
        $data->update([
            'is_open' => $request->is_open,
            'semester' => $request->semester,
            'batas_pengajuan' => $batas_pengajuan,
        ]);
        return redirect()->back()->with('success', 'Pengaturan berhasil diubah');
    }
}
