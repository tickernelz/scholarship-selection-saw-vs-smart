@extends('layouts.auth')
@section('title')
    {{ trans('auth.halaman_login') }}
@endsection
@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form p-l-55 p-r-55 p-t-178" method="POST"
                      action="{{ route('post.login') }}">
                    @csrf
                    <span class="login100-form-title">
						{{ trans('auth.masuk') }}
					</span>
                    @if (Session::has('success'))
                        <div class="alert alert-success m-b-16" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger m-b-16" role="alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif

                    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter email">
                        <input class="input100" type="email" name="email" placeholder="{{ trans('auth.text_email') }}">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Please enter password">
                        <input class="input100" type="password" name="password"
                               placeholder="{{ trans('auth.text_password') }}">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="text-right p-t-13 p-b-23">
						<span class="txt1">
							{{ trans('auth.lupa') }}
						</span>

                        <a href="#" class="txt2">
                            {{ trans('auth.email_password') }}
                        </a>
                    </div>

                    <div class="container-login100-form-btn" style="margin-bottom: 1em">
                        <button class="login100-form-btn" type="submit">
                            {{ trans('auth.masuk') }}
                        </button>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="button"
                                onclick="location.href='{{ route('get.home.index') }}'">
                            {{ trans('auth.kembali_ke_beranda') }}
                        </button>
                    </div>

                    <div class="flex-col-c p-t-170 p-b-40">
						<span class="txt1 p-b-9">
							{{ trans('auth.belum_punya_akun') }}
						</span>

                        <a href="#" class="txt3">
                            {{ trans('auth.daftar_sekarang') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
