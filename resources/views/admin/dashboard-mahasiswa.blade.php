@extends('adminlte::page')

@section('title')
    {{ $judul }}
@endsection

@section('content_header')
    <h1>{{ $judul }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-6">
            <x-adminlte-card title="Basic" icon="fas fa-lg fa-id-card">
                <x-adminlte-input name="name" label="{{ trans('auth.nama') }}"
                                  placeholder="{{ trans('auth.nama') }}" value="{{ $user->name }}" disabled>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-user text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="email" type="email" label="{{ trans('auth.text_email') }}"
                                  placeholder="{{ trans('auth.text_email') }}" value="{{ $user->email }}" disabled>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-mail-bulk text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </x-adminlte-card>
            <x-adminlte-card title="Data Mahasiswa" icon="fas fa-lg fa-id-card">
                <x-adminlte-input name="nim" label="{{ trans('auth.nim') }}"
                                  placeholder="{{ trans('auth.nim') }}" value="{{ $user->mahasiswa->nim }}"
                                  disabled>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-id-card text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="studi" label="{{ trans('auth.studi') }}"
                                  placeholder="{{ trans('auth.studi') }}" value="{{ $user->mahasiswa->studi }}"
                                  disabled>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-id-card-alt text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="fakultas" label="{{ trans('auth.fakultas') }}"
                                  placeholder="{{ trans('auth.fakultas') }}"
                                  value="{{ $user->mahasiswa->fakultas }}" disabled>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-id-badge text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="angkatan" label="{{ trans('auth.angkatan') }}"
                                  placeholder="{{ trans('auth.angkatan') }}"
                                  value="{{ $user->mahasiswa->angkatan }}" disabled>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-calendar-alt text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="jenis_kelamin" label="{{ trans('auth.jenis_kelamin') }}"
                                  placeholder="{{ trans('auth.jenis_kelamin') }}"
                                  value="{{ $user->mahasiswa->jenis_kelamin }}" disabled>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-venus-mars text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="semester" label="{{ trans('auth.semester') }}"
                                  placeholder="{{ trans('auth.semester') }}"
                                  value="{{ $user->mahasiswa->semester }}" type="number" disabled>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-hourglass-half text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="ukt" label="{{ trans('auth.ukt') }}"
                                  placeholder="{{ trans('auth.ukt') }}"
                                  value="{{ $user->mahasiswa->ukt }}" type="number" disabled>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-money-bill text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="ttl" label="{{ trans('auth.tempat_tanggal_lahir') }}"
                                  placeholder="{{ trans('auth.tempat_tanggal_lahir') }}"
                                  value="{{ $user->mahasiswa->ttl }}" disabled>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-birthday-cake text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="telepon" label="{{ trans('auth.nomor_hp') }}"
                                  placeholder="{{ trans('auth.nomor_hp') }}"
                                  value="{{ $user->mahasiswa->telepon }}" type="number" disabled>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-mobile text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </x-adminlte-card>
        </div>
        <div class="col-xl-6">
            <x-adminlte-card title="Status Beasiswa" icon="fas fa-lg fa-award">
                @if ($mahasiswa->is_beasiswa_send == 1 && $mahasiswa->is_beasiswa_approved == 0 && $mahasiswa->is_beasiswa_declined == 0)
                    <x-adminlte-alert theme="info" title="Menunggu">
                        Beasiswa sedang dalam proses verifikasi. Silahkan cek email anda secara berkala.
                    </x-adminlte-alert>
                @elseif($mahasiswa->is_beasiswa_send == 1 && $mahasiswa->is_beasiswa_approved == 1 && $mahasiswa->is_beasiswa_declined == 0)
                    <x-adminlte-alert theme="success" title="Diterima">
                        Beasiswa telah diterima. Dengan ini anda telah mendapatkan UKT menjadi sebesar Rp. {{ number_format($mahasiswa->ukt_penurunan, 0, ',', '.') }}.
                    </x-adminlte-alert>
                @elseif($mahasiswa->is_beasiswa_send == 0 && $mahasiswa->is_beasiswa_approved == 0 && $mahasiswa->is_beasiswa_declined == 1)
                    <x-adminlte-alert theme="danger" title="Ditolak">
                        Beasiswa telah ditolak. Silahkan cek email anda untuk informasi lebih lanjut.
                    </x-adminlte-alert>
                @else
                    <x-adminlte-alert theme="warning" title="Belum Mengajukan">
                        Beasiswa belum diajukan.
                    </x-adminlte-alert>
                @endif
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
