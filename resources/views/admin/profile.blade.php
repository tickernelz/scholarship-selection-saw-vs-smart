@extends('adminlte::page')

@section('title')
    {{ $judul }}
@endsection

@section('content_header')
    <h1>{{ $judul }}</h1>
@stop

@section('content')
    <form action="{{ route('post.admin.profile.update', $user->id) }}" method="POST">
        <div class="row">
            @csrf
            <div class="col-xl-6">
                <x-adminlte-card title="Basic" icon="fas fa-lg fa-id-card">
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
                    <x-adminlte-input name="name" label="{{ trans('auth.nama') }}"
                                      placeholder="{{ trans('auth.nama') }}" value="{{ $user->name }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-user text-lightblue"></i>
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
                    <x-adminlte-input name="password_confirmation" type="password"
                                      label="{{ trans('auth.konfirmasi_password') }}"
                                      placeholder="{{ trans('auth.konfirmasi_password') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-key text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-button class="btn-primary" type="submit" label="{{ trans('auth.simpan') }}"
                                       theme="success"
                                       icon="fas fa-lg fa-save"/>
                </x-adminlte-card>
            </div>
            @if ($user->mahasiswa)
                <div class="col-xl-6">
                    <x-adminlte-card title="Data Mahasiswa" icon="fas fa-lg fa-id-card">
                        <x-adminlte-callout theme="info" class="bg-gradient-info" title="Informasi">
                            Jika ingin mengganti data mahasiswa, silahkan hubungi admin.
                        </x-adminlte-callout>
                        <x-adminlte-input name="nim" label="{{ trans('auth.nim') }}"
                                          placeholder="{{ trans('auth.nim') }}" value="{{ $user->mahasiswa->nim }}"
                                          disabled>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-id-card text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="prodi" label="{{ trans('auth.prodi') }}"
                                          placeholder="{{ trans('auth.prodi') }}" value="{{ $user->mahasiswa->prodi }}"
                                          disabled>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-id-card-alt text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="jurusan" label="{{ trans('auth.jurusan') }}"
                                          placeholder="{{ trans('auth.jurusan') }}"
                                          value="{{ $user->mahasiswa->jurusan }}" disabled>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-id-badge text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </x-adminlte-card>
                </div>
            @endif
        </div>
    </form>
@endsection

@section('css')
@stop

@section('js')
@stop
