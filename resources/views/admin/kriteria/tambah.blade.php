@extends('adminlte::page')

@section('title')
    {{ $judul }}
@endsection

@section('content_header')
    <h1>{{ $judul }}</h1>
@stop

@section('plugins.Datatables', true)
@section('plugins.BootstrapSwitch', true)

@php
    $heads = [
        'Nama',
        'Prioritas',
        'Aksi',
    ];
    $config = [
    'order' => [[1, 'asc']],
    'columns' => [null, null, ['orderable' => false, 'className' => 'text-center']],
    ];
    $config_switch = [
        'onSwitchChange' => 'function(event, state) {
            var id = $(this).data("id");
            var url = $(this).data("url");
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}",
                },
                success: function (data) {
                    if (data.status == "success") {
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function (data) {
                    toastr.error(data.message);
                }
            });
        }',
]
@endphp

@section('content')
    <div class="col-xl-12" style="float:none;margin:auto;">
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">{{ trans('auth.form_tambah') }}</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <a href="{{ redirect()->getUrlGenerator()->route('get.admin.kriteria.index') }}">
                            <button type="button" class="btn btn-primary">{{ trans('auth.kembali') }}</button>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('post.admin.kriteria.tambah') }}" method="post">
                @csrf
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
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-ban"></i> Error!</h5>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <x-adminlte-input name="nama_kriteria" label="Nama Kriteria"
                                      value="{{ $kriteria['nama_kriteria'] ?? '' }}"/>
                    <x-adminlte-select name="tipe_kriteria" label="Tipe Kriteria">
                        <x-adminlte-options :options="$tipe" :selected="$selected"
                                            placeholder="Pilih Kriteria..."/>
                    </x-adminlte-select>
                    <x-adminlte-input name="bobot_kriteria" label="Bobot Kriteria" type="number"
                                      value="{{ $kriteria['bobot_kriteria'] ?? '' }}"/>
                    <input id="is_berkas" name="is_berkas" value="{{ $kriteria['is_berkas'] ?? '' }}" hidden/>
                    <x-adminlte-input-switch id="is_berkas_switch" name="is_berkas_switch" label="Perlu Berkas">
                    </x-adminlte-input-switch>
                    <x-adminlte-modal id="modal-subkriteria" title="Tambah Sub Kriteria" size="lg" theme="primary"
                                      icon="fas fa-lg fa-fw fa-plus" v-centered static-backdrop scrollable>
                        <x-adminlte-input name="nama_subkriteria" label="Nama Sub Kriteria"/>
                        <x-adminlte-input name="prioritas_subkriteria" label="Prioritas Sub Kriteria" type="number"/>
                        <x-slot name="footerSlot">
                            <x-adminlte-button theme="danger" label="Close" data-dismiss="modal"/>
                            <x-adminlte-button class="ml-auto" type="submit" label="Submit" name="action"
                                               value="is_subkriteria" theme="success"
                                               icon="fas fa-lg fa-save"/>
                        </x-slot>
                    </x-adminlte-modal>
                    <x-adminlte-modal id="edit-subkriteria"
                                      title="Edit Sub Kriteria"
                                      size="lg" theme="primary" icon="fas fa-lg fa-fw fa-plus" v-centered
                                      static-backdrop scrollable>
                        <x-adminlte-input name="edit_id"
                                          value="" type="number" hidden/>
                        <x-adminlte-input name="edit_nama_subkriteria" label="Nama Sub Kriteria"
                                          value=""/>
                        <x-adminlte-input name="edit_prioritas_subkriteria"
                                          label="Prioritas Sub Kriteria"
                                          type="number"
                                          value=""/>
                        <x-slot name="footerSlot">
                            <x-adminlte-button theme="danger" label="Close" data-dismiss="modal"/>
                            <x-adminlte-button class="ml-auto" type="submit" label="Submit" name="action"
                                               value="edit_subkriteria" theme="success"
                                               icon="fas fa-lg fa-save"/>
                        </x-slot>
                    </x-adminlte-modal>
                    <button type="button" class="btn btn-secondary mb-3" data-toggle="modal"
                            data-target="#modal-subkriteria">
                        Tambah Sub Kriteria
                    </button>
                    <x-adminlte-datatable id="table" :config="$config" :heads="$heads" hoverable bordered beautify>
                        @foreach($subkriteria as $li)
                            <tr>
                                <td>{!! $li['nama_subkriteria'] ?? '' !!}</td>
                                <td>{!! $li['prioritas_subkriteria'] ?? '' !!}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-primary btn-sm passingID"
                                                data-id="{{ $li['id'] ?? '' }}">
                                            Edit
                                        </button>
                                        <a type="button" class="btn btn-secondary"
                                           href="{{ route('get.admin.kriteria.sub.hapus', $li['id'] ?? '') }}"
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

                <div class="card-footer">
                    <button type="submit" name="action" value="save"
                            class="btn btn-primary">{{ trans('auth.simpan') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
@stop

@section('js')
    <script type="text/javascript">
        $(".passingID").click(function () {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('get.admin.kriteria.subkriteria') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function (data) {
                    $('#edit_id').val(data.id);
                    $('#edit_nama_subkriteria').val(data.nama_subkriteria);
                    $('#edit_prioritas_subkriteria').val(data.prioritas_subkriteria);
                    $('#edit-subkriteria').modal('show');
                }
            });
        });
        $('#is_berkas_switch').bootstrapSwitch({
            onText: 'Ya',
            offText: 'Tidak',
            onColor: 'success',
            offColor: 'danger',
            size: 'small',
            state: $('#is_berkas').val() == 1 ? true : false,
            onSwitchChange: function (event, state) {
                if (state) {
                    $('#is_berkas').val(1);
                } else {
                    $('#is_berkas').val(0);
                }
            }
        });
    </script>
@stop
