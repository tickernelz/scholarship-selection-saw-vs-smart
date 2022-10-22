@extends('adminlte::page')

@section('title')
    {{ $judul }}
@endsection

@section('content_header')
    <h1>{{ $judul }}</h1>
@stop

@section('content')
    <div class="col-xl-12" style="float:none;margin:auto;">
        @if ($mahasiswa->is_beasiswa_send == 0 && $mahasiswa->is_beasiswa_approved == 0 && $mahasiswa->is_beasiswa_declined == 0)
            <div class="card">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Biodata</h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item">
                            <a href="{{ route('get.admin.daftar-beasiswa.step-one') }}">
                                <button type="button" class="btn btn-primary">{{ trans('auth.kembali') }}</button>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('post.admin.daftar-beasiswa.step-two') }}" method="post">
                    <div class="card-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Success!</h5>
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        @if (session('errors'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                                </button>
                                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @csrf
                        <x-adminlte-input name="nim" label="{{ trans('auth.nim') }}"
                                          placeholder="{{ trans('auth.nim') }}" value="{{ $mahasiswa->nim }}"
                                          disabled>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-id-card text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="studi" label="{{ trans('auth.studi') }}"
                                          placeholder="{{ trans('auth.studi') }}" value="{{ $mahasiswa->studi }}"
                                          disabled>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-id-card-alt text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="fakultas" label="{{ trans('auth.fakultas') }}"
                                          placeholder="{{ trans('auth.fakultas') }}"
                                          value="{{ $mahasiswa->fakultas }}" disabled>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-id-badge text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="name" label="{{ trans('auth.nama') }}"
                                          placeholder="{{ trans('auth.nama') }}"
                                          value="{{ $mahasiswa->user->name }}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-user text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="semester" label="{{ trans('auth.semester') }}"
                                          placeholder="{{ trans('auth.semester') }}"
                                          value="{{ $mahasiswa->semester }}" type="number">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-hourglass-half text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="ukt" label="{{ trans('auth.ukt') }}"
                                          placeholder="{{ trans('auth.ukt') }}"
                                          value="{{$mahasiswa->ukt }}" type="number">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-money-bill text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Selanjutnya</button>
                    </div>
                </form>
            </div>
        @elseif ($mahasiswa->is_beasiswa_send == 1 && $mahasiswa->is_beasiswa_approved == 0 && $mahasiswa->is_beasiswa_declined == 0)
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-info"></i> Info!</h5>
                Anda sudah mengirimkan formulir beasiswa
            </div>
        @elseif($mahasiswa->is_beasiswa_send == 1 && $mahasiswa->is_beasiswa_approved == 1 && $mahasiswa->is_beasiswa_declined == 0)
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Success!</h5>
                Anda sudah mendapatkan beasiswa
            </div>
        @elseif($mahasiswa->is_beasiswa_send == 0 && $mahasiswa->is_beasiswa_approved == 0 && $mahasiswa->is_beasiswa_declined == 1)
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                Anda tidak mendapatkan beasiswa. Silahkan coba lagi semester depan
            </div>
        @endif
    </div>

@endsection

@section('css')
@stop

@section('js')
@stop
