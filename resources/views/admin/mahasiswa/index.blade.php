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
        'NIM',
        'Nama',
        'Email',
        'Jenis Kelamin',
        'Studi',
        'Fakultas',
        'Angkatan',
        'Semester',
        'UKT',
        'TTL',
        'Telepon',
        'KTM',
        'Aksi',
    ];
    $config = [
    'order' => [[0, 'asc']],
    'columns' => [null, null, null, null, null, null, null, null, null, null, null, null, null, ['orderable' => false, 'className' => 'text-center']],
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
{{--            <div>--}}
{{--                Toggle column: <a class="toggle-vis" data-column="0">Nomor</a> - <a class="toggle-vis" data-column="1">NIM</a>--}}
{{--                - <a class="toggle-vis" data-column="2">Nama</a> - <a class="toggle-vis" data-column="3">Email</a> - <a--}}
{{--                    class="toggle-vis" data-column="4">Jenis Kelamin</a> - <a class="toggle-vis"--}}
{{--                                                                              data-column="5">Studi</a> - <a--}}
{{--                    class="toggle-vis" data-column="6">Fakultas</a>--}}
{{--            </div>--}}
            <x-adminlte-datatable id="table" :config="$config" :heads="$heads" {{--with-footer--}} hoverable bordered beautify>
                @foreach($data as $li)
                    <tr>
                        <td>{!! $loop->iteration !!}</td>
                        <td>{!! $li->nim !!}</td>
                        <td>{!! $li->user->name !!}</td>
                        <td>{!! $li->user->email !!}</td>
                        <td>{!! $li->jenis_kelamin !!}</td>
                        <td>{!! $li->studi !!}</td>
                        <td>{!! $li->fakultas !!}</td>
                        <td>{!! $li->angkatan !!}</td>
                        <td>{!! $li->semester !!}</td>
                        <td>{!! $li->ukt() !!}</td>
                        <td>{!! $li->ttl !!}</td>
                        <td>{!! $li->telepon !!}</td>
                        <td>
                            @if (isset($li->ktm))
                                <a type="button" class="btn btn-sm btn-primary"
                                   href="/ktm/{{ $li->ktm }}" target="_blank">
                                    Lihat
                                </a>
                            @else
                                Tidak Ada Berkas
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a type="button" class="btn btn-secondary"
                                   href="{{ route('get.admin.mahasiswa.edit.index', [$li->id, $route],) }}">
                                    Edit
                                </a>
                                <a type="button" class="btn btn-secondary"
                                   href="{{ route('get.admin.mahasiswa.verifikasi.reject', $li->id) }}"
                                   onclick="return confirm('Yakin Ingin Kirim Email?');">
                                    Kirim Email
                                </a>
                                <a type="button" class="btn btn-danger"
                                   href="{{ route('get.admin.mahasiswa.hapus', $li->id) }}"
                                   onclick="return confirm('Yakin Mau Dihapus?');">
                                    Hapus
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
{{--    <script>--}}
{{--        // Filter Column With Select--}}
{{--        $(document).ready(function () {--}}
{{--            $('#table tfoot th').each(function () {--}}
{{--                var title = $(this).text();--}}
{{--                $(this).html('<input type="text" placeholder="Search ' + title + '" />');--}}
{{--            });--}}
{{--            var table = $('#table').DataTable();--}}
{{--            table.columns().every(function () {--}}
{{--                var that = this;--}}
{{--                $('input', this.footer()).on('keyup change', function () {--}}
{{--                    if (that.search() !== this.value) {--}}
{{--                        that.search(this.value).draw();--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            var table = $('#table').DataTable();--}}

{{--            $('a.toggle-vis').on('click', function (e) {--}}
{{--                e.preventDefault();--}}

{{--                // Get the column API object--}}
{{--                var column = table.column($(this).attr('data-column'));--}}

{{--                // Toggle the visibility--}}
{{--                column.visible(!column.visible());--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
@stop
