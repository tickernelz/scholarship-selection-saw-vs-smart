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
        'Tanggal',
        'NIM',
        'Nama',
        'Email',
        'Angkatan',
        'Semester',
        'UKT',
        'Telepon',
        'Berkas',
        'Status',
        'Skor',
    ];
    $config = [
    'order' => [[10, 'desc']],
    'dom' => 'Bfrtip',
    'buttons' => [
        ['extend' => 'print', 'exportOptions' => ['columns' => [1, 2, 3, 4, 5, 6, 7, 9, 10]], 'className' => 'btn btn-default btn-sm no-corner', 'text' => '<i class="fa fa-print"></i> Print'],
        ['extend' => 'excel', 'exportOptions' => ['columns' => [1, 2, 3, 4, 5, 6, 7, 9, 10]], 'className' => 'btn btn-success btn-sm no-corner', 'text' => '<i class="fa fa-file-excel"></i> Excel'],
        ['extend' => 'pdf', 'orientation'=> 'landscape', 'exportOptions' => ['columns' => [1, 2, 3, 4, 5, 6, 7, 9, 10]], 'className' => 'btn btn-danger btn-sm no-corner', 'text' => '<i class="fa fa-file-pdf"></i> PDF'],
],
    'columns' => [null, null, null, null, null, null, null, null, null, null, null, ['orderable' => false, 'className' => 'text-center']],
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
            <x-adminlte-datatable id="table" :config="$config" :heads="$heads" hoverable bordered beautify>
                @if ($data !== null)
                    @foreach($data as $li)
                        <tr>
                            <td>{!! $loop->iteration !!}</td>
                            <td>{!! $li->archived_at !!}</td>
                            <td>{!! $li->mahasiswaArchived->nim !!}</td>
                            <td>{!! $li->mahasiswaArchived->userArchived->name !!}</td>
                            <td>{!! $li->mahasiswaArchived->userArchived->email !!}</td>
                            <td>{!! $li->mahasiswaArchived->angkatan !!}</td>
                            <td>{!! $li->mahasiswaArchived->semester !!}</td>
                            <td>{!! $li->mahasiswaArchived->ukt() !!}</td>
                            <td>{!! $li->mahasiswaArchived->telepon !!}</td>
                            <td>
                                @if ($route_now == 'get.admin.arsip.beasiswa.saw')
                                    <a type="button" class="btn btn-sm btn-primary"
                                       href="{{route('get.admin.arsip.beasiswa.detail_saw', $li->mahasiswaArchived->id)}}">
                                        Lihat
                                    </a>
                                @else
                                    <a type="button" class="btn btn-sm btn-primary"
                                       href="{{route('get.admin.arsip.beasiswa.detail_smart', $li->mahasiswaArchived->id)}}">
                                        Lihat
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if ($li->mahasiswaArchived->is_beasiswa_approved == 1)
                                    <span class="badge badge-success">Diterima</span>
                                @else
                                    <span class="badge badge-warning">Menunggu</span>
                                @endif
                            </td>
                            @if (Session::get('is_saw') == 1)
                                <td>{!! round($li->skor_saw, 4) !!}</td>
                            @else
                                <td>{!! round($li->skor_smart, 4) !!}</td>
                            @endif
                        </tr>
                    @endforeach
                @endif
            </x-adminlte-datatable>
        </div>
        <!-- /.card-body -->
    </div>
@endsection

@section('css')
@stop

@section('js')
@stop
