<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\MahasiswasController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Get
Route::get('/', [HomeController::class, 'index']);
Route::get('login', [AuthController::class, 'showFormLogin'])->name('get.login');
Route::get('register', [AuthController::class, 'showFormRegister'])->name('get.register');

// Home
Route::get('home', [HomeController::class, 'index'])->name('get.home.index');
Route::get('home/detail/{slug}/{id}', [HomeController::class, 'detail'])->name('get.home.detail');

// Auth
Route::post('login', [AuthController::class, 'login'])->name('post.login');
Route::post('register', [AuthController::class, 'register'])->name('post.register');
Route::post('logout', [AuthController::class, 'logout'])->name('post.logout');


Route::group(['middleware' => 'auth'], static function () {
    // Admin
    Route::get('admin', [DashboardController::class, 'index'])->name('get.admin.dashboard');
    // Profile
    Route::group(['middleware' => ['can:kelola profil']], static function () {
        Route::get('admin/profile', [ProfileController::class, 'index'])->name('get.admin.profile');
        Route::post('admin/profile/update/{id}', [ProfileController::class, 'update'])->name('post.admin.profile.update');
    });
    // Password
    Route::group(['middleware' => ['can:kelola password']], static function () {
        Route::get('admin/password', [PasswordController::class, 'index'])->name('get.admin.password');
        Route::post('admin/password/update/{id}', [PasswordController::class, 'update'])->name('post.admin.password.update');
    });
    // Posts
    Route::group(['middleware' => ['can:kelola berita']], static function () {
        Route::get('admin/berita', [PostsController::class, 'index'])->name('get.admin.berita.index');
        Route::get('admin/berita/tambah', [PostsController::class, 'tambah_index'])->name('get.admin.berita.tambah');
        Route::post('admin/berita/tambah/post', [PostsController::class, 'tambah'])->name('post.admin.berita.tambah');
        Route::get('admin/berita/edit/{id}', [PostsController::class, 'edit_index'])->name('get.admin.berita.edit');
        Route::post('admin/berita/edit/{id}/post', [PostsController::class, 'edit'])->name('post.admin.berita.edit');
        Route::get('admin/berita/hapus/{id}', [PostsController::class, 'hapus'])->name('get.admin.berita.hapus');
        Route::get('admin/berita/hapus-berkas/{id}', [PostsController::class, 'hapus_berkas'])->name('hapus.berkas.surat.masuk');
    });
    // Kelola Mahasiswa
    Route::group(['middleware' => ['can:kelola mahasiswa']], static function () {
        Route::get('admin/mahasiswa/verifikasi', [MahasiswasController::class, 'index_verifikasi'])->name('get.admin.mahasiswa.index.verifikasi');
        Route::get('admin/mahasiswa/verifikasi/accept/{id}', [MahasiswasController::class, 'accept'])->name('get.admin.mahasiswa.verifikasi.accept');
        Route::get('admin/mahasiswa/verifikasi/reject/{id}', [MahasiswasController::class, 'reject'])->name('get.admin.mahasiswa.verifikasi.reject');
        Route::get('admin/mahasiswa', [MahasiswasController::class, 'index_list'])->name('get.admin.mahasiswa.index.list');
        Route::get('admin/mahasiswa/edit/{id}/{route}', [MahasiswasController::class, 'edit_index'])->name('get.admin.mahasiswa.edit.index');
        Route::post('admin/mahasiswa/edit/{id}/post', [MahasiswasController::class, 'edit'])->name('post.admin.mahasiswa.edit');
        Route::get('admin/mahasiswa/hapus/{id}', [MahasiswasController::class, 'hapus'])->name('get.admin.mahasiswa.hapus');
    });
    // Daftar Beasiswa
    Route::group(['middleware' => ['can:daftar beasiswa']], static function () {
        Route::get('admin/daftar-beasiswa', [PostsController::class, 'daftar_beasiswa'])->name('get.admin.daftar-beasiswa');
    });
});


