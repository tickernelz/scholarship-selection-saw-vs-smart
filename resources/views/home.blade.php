@extends('layouts.berita')
@section('title')
    {{ trans('auth.beranda') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="header bg-gradient-success py-7 py-lg-8 pt-lg-9">
            <div class="container">
                <div class="header-body text-center mb-5 mt--5">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-6 col-md-2 px-5">
                            <img src="assets/img/brand/upr.png" class="" alt="..." style="width:40%">
                            <p class="text-lead text-white">APLIKASI<br/>PENINJAUAN KERINGANAN UKT<br/>UNIVERSITAS
                                PALANGKA RAYA</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                     xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-secondary" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <!-- Page content -->
        <div class="container mt--9  pb-5">
            <div class="row">
                <div class="col-sm-8 mr--2">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-header bg-transparent pb-5">
                            <div class="card-body">
                                <div class="text-center text-muted mb-4">
                                    <h3 class="heading">Informasi Penting</h3>
                                    <span class="mb-0 text-sm  font-weight-bold">Periode : Semester ,  | Batas Pengajuan Sampai :   </span>
                                    <hr class="my-4"/>
                                    <ul class="list-unstyled">

                                        <li class="media my-4">
                                            <img src="assets/img/icons/ipdf.png" style="width:60px" class="mr-3"
                                                 alt="...">
                                            <div class="media-body">
                                                <h4 class="mt-0 mb-1 text-left"><a
                                                        href="download.php%3Ffilename=Pengumuman_13.pdf.html">
                                                        PENGUMUMAN PERPANJANGAN JADWAL PROSES PENYIAPAN DOKUMEN DAN
                                                        PENGISIAN BORANG PROGRAM PEMBERIAII KERINGANAN PEMBAYARAN UANG
                                                        KULIAH TUNGGAL (UKT) MAHASISWA LAMA SEMESTER GANJIL TAHUN
                                                        AKADEMIK2O22/2O23</a> <span
                                                        class="badge badge-danger">New</span></h4>
                                                <p class="text-justify">
                                                    Pengisian Borang Pemberian Keringanan UKT di aplikasi
                                                    keringanan-ukt.upr.ac.id diperpanjang s.d Sabtu, 18 Juni 2022 pukul
                                                    23.59 WIB. <a href="download.php%3Ffilename=Pengumuman_13.pdf.html">Download
                                                        File</a></p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-header bg-transparent pb-3">
                            <div class="card-body">
                                <div class="text-center text-muted mb-4">
                                    <h3 class="heading">Silahkan Masuk</h3>
                                </div>
                                <form role="form" action="https://keringanan-ukt.upr.ac.id/logincek.php" method="POST">
                                    <div class="form-group mb-1">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Username" name="username"
                                                   requiered>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="ni ni-lock-circle-open"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Password" name="password"
                                                   type="password" required>
                                        </div>
                                    </div>

                                    <!-- cek pesan notifikasi -->
                                    <div class="text-right">
                                        <input type="submit" class="btn btn-primary" name="btnlogin" value="Masuk">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
