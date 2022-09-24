<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;

class EmailController extends Controller
{
    public static function accept_verifikasi(int $id)
    {
        $user = User::find($id);
        $subject = 'Verifikasi Akun Berhasil';
        $markdown = 'emails.verifikasi';
        $data = [
            'title' => 'Verifikasi Akun',
            'body' => 'Selamat '.$user->name.', akun anda telah diverifikasi oleh admin. Silahkan login untuk melanjutkan.'
        ];

        Mail::to($user->email)->send(new SendMail($data, $subject, $markdown));
    }
    public static function reject_verifikasi(int $id)
    {
        $user = User::find($id);
        $subject = 'Verifikasi Akun Gagal';
        $markdown = 'emails.verifikasi';
        $data = [
            'title' => 'Verifikasi Akun',
            'body' => 'Maaf '.$user->name.', akun anda ditolak oleh admin. Silahkan hubungi admin untuk informasi lebih lanjut.'
        ];

        Mail::to($user->email)->send(new SendMail($data, $subject, $markdown));
    }
}
