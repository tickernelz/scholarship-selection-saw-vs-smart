<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Berkas;
use App\Models\Mahasiswa;
use App\Models\Pengaturan;
use App\Models\Skor;
use App\Models\TahunAkademik;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $tahun_akademik = TahunAkademik::where('is_active', 1)->first();

        return view('admin.pengaturan', compact('judul', 'data', 'semester', 'selectedSemester', 'is_open', 'optionIsOpen', 'tahun_akademik'));
    }

    /**
     * @throws Exception
     */
    public function archive_beasiswa()
    {
        $tahun_akademik = TahunAkademik::where('is_active', 1)->first();
        $beasiswa = Beasiswa::where('tahun_akademik_id', $tahun_akademik->id)->get();
        $skor = Skor::where('tahun_akademik_id', $tahun_akademik->id)->get();
        $berkas = Berkas::where('tahun_akademik_id', $tahun_akademik->id)->get();
        $mahasiswa = Mahasiswa::where('tahun_akademik_id', $tahun_akademik->id)->get();

        foreach ($beasiswa as $b) {
            $b->archive();
        }

        foreach ($skor as $s) {
            $s->archive();
        }

        foreach ($berkas as $b) {
            $b->archive();
        }

        foreach ($mahasiswa as $m) {
            $m->archive();
            $m->user->archive();
        }

        return redirect()->back()->with('success', 'Data berhasil diarsipkan');
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
            $namaberkas = $berkas->file;
            if ($namaberkas != null) {
                if (Storage::disk('local')->exists('public/beasiswa/' . $namaberkas->file)) {
                    unlink(storage_path('app/public/beasiswa') . '/' . $namaberkas->file);
                }
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
        // Validasi Tahun Akademik
        $tahun_awal = $request->tahun_awal;
        $tahun_akhir = $request->tahun_akhir;
        $tahun_akhir_valid = $tahun_awal + 1;
        if ($tahun_awal >= $tahun_akhir || $tahun_akhir != $tahun_akhir_valid) {
            return redirect()->back()->with('error', 'Tahun akademik tidak valid');
        }
        // Cek apakah tahun akademik sudah ada
        $tahun_akademik = TahunAkademik::where('tahun_awal', $tahun_awal)->where('tahun_akhir', $tahun_akhir)->first();
        if ($tahun_akademik) {
            // Set is_active = 0 untuk tahun akademik yang lain
            TahunAkademik::where('id', '!=', $tahun_akademik->id)->update(['is_active' => 0]);
            // Jika sudah ada, cek apakah tahun akademik yang dipilih aktif
            $tahun_akademik->is_active = true;
            $tahun_akademik->save();
        } else {
            // Set is_active = 0 untuk tahun akademik yang lain
            TahunAkademik::query()->update(['is_active' => 0]);
            // Jika belum ada, buat tahun akademik baru
            TahunAkademik::create([
                'tahun_awal' => $tahun_awal,
                'tahun_akhir' => $tahun_akhir,
                'is_active' => true,
            ]);
        }
        $data->update([
            'is_open' => $request->is_open,
            'semester' => $request->semester,
            'batas_pengajuan' => $batas_pengajuan,
        ]);
        return redirect()->back()->with('success', 'Pengaturan berhasil diubah');
    }
}
