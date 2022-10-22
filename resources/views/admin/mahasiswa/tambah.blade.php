@extends('adminlte::page')

@section('title')
    {{ $judul }}
@endsection

@section('content_header')
    <h1>{{ $judul }}</h1>
@stop

@section('plugins.BsCustomFileInput', true)

@section('content')
    <div class="col-xl-12" style="float:none;margin:auto;">
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">{{ trans('auth.form_tambah') }}</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <a href="{{ redirect()->getUrlGenerator()->route('get.admin.mahasiswa.index.list') }}">
                            <button type="button" class="btn btn-primary">{{ trans('auth.kembali') }}</button>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('post.admin.mahasiswa.tambah') }}" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Success!</h5>
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (session('errors'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-ban"></i> Error!</h5>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @csrf
                    <x-adminlte-input name="name" label="{{ trans('auth.nama') }}"
                                      placeholder="{{ trans('auth.nama') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-user text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="email" type="email" label="{{ trans('auth.text_email') }}"
                                      placeholder="{{ trans('auth.text_email') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-mail-bulk text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="password" type="text" label="{{ trans('auth.text_password') }}"
                                      placeholder="{{ trans('auth.text_password') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-key text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="nim" label="{{ trans('auth.nim') }}"
                                      placeholder="{{ trans('auth.nim') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-id-card text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="studi" label="{{ trans('auth.studi') }}"
                                      placeholder="{{ trans('auth.studi') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-id-card-alt text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="fakultas" label="{{ trans('auth.fakultas') }}"
                                      placeholder="{{ trans('auth.fakultas') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-id-badge text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="angkatan" label="{{ trans('auth.angkatan') }}"
                                      placeholder="{{ trans('auth.angkatan') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-calendar-alt text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="semester" label="{{ trans('auth.semester') }}"
                                      placeholder="{{ trans('auth.semester') }}" type="number">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-hourglass-half text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="ukt" label="{{ trans('auth.ukt') }}"
                                      placeholder="{{ trans('auth.ukt') }}" type="number">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-money-bill text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-select name="jenis_kelamin" label="{{ trans('auth.jenis_kelamin') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-venus-mars text-lightblue"></i>
                            </div>
                        </x-slot>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </x-adminlte-select>
                    <x-adminlte-input name="ttl" label="{{ trans('auth.tempat_tanggal_lahir') }}"
                                      placeholder="{{ trans('auth.tempat_tanggal_lahir') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-birthday-cake text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="telepon" label="{{ trans('auth.nomor_hp') }}"
                                      placeholder="{{ trans('auth.nomor_hp') }}" type="number">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-mobile text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input-file name="ktm" label="Upload File KTM"
                                           placeholder="Pilih File..."/>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ trans('auth.tambah') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
@stop

@section('js')
@stop
