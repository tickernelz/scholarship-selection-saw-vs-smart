<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Nilai tetap
        $judul = trans('auth.dashboard');
        if (Auth::user()->hasRole('admin')) {
            return view('admin.dashboard', compact('judul'));
        } elseif (Auth::user()->hasRole('mahasiswa') && Auth::user()->mahasiswa->is_verified) {
            return view('admin.dashboard', compact('judul'));
        } else {
            Auth::logout();
            return redirect()->route('get.login')->with('error', 'Akun anda belum diverifikasi');
        }
    }
}
