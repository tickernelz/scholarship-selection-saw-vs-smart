<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            } else {
                return redirect()->route('get.home.index');
            }
        } else { // false
            Session::flash('error', 'Email atau password salah');

            return redirect()->route('get.login');
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'nim' => 'required|string|max:255|unique:mahasiswas',
            'prodi' => 'nullable|string|max:255',
            'jurusan' => 'required|string|max:255',
        ]);

        $data_user = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ];

        $data_mahasiswa = [
            'nim' => $request->input('nim'),
            'prodi' => $request->input('prodi'),
            'jurusan' => $request->input('jurusan'),
        ];

        $user = User::create($data_user)->assignRole('mahasiswa');
        $mahasiswa = $user->mahasiswa()->create($data_mahasiswa);

        if ($mahasiswa) {
            Session::flash('success', 'Register berhasil! Silahkan login.');
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
