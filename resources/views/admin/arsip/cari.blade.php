@extends('adminlte::page')

@section('title')
    {{ $judul }}
@endsection

@section('content_header')
    <h1>{{ $judul }}</h1>
@stop

@section('plugins.Select2', true)

@section('content')
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                Cari Data
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
            <form
                @if ($route_now == 'get.admin.arsip.beasiswa.saw') action="{{ route('get.admin.arsip.beasiswa.saw') }}"
                @else action="{{ route('get.admin.arsip.beasiswa.smart') }}" @endif method="GET">
                @csrf
                <div class="form-group text-center">
                    <x-adminlte-select2 name="tahun_akademik_id" igroup-size="lg"
                                        data-placeholder="Cari Tahun Akademik...">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-danger">
                                <i class="fas fa-search"></i>
                            </div>
                        </x-slot>
                        <x-slot name="appendSlot">
                            <x-adminlte-button type="submit" theme="outline-danger" label="Go!"/>
                        </x-slot>
                        <option/>
                        @foreach($data as $li)
                            <option value="{{ $li->id }}">{{ $li->tahun_awal }} / {{ $li->tahun_akhir }}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
@endsection

@section('css')
@stop

@section('js')
@stop
