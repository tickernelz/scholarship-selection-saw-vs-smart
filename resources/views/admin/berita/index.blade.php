@extends('adminlte::page')

@section('title')
    {{ $judul }}
@endsection

@section('content_header')
    <h1>{{ $judul }}</h1>
@stop

@section('plugins.Datatables', true)

@php
    $heads = [
        '#',
        'Judul',
        'Slug',
        'Berkas',
        'Tanggal Dibuat',
        'Tanggal Diubah',
        'Aksi',
    ];
    $config = [
    'order' => [[0, 'asc']],
    'columns' => [null, null, null, null, null, null, ['orderable' => false, 'className' => 'text-center']],
    ];
@endphp

@section('content')
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                Tabel
            </h3>
        </div>
        <!-- /.card-header -->
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
            <x-adminlte-datatable id="table" :config="$config" :heads="$heads" hoverable bordered beautify>
                @foreach($data as $li)
                    <tr>
                        <td>{!! $loop->iteration !!}</td>
                        <td>{!! $li->title !!}</td>
                        <td>{!! $li->slug !!}</td>
                        <td>
                            @if (isset($li->file))
                                <div class="btn-group btn-group-sm" role="group">
                                    <a type="button" class="btn btn-sm btn-secondary"
                                       href="/files/{{ $li->file }}" target="_blank">
                                        Lihat
                                    </a>
                                    <a type="button" class="btn btn-sm btn-secondary"
                                       href="{{ Request::url() }}/hapus-berkas/{{$li->id}}"
                                       onclick="return confirm('Yakin Mau Dihapus?');">
                                        Hapus
                                    </a>
                                </div>
                            @else
                                Tidak Ada Berkas
                            @endif
                        </td>
                        <td>{!! $li->created_at !!}</td>
                        <td>{!! $li->updated_at !!}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a type="button" class="btn btn-secondary"
                                   href="{{ route('get.admin.berita.edit', $li->id) }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a type="button" class="btn btn-secondary"
                                   href="{{ route('get.admin.berita.hapus', $li->id) }}"
                                   onclick="return confirm('Yakin Mau Dihapus?');">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
        <!-- /.card-body -->
    </div>
@endsection

@section('css')
@stop

@section('js')
@stop
