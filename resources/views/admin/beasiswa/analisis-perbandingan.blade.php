@extends('adminlte::page')

@section('title')
    {{ $judul }}
@endsection

@section('content_header')
    <h1>{{ $judul }}</h1>
@stop

@section('plugins.Datatables', true)

@php
    $heads_real = [
        'NIM',
        'Nama',
        'Angkatan',
        'Semester',
        'Skor SAW',
        'Skor SMART',
        'Skor REAL',
    ];
    $config_real = [
    'order' => [[0, 'asc']],
    'columns' => [null, null, null, null, null, null, null],
    ];
@endphp

@section('content')
    <x-adminlte-card title="Grafik">
        <canvas id="grafik"></canvas>
    </x-adminlte-card>

    <x-adminlte-card title="Input Data Real" collapsible="collapsed">
        <form action="{{ route('post.admin.mahasiswa.skor_real') }}" enctype="multipart/form-data" method="post"
              id="form_real">
            @csrf
            <x-adminlte-datatable id="table_real" :config="$config_real" :heads="$heads_real" hoverable bordered
                                  beautify>
                @foreach($data_grafik as $li)
                    <tr>
                        <td>{!! $li['nim'] !!}</td>
                        <td>{!! $li['nama'] !!}</td>
                        <td>{!! $li['angkatan'] !!}</td>
                        <td>{!! $li['semester'] !!}</td>
                        <td>{!! round($li['skor_saw'], 4) !!}</td>
                        <td>{!! round($li['skor_smart'], 4) !!}</td>
                        <td>
                            <x-adminlte-input name="skor_real[{!! $li['id'] !!}]" type="number" min="0" max="1"
                                              step="0.0001"
                                              value="{!! round($li['skor_real'], 4) !!}"/>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </x-adminlte-card>

    <x-adminlte-card title="Confusion Matrix" collapsible="collapsed">
        <div class="mb-3">
            <span class="text-bold">Skor Threshold: </span>
            <span class="text-bold text-danger">{!! $threshold !!}</span>
        </div>
        <div class="mb-3"><span class="text-bold">Data Real:</span></div>
        <table class="table table-bordered table-responsive-sm text-center">
            <thead>
            <tr>
                <th>Nama</th>
                <th>Skor</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data_grafik as $li)
                <tr>
                    <td>{!! $li['nama'] !!}</td>
                    <td>{!! round($li['skor_real'], 4) !!}</td>
                    <td>
                        @if($li['is_lulus_real'] == true)
                            <span class="text-bold text-success">Lulus</span>
                        @else
                            <span class="text-bold text-danger">Tidak Lulus</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mb-3 mt-3"><span class="text-bold">Data SAW:</span></div>
        <table class="table table-bordered table-responsive-sm text-center">
            <thead>
            <tr>
                <th>Nama</th>
                <th>Skor</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data_grafik as $li)
                <tr>
                    <td>{!! $li['nama'] !!}</td>
                    <td>{!! round($li['skor_saw'], 4) !!}</td>
                    <td>
                        @if($li['is_lulus_saw'] == true)
                            <span class="text-bold text-success">Lulus</span>
                        @else
                            <span class="text-bold text-danger">Tidak Lulus</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mb-3 mt-3"><span class="text-bold">Data SMART:</span></div>
        <table class="table table-bordered table-responsive-sm text-center">
            <thead>
            <tr>
                <th>Nama</th>
                <th>Skor</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data_grafik as $li)
                <tr>
                    <td>{!! $li['nama'] !!}</td>
                    <td>{!! round($li['skor_smart'], 4) !!}</td>
                    <td>
                        @if($li['is_lulus_smart'] == true)
                            <span class="text-bold text-success">Lulus</span>
                        @else
                            <span class="text-bold text-danger">Tidak Lulus</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mb-3 mt-3"><span class="text-bold">Confusion Matrix SAW:</span></div>
        <table class="table table-bordered table-responsive-sm text-center">
            <thead>
            <tr>
                <th></th>
                <th>Positif (Prediksi)</th>
                <th>Negatif (Prediksi)</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Positif (Aktual)</td>
                <td>{!! $confusion_matrix_saw['TP'] !!}</td>
                <td>{!! $confusion_matrix_saw['FN'] !!}</td>
            </tr>
            <tr>
                <td>Negatif (Aktual)</td>
                <td>{!! $confusion_matrix_saw['FP'] !!}</td>
                <td>{!! $confusion_matrix_saw['TN'] !!}</td>
            </tr>
            </tbody>
        </table>
        <div class="mb-3 mt-3"><span class="text-bold">Confusion Matrix SMART:</span></div>
        <table class="table table-bordered table-responsive-sm text-center">
            <thead>
            <tr>
                <th></th>
                <th>Positif (Prediksi)</th>
                <th>Negatif (Prediksi)</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Positif (Aktual)</td>
                <td>{!! $confusion_matrix_smart['TP'] !!}</td>
                <td>{!! $confusion_matrix_smart['FN'] !!}</td>
            </tr>
            <tr>
                <td>Negatif (Aktual)</td>
                <td>{!! $confusion_matrix_smart['FP'] !!}</td>
                <td>{!! $confusion_matrix_smart['TN'] !!}</td>
            </tr>
        </table>
        <!-- Perhitungan Akurasi MathJax -->
        <div class="mb-3 mt-3"><span class="text-bold">Akurasi SAW:</span></div>
        <math mode="display" xmlns="http://www.w3.org/1998/Math/MathML">
            <mfrac>
                <mrow>
                    <mi>TP</mi>
                    <mo>+</mo>
                    <mi>TN</mi>
                </mrow>
                <mrow>
                    <mi>TP</mi>
                    <mo>+</mo>
                    <mi>TN</mi>
                    <mo>+</mo>
                    <mi>FP</mi>
                    <mo>+</mo>
                    <mi>FN</mi>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mfrac>
                <mrow>
                    <mn>{!! $confusion_matrix_saw['TP'] !!}</mn>
                    <mo>+</mo>
                    <mn>{!! $confusion_matrix_saw['TN'] !!}</mn>
                </mrow>
                <mrow>
                    <mn>{!! $confusion_matrix_saw['TP'] !!}</mn>
                    <mo>+</mo>
                    <mn>{!! $confusion_matrix_saw['TN'] !!}</mn>
                    <mo>+</mo>
                    <mn>{!! $confusion_matrix_saw['FP'] !!}</mn>
                    <mo>+</mo>
                    <mn>{!! $confusion_matrix_saw['FN'] !!}</mn>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mfrac>
                <mrow>
                    <mn>{!! $confusion_matrix_saw['TP'] + $confusion_matrix_saw['TN'] !!}</mn>
                </mrow>
                <mrow>
                    <mn>{!! $confusion_matrix_saw['TP'] + $confusion_matrix_saw['TN'] + $confusion_matrix_saw['FP'] + $confusion_matrix_saw['FN'] !!}</mn>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mn>{!! $confusion_matrix_saw['akurasi'] !!}</mn>
        </math>
        <div class="mb-3 mt-3"><span class="text-bold">Akurasi SMART:</span></div>
        <math mode="display" xmlns="http://www.w3.org/1998/Math/MathML">
            <mfrac>
                <mrow>
                    <mi>TP</mi>
                    <mo>+</mo>
                    <mi>TN</mi>
                </mrow>
                <mrow>
                    <mi>TP</mi>
                    <mo>+</mo>
                    <mi>TN</mi>
                    <mo>+</mo>
                    <mi>FP</mi>
                    <mo>+</mo>
                    <mi>FN</mi>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mfrac>
                <mrow>
                    <mn>{!! $confusion_matrix_smart['TP'] !!}</mn>
                    <mo>+</mo>
                    <mn>{!! $confusion_matrix_smart['TN'] !!}</mn>
                </mrow>
                <mrow>
                    <mn>{!! $confusion_matrix_smart['TP'] !!}</mn>
                    <mo>+</mo>
                    <mn>{!! $confusion_matrix_smart['TN'] !!}</mn>
                    <mo>+</mo>
                    <mn>{!! $confusion_matrix_smart['FP'] !!}</mn>
                    <mo>+</mo>
                    <mn>{!! $confusion_matrix_smart['FN'] !!}</mn>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mfrac>
                <mrow>
                    <mn>{!! $confusion_matrix_smart['TP'] + $confusion_matrix_smart['TN'] !!}</mn>
                </mrow>
                <mrow>
                    <mn>{!! $confusion_matrix_smart['TP'] + $confusion_matrix_smart['TN'] + $confusion_matrix_smart['FP'] + $confusion_matrix_smart['FN'] !!}</mn>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mn>{!! $confusion_matrix_smart['akurasi'] !!}</mn>
        </math>
        <!-- Perhitungan Presisi MathJax -->
        <div class="mb-3 mt-3"><span class="text-bold">Presisi SAW:</span></div>
        <math mode="display" xmlns="http://www.w3.org/1998/Math/MathML">
            <mfrac>
                <mrow>
                    <mi>TP</mi>
                </mrow>
                <mrow>
                    <mi>TP</mi>
                    <mo>+</mo>
                    <mi>FP</mi>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mfrac>
                <mrow>
                    <mn>{!! $confusion_matrix_saw['TP'] !!}</mn>
                </mrow>
                <mrow>
                    <mn>{!! $confusion_matrix_saw['TP'] !!}</mn>
                    <mo>+</mo>
                    <mn>{!! $confusion_matrix_saw['FP'] !!}</mn>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mfrac>
                <mrow>
                    <mn>{!! $confusion_matrix_saw['TP'] !!}</mn>
                </mrow>
                <mrow>
                    <mn>{!! $confusion_matrix_saw['TP'] + $confusion_matrix_saw['FP'] !!}</mn>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mn>{!! $confusion_matrix_saw['presisi'] !!}</mn>
        </math>
        <div class="mb-3 mt-3"><span class="text-bold">Presisi SMART:</span></div>
        <math mode="display" xmlns="http://www.w3.org/1998/Math/MathML">
            <mfrac>
                <mrow>
                    <mi>TP</mi>
                </mrow>
                <mrow>
                    <mi>TP</mi>
                    <mo>+</mo>
                    <mi>FP</mi>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mfrac>
                <mrow>
                    <mn>{!! $confusion_matrix_smart['TP'] !!}</mn>
                </mrow>
                <mrow>
                    <mn>{!! $confusion_matrix_smart['TP'] !!}</mn>
                    <mo>+</mo>
                    <mn>{!! $confusion_matrix_smart['FP'] !!}</mn>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mfrac>
                <mrow>
                    <mn>{!! $confusion_matrix_smart['TP'] !!}</mn>
                </mrow>
                <mrow>
                    <mn>{!! $confusion_matrix_smart['TP'] + $confusion_matrix_smart['FP'] !!}</mn>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mn>{!! $confusion_matrix_smart['presisi'] !!}</mn>
        </math>
        <!-- Perhitungan Recall MathJax -->
        <div class="mb-3 mt-3"><span class="text-bold">Recall SAW:</span></div>
        <math mode="display" xmlns="http://www.w3.org/1998/Math/MathML">
            <mfrac>
                <mrow>
                    <mi>TP</mi>
                </mrow>
                <mrow>
                    <mi>TP</mi>
                    <mo>+</mo>
                    <mi>FN</mi>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mfrac>
                <mrow>
                    <mn>{!! $confusion_matrix_saw['TP'] !!}</mn>
                </mrow>
                <mrow>
                    <mn>{!! $confusion_matrix_saw['TP'] !!}</mn>
                    <mo>+</mo>
                    <mn>{!! $confusion_matrix_saw['FN'] !!}</mn>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mfrac>
                <mrow>
                    <mn>{!! $confusion_matrix_saw['TP'] !!}</mn>
                </mrow>
                <mrow>
                    <mn>{!! $confusion_matrix_saw['TP'] + $confusion_matrix_saw['FN'] !!}</mn>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mn>{!! $confusion_matrix_saw['recall'] !!}</mn>
        </math>
        <div class="mb-3 mt-3"><span class="text-bold">Recall SMART:</span></div>
        <math mode="display" xmlns="http://www.w3.org/1998/Math/MathML">
            <mfrac>
                <mrow>
                    <mi>TP</mi>
                </mrow>
                <mrow>
                    <mi>TP</mi>
                    <mo>+</mo>
                    <mi>FN</mi>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mfrac>
                <mrow>
                    <mn>{!! $confusion_matrix_smart['TP'] !!}</mn>
                </mrow>
                <mrow>
                    <mn>{!! $confusion_matrix_smart['TP'] !!}</mn>
                    <mo>+</mo>
                    <mn>{!! $confusion_matrix_smart['FN'] !!}</mn>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mfrac>
                <mrow>
                    <mn>{!! $confusion_matrix_smart['TP'] !!}</mn>
                </mrow>
                <mrow>
                    <mn>{!! $confusion_matrix_smart['TP'] + $confusion_matrix_smart['FN'] !!}</mn>
                </mrow>
            </mfrac>
            <mo>=</mo>
            <mn>{!! $confusion_matrix_smart['recall'] !!}</mn>
        </math>
        <!-- Kesimpulan -->
        <div class="mb-3 mt-3"><span class="text-bold">Kesimpulan:</span></div>
        <div class="mb-3">
            <p>Metode SAW memiliki nilai akurasi sebesar {!! $confusion_matrix_saw['akurasi'] !!}, sedangkan metode
                SMART memiliki nilai akurasi sebesar {!! $confusion_matrix_smart['akurasi'] !!}.</p>
            <p>Metode SAW memiliki nilai presisi sebesar {!! $confusion_matrix_saw['presisi'] !!}, sedangkan metode
                SMART memiliki nilai presisi sebesar {!! $confusion_matrix_smart['presisi'] !!}.</p>
            <p>Metode SAW memiliki nilai recall sebesar {!! $confusion_matrix_saw['recall'] !!}, sedangkan metode SMART
                memiliki nilai recall sebesar {!! $confusion_matrix_smart['recall'] !!}.</p>
            @if ($confusion_matrix_saw['akurasi'] > $confusion_matrix_smart['akurasi'])
                <p>Metode SAW memiliki nilai akurasi yang lebih tinggi dibandingkan metode SMART.</p>
            @elseif ($confusion_matrix_saw['akurasi'] < $confusion_matrix_smart['akurasi'])
                <p>Metode SMART memiliki nilai akurasi yang lebih tinggi dibandingkan metode SAW.</p>
            @else
                <p>Metode SAW dan metode SMART memiliki nilai akurasi yang sama.</p>
            @endif
            @if ($confusion_matrix_saw['presisi'] > $confusion_matrix_smart['presisi'])
                <p>Metode SAW memiliki nilai presisi yang lebih tinggi dibandingkan metode SMART.</p>
            @elseif ($confusion_matrix_saw['presisi'] < $confusion_matrix_smart['presisi'])
                <p>Metode SMART memiliki nilai presisi yang lebih tinggi dibandingkan metode SAW.</p>
            @else
                <p>Metode SAW dan metode SMART memiliki nilai presisi yang sama.</p>
            @endif
            @if ($confusion_matrix_saw['recall'] > $confusion_matrix_smart['recall'])
                <p>Metode SAW memiliki nilai recall yang lebih tinggi dibandingkan metode SMART.</p>
            @elseif ($confusion_matrix_saw['recall'] < $confusion_matrix_smart['recall'])
                <p>Metode SMART memiliki nilai recall yang lebih tinggi dibandingkan metode SAW.</p>
            @else
                <p>Metode SAW dan metode SMART memiliki nilai recall yang sama.</p>
            @endif
            <p>Jadi metode yang memiliki nilai akurasi, presisi, dan recall yang lebih tinggi adalah metode
                @if ($confusion_matrix_saw['akurasi'] > $confusion_matrix_smart['akurasi'])
                    SAW.
                @elseif ($confusion_matrix_saw['akurasi'] < $confusion_matrix_smart['akurasi'])
                    SMART.
                @else
                    SAW dan SMART.
                @endif
            </p>
        </div>
    </x-adminlte-card>
