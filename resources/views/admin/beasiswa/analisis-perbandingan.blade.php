@extends('adminlte::page')

@section('title')
    {{ $judul }}
@endsection

@section('content_header')
    <h1>{{ $judul }}</h1>
@stop

@section('content')
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                Grafik
            </h3>
        </div>
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
            <canvas id="grafik"></canvas>
        </div>
        <!-- /.card-body -->
    </div>
@endsection

@section('css')
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                                    return 'Batas Lulus';
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
                                    text: 'Tidak (Lulus SAW): ' + jumlahTidakLulusSAW,
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
