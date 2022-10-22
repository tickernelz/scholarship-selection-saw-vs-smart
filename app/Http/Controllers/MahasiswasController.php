<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswasController extends Controller
{
    public function index_list()
    {
        // Get Data
        $data = Mahasiswa::where('is_verified', 1)->get();
        $judul = trans('auth.list_mahasiswa');
        $route = 'list';

        return view('admin.mahasiswa.index', compact([
            'data',
            'judul',
            'route'
        ]));
    }

    public function index_verifikasi()
    {
        // Get Data
        $data = Mahasiswa::where('is_verified', 0)->get();
        $judul = trans('auth.verifikasi_mahasiswa');
        $route = 'verifikasi';

        return view('admin.mahasiswa.verifikasi', compact([
            'data',
            'judul',
            'route'
        ]));
    }

    public function accept(int $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        $user = User::find($mahasiswa->user_id);
        $mahasiswa->is_verified = 1;
        // Send Email
        EmailController::accept_verifikasi($user->id);
        $mahasiswa->save();

        return redirect()->back()->with('success', 'Mahasiswa berhasil diverifikasi');
    }

    public function reject(int $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        $namaberkas = $mahasiswa->ktm;
        // Hapus Berkas KTM (Jika Ada)
        if (is_file(public_path('ktm') . '/' . $namaberkas)) {
            unlink(public_path('ktm') . '/' . $namaberkas);
        }
        // Send Email
        EmailController::reject_verifikasi($mahasiswa->user_id);
        $mahasiswa->user->delete();
        $mahasiswa->delete();

        return redirect()->back()->with('success', 'Mahasiswa ditolak');
    }

    public function email_accept(int $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        $user = User::find($mahasiswa->user_id);
        EmailController::accept_verifikasi($user->id);

        return redirect()->back()->with('success', 'Email berhasil dikirim');
    }

    public function tambah_index()
    {
        $judul = 'Tambah Mahasiswa';

        return view('admin.mahasiswa.tambah', compact([
            'judul',
        ]));
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswas',
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'studi' => 'required',
            'fakultas' => 'required',
            'ukt' => 'required',
            'jenis_kelamin' => 'required',
            'ktm' => 'nullable|file|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $user->assignRole('mahasiswa');

        $mahasiswa = new Mahasiswa;
        $mahasiswa->user_id = $user->id;
        $mahasiswa->nim = $request->nim;
        $mahasiswa->studi = $request->studi;
        $mahasiswa->fakultas = $request->fakultas;
        $mahasiswa->angkatan = $request->angkatan;
        $mahasiswa->semester = $request->semester;
        $mahasiswa->ukt = $request->ukt;
        $mahasiswa->jenis_kelamin = $request->jenis_kelamin;
        $mahasiswa->ttl = $request->ttl;
        $mahasiswa->telepon = $request->telepon;
        $mahasiswa->is_verified = 1;

        // Upload KTM
        if ($request->hasFile('ktm')) {
            $ktm = $request->file('ktm');
            $namaberkas = $mahasiswa->nim . '.' . $ktm->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/ktm', $ktm, $namaberkas);
            $mahasiswa->ktm = $namaberkas;
        }
        $mahasiswa->save();

        return redirect()->back()->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function edit_index(int $id, string $route)
    {
        $data = Mahasiswa::find($id);
        $judul = trans('auth.edit_mahasiswa');

        return view('admin.mahasiswa.edit', compact([
            'data',
            'judul',
            'route'
        ]));
    }

    public function edit(Request $request, int $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        $user = User::find($mahasiswa->user_id);
        $request->validate([
            'nim' => 'required|unique:mahasiswas,nim,' . $mahasiswa->id,
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'password' => 'nullable',
            'studi' => 'required',
            'fakultas' => 'required',
            'ukt' => 'required',
            'jenis_kelamin' => 'required',
            'ktm' => 'nullable|file|mimes:jpg,jpeg,png|max:2048'
        ]);

        $mahasiswa = Mahasiswa::find($id);
        $mahasiswa->user->name = $request->name;
        $mahasiswa->user->email = $request->email;
        if ($request->password != null) {
            $mahasiswa->user->password = bcrypt($request->password);
        }
        $mahasiswa->nim = $request->nim;
        $mahasiswa->studi = $request->studi;
        $mahasiswa->fakultas = $request->fakultas;
        $mahasiswa->angkatan = $request->angkatan;
        $mahasiswa->semester = $request->semester;
        $mahasiswa->ukt = $request->ukt;
        $mahasiswa->jenis_kelamin = $request->jenis_kelamin;
        $mahasiswa->ttl = $request->ttl;
        $mahasiswa->telepon = $request->telepon;

        // Upload KTM
        if ($request->hasFile('ktm')) {
            $ktm = $request->file('ktm');
            $namaberkas = $mahasiswa->nim . '.' . $ktm->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/ktm', $ktm, $namaberkas);
            $mahasiswa->ktm = $namaberkas;
        }

        $mahasiswa->save();

        return redirect()->back()->with('success', 'Mahasiswa berhasil diubah');
    }

    public function readFile($file)
    {
        $file = Storage::disk('local')->get('public/ktm/' . $file);
        return response($file, 200)->header('Content-Type', 'image/jpeg');
    }

    public function hapus(int $id)
    {
        $data = Mahasiswa::find($id);
        $namaberkas = $data->ktm;

        // Hapus Berkas Lama (Jika Ada)
        if (is_file(public_path('ktm') . '/' . $namaberkas)) {
            unlink(public_path('ktm') . '/' . $namaberkas);
        }
        $data->delete();

        return back()
            ->with('success', 'Data Berhasil Dihapus!');
    }
}