@endsection

@section('css')
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#form_real').on('submit', function (evt) {
            evt.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/beasiswa/save/skor_real',
                type: 'POST',
                data: formData,
            }).then(function (data) {
                if (data.status === 'success') {
                    Swal.fire({
                        title: 'Skor Berhasil Disimpan!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function () {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    </script>
    <script>
        var ctx = document.getElementById('grafik').getContext('2d');
        var labels = @json(array_column($data_grafik, 'nama'));
        var skor_saw = @json(array_column($data_grafik, 'skor_saw'));
        var skor_smart = @json(array_column($data_grafik, 'skor_smart'));
        var threshold = {{ $threshold }};
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Skor SAW',
                    data: skor_saw,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                }, {
                    label: 'Skor SMART',
                    data: skor_smart,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            suggestedMax: 1,
                            suggestedMin: 0,
                            stepSize: 0.1,
                            callback: function (value) {
                                if (value === threshold) {
                                    return 'Batas Lulus ({{ $threshold }})';
                                }
                            }
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0.2)",
                            drawTicks: false,
                            drawOnChartArea: false,
                            zeroLineWidth: 2,
                            zeroLineColor: "rgba(0, 0, 0, 0.2)",
                            zeroLineBorderDash: [2],
                            zeroLineBorderDashOffset: [2]
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 20,
                            padding: 20,
                            usePointStyle: true,
                            generateLabels: function (chart) {
                                var data = chart.data;
                                var jumlahLulusSAW = 0;
                                var jumlahTidakLulusSAW = 0;
                                var jumlahLulusSMART = 0;
                                var jumlahTidakLulusSMART = 0;
                                for (var i = 0; i < data.datasets[0].data.length; i++) {
                                    if (data.datasets[0].data[i] >= threshold) {
                                        jumlahLulusSAW++;
                                    } else {
                                        jumlahTidakLulusSAW++;
                                    }
                                }
                                for (var i = 0; i < data.datasets[1].data.length; i++) {
                                    if (data.datasets[1].data[i] >= threshold) {
                                        jumlahLulusSMART++;
                                    } else {
                                        jumlahTidakLulusSMART++;
                                    }
                                }
                                return [{
                                    text: 'Lulus (SAW): ' + jumlahLulusSAW,
                                    fillStyle: 'rgba(255, 99, 132, 1)',
                                }, {
                                    text: 'Tidak Lulus (SAW): ' + jumlahTidakLulusSAW,
                                    fillStyle: 'rgba(255, 99, 132, 1)',
                                }, {
                                    text: 'Lulus (SMART): ' + jumlahLulusSMART,
                                    fillStyle: 'rgba(54, 162, 235, 1)',
                                }, {
                                    text: 'Tidak Lulus (SMART): ' + jumlahTidakLulusSMART,
                                    fillStyle: 'rgba(54, 162, 235, 1)',
                                }];
                            }
                        }
                    }
                }
            }
        });
    </script>
@stop
