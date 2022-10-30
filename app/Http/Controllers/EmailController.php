<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\User;
use Mail;
use NumberFormatter;

class EmailController extends Controller
{
    public static function accept_verifikasi(int $id)
    {
        $user = User::find($id);
        $subject = 'Verifikasi Akun Berhasil';
        $markdown = 'emails.verifikasi';
        $data = [
            'title' => 'Verifikasi Akun',
            'body' => 'Selamat ' . $user->name . ', akun anda telah diverifikasi oleh admin. Silahkan login untuk melanjutkan.'
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
            'body' => 'Maaf ' . $user->name . ', Registrasi akun anda ditolak oleh admin. karena data tidak sesuai dengan mahasiswa Institut Agama Islam Negri Palangka Raya. Silahkan hubungi admin untuk informasi lebih lanjut.'
        ];

        Mail::to($user->email)->send(new SendMail($data, $subject, $markdown));
    }

    public static function accept_beasiswa(int $id, float $ukt)
    {
        $user = User::find($id);
        $subject = 'Penerimaan Beasiswa';
        $markdown = 'emails.verifikasi';
        $fmt = numfmt_create('id_ID', NumberFormatter::CURRENCY);
        $ukt = numfmt_format_currency($fmt, $ukt, "IDR");
        $data = [
            'title' => 'Penerimaan Beasiswa',
            'body' => 'Selamat ' . $user->name . ', anda telah diterima sebagai penerima beasiswa, Dengan UKT ' . $ukt . '. Silahkan login untuk melanjutkan.'
        ];

        Mail::to($user->email)->send(new SendMail($data, $subject, $markdown));
    }

    public static function reject_beasiswa(int $id, string $alasan)
    {
        $user = User::find($id);
        $subject = 'Penerimaan Beasiswa';
        $markdown = 'emails.verifikasi';
        $data = [
            'title' => 'Penerimaan Beasiswa',
            'body' => 'Maaf ' . $user->name . ', anda tidak diterima sebagai penerima beasiswa, dengan alasan ' . $alasan . '. Silahkan hubungi admin untuk informasi lebih lanjut.'
        ];

        Mail::to($user->email)->send(new SendMail($data, $subject, $markdown));
    }
}
