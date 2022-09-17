<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    public function index()
    {
        // Nilai tetap
        $judul = trans('auth.ubah_kata_sandi');
        $user = Auth::user();

        return view('admin.password', compact('judul', 'user'));
    }

    public function update(Request $request, int $id)
    {
        $data = User::firstWhere('id', $id);

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|same:confirm_password|required_with:confirm_password',
            'confirm_password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        else {
            if (Hash::check($request->input('current_password'), $data->password))
            {
                $data->password = Hash::make($request->input('new_password'));

                $data->save();

                return back()->with('success', 'Password Berhasil Diubah!');
            }
            else{
                return back()->with('error', 'Password Salah!');
            }

        }
    }
}
