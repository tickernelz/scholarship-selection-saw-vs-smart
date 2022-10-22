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
                <h3 class="card-title p-3">Form Pertanyaan</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <a href="{{ route('get.admin.daftar-beasiswa.step-two') }}">
                            <button type="button" class="btn btn-primary">{{ trans('auth.kembali') }}</button>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('post.admin.daftar-beasiswa.step-three') }}" method="post"
                  enctype="multipart/form-data">
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
                    @foreach($kriteria as $k)
                        <div class="row">
                            <div class="col-lg-8 mb-4">
                                <span class="text-bold">{{ $k->nama }}</span>
                                <input type="hidden" name="kriteria[]" value="{{ $k->id }}">
                                {{--Radio Option Subkriteria--}}
                                @foreach($k->subkriteria as $s => $sub)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="subkriteria[{{ $k->id }}]"
                                               id="{{ $sub->id }}"
                                               value="{{ $sub->id }}" required
                                               @if ($beasiswa->where('kriteria_id', $k->id)->where('subkriteria_id', $sub->id)->first())
                                                   checked
                                            @endif>
                                        <label class="form-check-label" for="{{ $sub->id }}">
                                            {{ $sub->nama }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-lg-4">
                                @if ($berkas->where('kriteria_id', $k->id)->first())
                                    <div class="form-group">
                                        <x-adminlte-modal id="modal-file-{{$k->id}}" title="Lihat File" size="lg">
                                            <embed
                                                src="{{ route('get.beasiswa.readfile', $berkas->where('kriteria_id', $k->id)->first()->id) }}"
                                                frameborder="0" width="100%" height="600px"
                                                type="application/pdf">
                                        </x-adminlte-modal>
                                        <x-adminlte-input-file name="berkas[{{ $k->id }}]" igroup-size="sm"
                                                               placeholder="{{ $berkas->where('kriteria_id', $k->id)->first()->file }}">
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text bg-lightblue">
                                                    <i class="fas fa-upload"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input-file>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-secondary" data-toggle="modal"
                                                    data-target="#modal-file-{{$k->id}}">
                                                Lihat File
                                            </button>
                                            <a type="button" class="btn btn-primary"
                                               href="{{ route('get.beasiswa.download', $berkas->where('kriteria_id', $k->id)->first()->id) }}">
                                                Download
                                            </a>
                                            <a type="button" class="btn btn-danger"
                                               onclick="return confirm('Yakin Ingin Dihapus?');"
                                               href="{{ route('get.beasiswa.hapus', $berkas->where('kriteria_id', $k->id)->first()->id) }}">
                                                Hapus
                                            </a>
                                        </div>
                                    </div>
                                @elseif (!$berkas->where('kriteria_id', $k->id)->first() && $k->required == 1)
                                    <div class="form-group">
                                        {{-- Placeholder, sm size and prepend icon --}}
                                        <x-adminlte-input-file name="berkas[{{ $k->id }}]" igroup-size="sm"
                                                               placeholder="Upload File Bukti" required>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text bg-lightblue">
                                                    <i class="fas fa-upload"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input-file>
                                    </div>
                                @elseif (!$berkas->where('kriteria_id', $k->id)->first() && $k->required == 0)
                                    <div class="form-group">
                                        {{-- Placeholder, sm size and prepend icon --}}
                                        <x-adminlte-input-file name="berkas[{{ $k->id }}]" igroup-size="sm"
                                                               placeholder="Upload File Bukti">
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text bg-lightblue">
                                                    <i class="fas fa-upload"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input-file>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr>

                    @endforeach
                </div>
                <!-- /.card-body -->

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Selanjutnya</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
@stop

@section('js')
@stop
