<?php

use App\Http\Controllers\BeritaController;
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
// Home
Route::get('home', [HomeController::class, 'index'])->name('get.home.index');
Route::get('home/detail/{slug}/{id}', [HomeController::class, 'detail'])->name('get.home.detail');

// Post
Route::post('login', [AuthController::class, 'login'])->name('post.login');
Route::post('logout', [AuthController::class, 'logout'])->name('post.logout');


Route::group(['middleware' => 'auth'], static function () {
    Route::group(['middleware' => ['role:admin']], static function () {
        // Admin
        Route::get('admin', [DashboardController::class, 'index'])->name('get.admin.dashboard');
        // Profile
        Route::get('admin/profile', [ProfileController::class, 'index'])->name('get.admin.profile');
        Route::post('admin/profile/update/{id}', [ProfileController::class, 'update'])->name('post.admin.profile.update');
        // Password
        Route::get('admin/password', [PasswordController::class, 'index'])->name('get.admin.password');
        Route::post('admin/password/update/{id}', [PasswordController::class, 'update'])->name('post.admin.password.update');
        // Berita
        Route::get('admin/berita', [BeritaController::class, 'index'])->name('get.admin.berita.index');
        Route::get('admin/berita/tambah', [BeritaController::class, 'tambah_index'])->name('get.admin.berita.tambah');
        Route::post('admin/berita/tambah/post', [BeritaController::class, 'tambah'])->name('post.admin.berita.tambah');
        Route::get('admin/berita/edit/{id}', [BeritaController::class, 'edit_index'])->name('get.admin.berita.edit');
        Route::post('admin/berita/edit/{id}/post', [BeritaController::class, 'edit'])->name('post.admin.berita.edit');
        Route::get('admin/berita/hapus/{id}', [BeritaController::class, 'hapus'])->name('get.admin.berita.hapus');
        Route::get('admin/berita/hapus-berkas/{id}', [BeritaController::class, 'hapus_berkas'])->name('hapus.berkas.surat.masuk');
    });
});


