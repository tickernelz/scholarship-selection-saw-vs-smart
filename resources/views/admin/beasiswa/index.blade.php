@extends('adminlte::page')

@section('title')
    {{ $judul }}
@endsection

@section('content_header')
    <h1>{{ $judul }}</h1>
@stop

@php
    $config = [
        "height" => "500",
        "toolbar" => [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
    ]
@endphp

@section('content')
    <div class="col-xl-12" style="float:none;margin:auto;">
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Form Final</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <a href="{{ redirect()->getUrlGenerator()->route('get.admin.daftar-beasiswa.step-three') }}">
                            <button type="button" class="btn btn-primary">{{ trans('auth.kembali') }}</button>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('post.admin.daftar-beasiswa.send') }}" enctype="multipart/form-data" method="post">
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
                    <x-adminlte-card title="Berkas" theme="info" icon="fas fa-lg fa-file" collapsible>
                        @if ($berkas->first()->file)
                            <x-adminlte-modal id="modal-file" title="Lihat File" size="lg">
                                <embed src="/beasiswa/{{ $berkas->first()->file }}" type="application/pdf"
                                       frameborder="0" width="100%" height="600px">
                            </x-adminlte-modal>
                            <x-adminlte-input-file name="berkas" label="Upload File Surat"
                                                   placeholder="{{ $berkas->first()->file }}" disabled/>
                            <button type="button" class="btn btn-secondary" data-toggle="modal"
                                    data-target="#modal-file">
                                Lihat File
                            </button>
                        @else
                            <x-adminlte-input-file name="berkas" label="Upload File Surat"
                                                   placeholder="Pilih File..." disabled/>
                        @endif
                    </x-adminlte-card>
                    <x-adminlte-card title="Biodata" theme="info" icon="fas fa-lg fa-user" collapsible>
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
                                          placeholder="{{ trans('auth.nama') }}" value="{{ $mahasiswa->user->name }}"
                                          disabled>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-user text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="semester" label="{{ trans('auth.semester') }}"
                                          placeholder="{{ trans('auth.semester') }}"
                                          value="{{ $mahasiswa->semester }}" type="number" disabled>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-hourglass-half text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="ukt" label="{{ trans('auth.ukt') }}"
                                          placeholder="{{ trans('auth.ukt') }}"
                                          value="{{$mahasiswa->ukt }}" type="number" disabled>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-money-bill text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </x-adminlte-card>
                    <x-adminlte-card title="Pertanyaan" theme="info" icon="fas fa-lg fa-question" collapsible>
                        @foreach($kriteria as $k)
                            <span class="text-bold">{{ $k->nama }}</span>
                            <input type="hidden" name="kriteria[]" value="{{ $k->id }}">
                            {{--Radio Option Subkriteria--}}
                            @foreach($k->subkriteria as $s => $sub)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="subkriteria[{{ $k->id }}]"
                                           id="{{ $sub->id }}"
                                           value="{{ $sub->id }}" required disabled
                                           @if ($beasiswa->where('kriteria_id', $k->id)->where('subkriteria_id', $sub->id)->first())
                                               checked
                                        @endif>
                                    <label class="form-check-label" for="{{ $sub->id }}">
                                        {{ $sub->nama }}
                                    </label>
                                </div>
                            @endforeach
                            <hr>

                        @endforeach
                    </x-adminlte-card>
                </div>
                <!-- /.card-body -->

                <div class="card-footer text-right">
                    <button type="submit" onclick="return confirm('Yakin Ingin Mengirim Form?');"
                            class="btn btn-primary">{{ trans('auth.kirim') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
@stop

@section('js')
@stop
