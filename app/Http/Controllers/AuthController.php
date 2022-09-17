<?php

namespace App\Http\Controllers;

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
                return redirect()->route('home');
            }
        }

        return view('login');
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

        Auth::attempt($data);

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('get.admin.dashboard');
            } else {
                return redirect()->route('home');
            }
        } else { // false
            Session::flash('error', 'Email atau password salah');

            return redirect()->route('get.login');
        }
    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif

        return redirect()->route('get.login');
    }
}
