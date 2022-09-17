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
            <form action="{{ route('post.admin.profile.update', $user->id) }}" method="POST">
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
                <x-adminlte-input name="name" label="{{ trans('auth.nama') }}"
                                  placeholder="{{ trans('auth.nama') }}" value="{{ $user->name }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-user text-green"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="email" type="email" label="{{ trans('auth.text_email') }}"
                                  placeholder="{{ trans('auth.text_email') }}" value="{{ $user->email }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-mail-bulk text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="password" type="password" label="{{ trans('auth.text_password') }}"
                                  placeholder="{{ trans('auth.text_password') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-key text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="password_confirmation" type="password" label="{{ trans('auth.konfirmasi_password') }}"
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
