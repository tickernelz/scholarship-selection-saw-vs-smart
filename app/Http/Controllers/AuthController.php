<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Session;
use Validator;

class AuthController extends Controller
{
    public function showFormLogin()
    {
        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('get.admin.dashboard');
            } else {
                return redirect()->route('get.home.index');
            }
        }

        return view('login');
    }

    public function showFormRegister()
    {
        return view('register');
    }

    public function login(Request $request)
    {
        $pengaturan = Pengaturan::first();
        $rules = [
            'email' => 'required|email',
            'password' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        $remember_me = $request->has('remember');

        Auth::attempt($data, $remember_me);

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('get.admin.dashboard');
            } elseif (Auth::user()->hasRole('mahasiswa') && Auth::user()->mahasiswa->is_verified && $pengaturan->is_open) {
                return redirect()->route('get.home.index');
            } elseif (Auth::user()->hasRole('mahasiswa') && !Auth::user()->mahasiswa->is_verified) {
                Auth::logout();
                return redirect()->route('get.login')->with('error', 'Akun anda belum diverifikasi');
            } elseif (Auth::user()->hasRole('mahasiswa') && !$pengaturan->is_open) {
                Auth::logout();
                return redirect()->route('get.login')->with('error', 'Pengajuan tidak dibuka');
            }
        } else { // false
            Session::flash('error', 'Email atau password salah');

            return redirect()->route('get.login');
        }
    }

    public function register(Request $request)
    {
        $tahun_akademik = TahunAkademik::where('is_active', 1)->first();
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'nim' => 'required|string|unique:mahasiswas',
            'studi' => 'nullable|string',
            'fakultas' => 'required|string',
            'angkatan' => 'required|numeric',
            'jenis_kelamin' => 'required|string',
            'ktm' => 'nullable|file|mimes:pdf|max:3555'
        ]);

        $data_user = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ];

        $data_mahasiswa = [
            'nim' => $request->input('nim'),
            'studi' => $request->input('studi'),
            'fakultas' => $request->input('fakultas'),
            'angkatan' => $request->input('angkatan'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'tahun_akademik_id' => $tahun_akademik->id,
            'ktm' => null,
        ];

        if ($request->hasFile('ktm')) {
            $ktm = $request->file('ktm');
            $namaberkas = $data_mahasiswa['nim'] . '.' . $ktm->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/ktm', $ktm, $namaberkas);
            $data_mahasiswa['ktm'] = $namaberkas;
        }

        $user = User::create($data_user)->assignRole('mahasiswa');
        $mahasiswa = $user->mahasiswa()->create($data_mahasiswa);

        if ($mahasiswa) {
            Session::flash('success', 'Register berhasil! Akun anda sedang diverifikasi oleh staff. Silahkan cek email (junk/spam) untuk informasi lebih lanjut.');
        } else {
            Session::flash('errors', ['' => 'Register gagal! Silahkan ulangi beberapa saat lagi.']);
        }
        return redirect()->route('get.login');
    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif

        return redirect()->route('get.login');
    }
}
