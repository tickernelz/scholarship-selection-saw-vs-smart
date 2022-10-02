@extends('adminlte::page')

@section('title')
    {{ $judul }}
@endsection

@section('content_header')
    <h1>{{ $judul }}</h1>
@stop

@section('plugins.TempusDominusBs4', true)

@php
    $config_tempus = [
        'locale' => 'id',
        'useCurrent' => false,
        'sideBySide' => true,
        'showClear' => true,
        'showClose' => true,
        'showToday' => true,
    ];
@endphp

@section('content')

    <div class="row">
        <div class="col-xl-6">
            <form action="{{ route('post.admin.pengaturan.update', 1) }}" method="POST">
                @csrf
                <x-adminlte-card title="Basic"
                                 footer-class="border-top rounded border-light" maximizable>
                    @if(session('errors'))
                        <x-adminlte-alert theme="danger" title="Error!" dismissable>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-adminlte-alert>
                    @endif
                    @if (Session::has('success'))
                        <x-adminlte-alert theme="success" title="Success!" dismissable>
                            {{ Session::get('success') }}
                        </x-adminlte-alert>
                    @endif
                    @if (Session::has('error'))
                        <x-adminlte-alert theme="danger" title="Error!" dismissable>
                            {{ Session::get('error') }}
                        </x-adminlte-alert>
                    @endif
                    <x-adminlte-select name="semester" label="Semester">
                        <x-adminlte-options :options="$semester" :selected="$selectedSemester"
                                            placeholder="Pilih Semester..."/>
                    </x-adminlte-select>

                    <x-adminlte-input-date name="batas_pengajuan" label="Batas Pengajuan"
                                           value="{{ $data->batasPengajuanDateTime() ?? '' }}"
                                           :config="$config_tempus"/>

                    <x-adminlte-select name="is_open" label="Buka Pendaftaran">
                        <x-adminlte-options :options="$optionIsOpen" :selected="$is_open"/>
                    </x-adminlte-select>

                    <x-slot name="footerSlot">
                        <x-adminlte-button class="btn-primary d-flex ml-auto" type="submit"
                                           label="{{ trans('auth.simpan') }}"
                                           theme="success"/>
                    </x-slot>
                </x-adminlte-card>
            </form>
        </div>

        <div class="col-xl-6">
            <x-adminlte-card title="Advanced" maximizable>
                <form action="{{ route('post.admin.pengaturan.reset_beasiswa') }}" method="post">
                    @csrf
                    <x-adminlte-button class="btn-lg" type="submit" label="Reset Beasiswa" theme="outline-danger"
                                       icon="fas fa-lg fa-trash"
                                       onclick="return confirm('Yakin Ingin Mereset Seluruh Data Beasiswa?');"/>
                </form>

                <form class="mt-3" action="{{ route('post.admin.pengaturan.reset_berkas') }}" method="post">
                    @csrf
                    <x-adminlte-button class="btn-lg" type="submit" label="Reset Berkas" theme="outline-danger"
                                       icon="fas fa-lg fa-trash"
                                       onclick="return confirm('Yakin Ingin Mereset Seluruh Data Berkas Mahasiswa?');"/>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@endsection

@section('css')
@stop

@section('js')
@stop
