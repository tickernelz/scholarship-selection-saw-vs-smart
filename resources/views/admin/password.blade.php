@extends('adminlte::page')

@section('title')
    {{ $judul }}
@endsection

@section('content_header')
    <h1>{{ $judul }}</h1>
@stop

@section('content')
    <div class="col-xl-6 card" style="padding: 2em">
        <div class="card-body">
            <form action="{{ route('post.admin.password.update', $user->id) }}" method="POST">
                @csrf
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
                    <div class="alert alert-success m-b-16" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger m-b-16" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <x-adminlte-input name="current_password" type="password" label="{{ trans('auth.password_sekarang') }}"
                                  placeholder="{{ trans('auth.password_sekarang') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-key text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="new_password" type="password" label="{{ trans('auth.password_baru') }}"
                                  placeholder="{{ trans('auth.password_baru') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-key text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="confirm_password" type="password" label="{{ trans('auth.konfirmasi_password') }}"
                                  placeholder="{{ trans('auth.konfirmasi_password') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-key text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-button class="btn-primary" type="submit" label="{{ trans('auth.simpan') }}" theme="success"
                                   icon="fas fa-lg fa-save"/>
            </form>
        </div>
    </div>
@endsection

@section('css')
@stop

@section('js')
@stop
