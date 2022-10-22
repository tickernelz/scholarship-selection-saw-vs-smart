@extends('adminlte::page')

@section('title')
    {{ $judul }}
@endsection

@section('content_header')
    <h1>{{ $judul }}</h1>
@stop

@section('content')
    <div class="col-xl-12" style="float:none;margin:auto;">
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Detail Berkas Perhitungan</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <a href="{{ redirect()->getUrlGenerator()->route('get.admin.beasiswa.saw') }}">
                            <button type="button" class="btn btn-primary">{{ trans('auth.kembali') }}</button>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
                <x-adminlte-card title="Biodata" theme="info" icon="fas fa-lg fa-user" collapsible>
                    <x-adminlte-input name="nim_disabled" label="{{ trans('auth.nim') }}"
                                      placeholder="{{ trans('auth.nim') }}" value="{{ $mahasiswa->nim }}"
                                      disabled>
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-id-card text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="studi_disabled" label="{{ trans('auth.studi') }}"
                                      placeholder="{{ trans('auth.studi') }}" value="{{ $mahasiswa->studi }}"
                                      disabled>
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-id-card-alt text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="fakultas_disabled" label="{{ trans('auth.fakultas') }}"
                                      placeholder="{{ trans('auth.fakultas') }}"
                                      value="{{ $mahasiswa->fakultas }}" disabled>
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-id-badge text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="name_disabled" label="{{ trans('auth.nama') }}"
                                      placeholder="{{ trans('auth.nama') }}" value="{{ $mahasiswa->user->name }}"
                                      disabled>
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-user text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="semester_disabled" label="{{ trans('auth.semester') }}"
                                      placeholder="{{ trans('auth.semester') }}"
                                      value="{{ $mahasiswa->semester }}" type="number" disabled>
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-hourglass-half text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="ukt_disabled" label="{{ trans('auth.ukt') }}"
                                      placeholder="{{ trans('auth.ukt') }}"
                                      value="{{$mahasiswa->ukt }}" type="number" disabled>
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-money-bill text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </x-adminlte-card>
                <x-adminlte-card title="Skor Mahasiswa" theme="info" icon="fas fa-lg fa-chart-bar" collapsible>
                    @if ($is_saw == true && $is_smart == false)
                        <x-adminlte-alert theme="success" title="Nilai Skor">
                            Nilai skor adalah {{ round($mahasiswa->skor->skor_saw, 4) }} dari skala 0 - 1 dengan
                            perhitungan SAW
                        </x-adminlte-alert>
                    @else
                        <x-adminlte-alert theme="success" title="Nilai Skor">
                            Nilai skor adalah {{ round($mahasiswa->skor->skor_smart, 4) }} dari skala 0 - 1 dengan
                            perhitungan SMART
                        </x-adminlte-alert>
                    @endif
                </x-adminlte-card>
                <x-adminlte-card title="Pertanyaan" theme="info" icon="fas fa-lg fa-question" collapsible>
                    @foreach($kriteria as $k)
                        <div class="row">
                            <div class="col-lg-8 mb-4">
                                <span class="text-bold">{{ $k->nama }}</span>
                                <input type="hidden" name="kriteria[]" value="{{ $k->id }}">
                                {{--Radio Option Subkriteria--}}
                                @foreach($k->subkriteria as $s => $sub)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                               name="subkriteria[{{ $k->id }}]_disabled"
                                               id="{{ $sub->id }}"
                                               value="{{ $sub->id }}" required disabled
                                               @if ($beasiswa->where('kriteria_id', $k->id)->where('subkriteria_id', $sub->id)->first())
                                                   checked
                                            @endif>
                                        <label class="form-check-label" for="{{ $sub->id }}">
                                            {{ $sub->nama }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-lg-4">
                                @if ($berkas->where('kriteria_id', $k->id)->first())
                                    <div class="form-group">
                                        <x-adminlte-modal id="modal-file-{{$k->id}}" title="Lihat File" size="lg">
                                            <embed
                                                src="{{ route('get.beasiswa.readfile', $berkas->where('kriteria_id', $k->id)->first()->id) }}"
                                                frameborder="0" width="100%" height="600px"
                                                type="application/pdf">
                                        </x-adminlte-modal>
                                        <x-adminlte-input-file name="berkas[{{ $k->id }}]" label="File Bukti"
                                                               placeholder="{{ $berkas->where('kriteria_id', $k->id)->first()->file }}"
                                                               disabled/>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-secondary" data-toggle="modal"
                                                    data-target="#modal-file-{{$k->id}}">
                                                Lihat File
                                            </button>
                                            <a type="button" class="btn btn-primary"
                                               href="{{ route('get.beasiswa.download', $berkas->where('kriteria_id', $k->id)->first()->id) }}">
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group">
                                        <x-adminlte-input-file name="berkas[{{ $k->id }}]" label="File Bukti"
                                                               placeholder="Tidak Ada File..." disabled/>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr>

                    @endforeach

                </x-adminlte-card>
            </div>
            <form action="{{ route('post.admin.beasiswa.terima') }}" method="post">
                @csrf
                <x-adminlte-modal id="modal-terima" title="Terima Penurunan UKT" size="lg" theme="primary"
                                  icon="fas fa-lg fa-fw fa-plus" v-centered static-backdrop scrollable>
                    <x-adminlte-input name="id_mahasiswa_terima" value="" hidden/>
                    <x-adminlte-input name="ukt_awal" label="Nominal UKT Awal" type="number" disabled/>
                    <x-adminlte-input name="ukt" label="Nominal UKT Penurunan" type="number"/>
                    <x-slot name="footerSlot">
                        <x-adminlte-button theme="danger" label="Close" data-dismiss="modal"/>
                        <x-adminlte-button class="ml-auto" type="submit" label="Submit" name="action"
                                           value="terima" theme="success"
                                           icon="fas fa-lg fa-save"/>
                    </x-slot>
                </x-adminlte-modal>
            </form>
            <div class="card-footer">
                @if($mahasiswa->is_beasiswa_send == 1 && $mahasiswa->is_beasiswa_approved == 1 && $mahasiswa->is_beasiswa_declined == 0)
                    <x-adminlte-alert theme="success" title="Diterima">
                        Penurunan UKT telah diterima.
                    </x-adminlte-alert>
                @elseif($mahasiswa->is_beasiswa_send == 0 && $mahasiswa->is_beasiswa_approved == 0 && $mahasiswa->is_beasiswa_declined == 1)
                    <x-adminlte-alert theme="danger" title="Ditolak">
                        Penurunan UKT telah ditolak.
                    </x-adminlte-alert>
                @else
                    <div class="btn-group btn-group" role="group">
                        <button type="button" class="btn btn-primary terima" data-id="{{ $mahasiswa->id ?? '' }}">
                            Terima
                        </button>
                        <button type="button" class="btn btn-danger tolak"
                                data-id="{{ $mahasiswa->id ?? '' }}">
                            Tolak
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('css')
@stop

@section('js')
    <script type="text/javascript">
        $(".terima").click(function () {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('get.admin.beasiswa.ajax_modal') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function (data) {
                    $('#id_mahasiswa_terima').val(data.id);
                    $('#ukt').val(data.ukt);
                    $('#ukt_awal').val(data.ukt_awal);
                    $('#modal-terima').modal('show');
                }
            });
        });
        $(".tolak").click(function () {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('get.admin.beasiswa.ajax_modal') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function (data) {
                    $('#id_mahasiswa_tolak').val(data.id);
                    $('#modal-tolak').modal('show');
                }
            });
        });
    </script>

@stop
