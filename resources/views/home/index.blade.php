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
                            <img src="{{ asset('logo.png') }}" class="" alt="..." style="width:40%">
                            <p class="text-lead text-white">KERINGANAN UANG KULIAH TUNGGAL IAIN PALANGKA RAYA</p>
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
                                    <span class="mb-0 text-sm  font-weight-bold">Periode : Semester {{ $pengaturan->getSemester() }} | Batas Pengajuan Sampai : {{ $pengaturan->batasPengajuan() }}</span>
                                    <hr class="my-4"/>
                                    <ul class="list-unstyled">
                                        @foreach($berita as $li)
                                            <li class="media">
                                                <div class="media-body">
                                                    <div class="media-heading">
                                                        <a href="{{ route('get.home.detail', [$li->slug, $li->id]) }}">
                                                            <h5 class="heading mb-0">{{ $li->title }}</h5>
                                                        </a>
                                                    </div>
                                                    <p class="text-justify">
                                                        {!! Str::limit($li->body, 400) !!}
                                                    </p>
                                                    @if (isset($li->file))
                                                        <p class="text-justify">
                                                            <a href="/files/{{ $li->file }}" target="_blank">Download
                                                                File</a></p>
                                                    @else
                                                        <p class="text-center text-warning">
                                                            Tidak Ada Berkas
                                                        </p>
                                                    @endif
                                                    <hr class="my-2"/>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="d-flex justify-content-center">
                                    {!! $berita->links() !!}
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
                                    @if(Auth::user())
                                        <h3 class="heading">Halo, {{ $user->name }}</h3>
                                    @else
                                        <h3 class="heading">Silahkan Masuk</h3>
                                    @endif
                                </div>
                                <div class="text-center">
                                    @if(Auth::user())
                                        <button class="btn btn-primary" type="button"
                                                onclick="location.href='{{ route('get.admin.dashboard') }}'">Masuk
                                            Dashboard
                                        </button>
                                        <button class="btn btn-danger m-4" href="{{ route('post.logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </button>
                                        <form id="logout-form" action="{{ route('post.logout') }}" method="POST"
                                              style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    @else
                                        <button class="btn btn-primary"
                                                onclick="location.href='{{ route('get.login') }}'">Login
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
