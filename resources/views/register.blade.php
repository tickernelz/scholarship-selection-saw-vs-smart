@extends('layouts.auth')
@section('title')
    {{ trans('auth.halaman_daftar') }}
@endsection
@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form p-l-55 p-r-55 p-t-178" method="POST"
                      action="{{ route('post.register') }}">
                    @csrf
                    <span class="login100-form-title">
						{{ trans('auth.daftar') }}
					</span>
                    @if (Session::has('success'))
                        <div class="alert alert-success m-b-16" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (session('errors'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5>Error!</h5>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="wrap-input100 validate-input m-b-16">
                        <input class="input100" type="text" name="name" placeholder="{{ trans('auth.nama_lengkap') }}">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-16">
                        <input class="input100" type="email" name="email" placeholder="{{ trans('auth.text_email') }}">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-16">
                        <input class="input100" type="password" name="password"
                               placeholder="{{ trans('auth.text_password') }}">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-16">
                        <input class="input100" type="password" name="password_confirmation"
                               placeholder="{{ trans('auth.konfirmasi_password') }}">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="flex-col-c p-t-10 p-b-10">
						<span class="txt1 p-b-9">
							{{ trans('auth.data_mahasiswa') }}
						</span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-16">
                        <input class="input100" type="text" name="nim" placeholder="{{ trans('auth.nim') }}">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 m-b-16">
                        <input class="input100" type="text" name="prodi" placeholder="{{ trans('auth.prodi') }}">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-30">
                        <input class="input100" type="text" name="jurusan" placeholder="{{ trans('auth.jurusan') }}">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="container-login100-form-btn" style="margin-bottom: 1em">
                        <button class="login100-form-btn" type="submit">
                            {{ trans('auth.daftar') }}
                        </button>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="button"
                                onclick="location.href='{{ route('get.home.index') }}'">
                            {{ trans('auth.kembali_ke_beranda') }}
                        </button>
                    </div>

                    <div class="flex-col-c p-t-30 p-b-40">
						<span class="txt1 p-b-9">
							{{ trans('auth.sudah_punya_akun') }}
						</span>

                        <a href="{{ route('get.login') }}" class="txt3">
                            {{ trans('auth.halaman_login') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
