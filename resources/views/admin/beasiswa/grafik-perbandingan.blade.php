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
                    }
                }
            }
        });
    </script>
@stop
