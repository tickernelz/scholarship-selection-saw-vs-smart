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
                <h3 class="card-title p-3">Upload Berkas</h3>
                {{--                <ul class="nav nav-pills ml-auto p-2">--}}
                {{--                    <li class="nav-item">--}}
                {{--                        <a href="{{ redirect()->getUrlGenerator()->route('get.admin.berita.index') }}">--}}
                {{--                            <button type="button" class="btn btn-primary">{{ trans('auth.kembali') }}</button>--}}
                {{--                        </a>--}}
                {{--                    </li>--}}
                {{--                </ul>--}}
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('post.admin.daftar-beasiswa.step-one') }}" enctype="multipart/form-data"
                  method="post">
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

                    @if ($beasiswa->berkas)
                        <x-adminlte-modal id="modal-file" title="Lihat File" size="lg">
                            <embed src="/beasiswa/{{ $beasiswa->berkas }}"
                                   frameborder="0" width="100%" height="600px">
                        </x-adminlte-modal>
                        <x-adminlte-input-file name="berkas" label="Upload File Surat"
                                               placeholder="{{ $beasiswa->berkas }}"/>
                        <button type="button" class="btn btn-secondary" data-toggle="modal"
                                data-target="#modal-file">
                            Lihat File
                        </button>
                    @else
                        <x-adminlte-input-file name="berkas" label="Upload File Surat"
                                               placeholder="Pilih File..." required/>
                    @endif
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
