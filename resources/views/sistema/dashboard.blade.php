<x-layouts.system
title2="Inicio"
iname="Dashboard">
<style>.d-icons{font-size:40px;color:whitesmoke;}</style>
@section('js_chart')
    <script src="{{ asset('js/chart.js') }}"></script>
@endsection
<main class="container-fluid">
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="background-color:#816AFD;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-light text-uppercase mb-1">
                            Libros</div>
                            <div class="h5 mb-0 font-weight-bold text-light">
                                {{ app(App\Http\Controllers\DashboardController::class)->contarLibros() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-book d-icons"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2 bg-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-light text-uppercase mb-1">
                            Estudiantes</div>
                            <div class="h5 mb-0 font-weight-bold text-light">
                                {{ app(App\Http\Controllers\DashboardController::class)->contarEstudiante() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-users d-icons"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2 bg-success">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-light text-uppercase mb-1">
                            Préstamos (Mensuales)</div>
                            <div class="h5 mb-0 font-weight-bold text-light">
                                {{ app(App\Http\Controllers\DashboardController::class)->contarPrestamo() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-folder-open d-icons"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2 bg-info">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-light text-uppercase mb-1">
                            Devoluciones (Mensuales)</div>
                            <div class="h5 mb-0 font-weight-bold text-light">
                                {{ app(App\Http\Controllers\DashboardController::class)->contarDevolucion() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-folder-closed d-icons"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">5 libros más prestados</h6>
                </div>
                <div class="card-body">
                    <canvas id="graficoLibros" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Gráfico de libros</h6>
                </div>
                <div class="card-body">
                    <canvas id="graficoLibros2" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Flujo de estudiantes</h6>
                </div>
                <div class="card-body">
                    <canvas id="graficoPorcentaje" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    var ctx1 = document.getElementById('graficoLibros').getContext('2d');
    var myChart1 = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: [
                @foreach($librosMasPrestados as $libro)
                    "{{ $libro['id'] }}",
                @endforeach
            ],
            datasets: [{
                label: 'Cantidad de préstamos',
                data: [
                    @foreach($librosMasPrestados as $libro)
                        {{ $libro['total_prestamos'] }},
                    @endforeach
                ],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            plugins: {
                title: {
                    display: false
                },
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    ticks: {
                        beginAtZero: true
                    },
                    title: {
                        display: true,
                        text: 'Cantidad de Préstamos'
                    }
                },
                x:{
                    title: {
                        display: true,
                        text: 'Id de libros'
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
    var ctx2 = document.getElementById('graficoLibros2').getContext('2d');
    var myChart2 = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: [
                @foreach($librosMasPrestados as $libro)
                    "{{ $libro['titulo'] }}",
                @endforeach
            ],
            datasets: [{
                label: 'Cantidad de préstamos',
                data: [
                    @foreach($librosMasPrestados as $libro)
                        {{ $libro['total_prestamos'] }},
                    @endforeach
                ],
                backgroundColor: [
                            'rgba(0, 123, 255, 0.7)',
                            'rgba(108, 117, 125, 0.7)',
                            'rgba(40, 167, 69, 0.7)',
                            'rgba(220, 53, 69, 0.7)',
                            'rgba(255, 193, 7, 0.7)'
                        ],
                        borderColor: [
                            'rgba(0, 123, 255, 1)',
                            'rgba(108, 117, 125, 1)',
                            'rgba(40, 167, 69, 1)',
                            'rgba(220, 53, 69, 1)',
                            'rgba(255, 193, 7, 1)'
                        ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: true,
                    position: 'right'
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    var ctx3 = document.getElementById('graficoPorcentaje').getContext('2d');
    var myChart3 = new Chart(ctx3, {
        type: 'pie',
        data: {
            labels: ['Con préstamos', 'Sin préstamos'],
            datasets: [{
                label: 'Porcentaje de estudiantes con préstamos',
                data: [
                    {{ $estudiantesConPrestamos / $totalEstudiantes * 100 }},
                    {{ ($totalEstudiantes - $estudiantesConPrestamos) / $totalEstudiantes * 100 }}
                ],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.7)',
                    'rgba(0, 123, 255, 0.7)'
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(0, 123, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed + '%';
                                return label;
                            }
                        }
                    }
                },
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>

<!-- Aquí sigue el resto de tu HTML -->

</x-layouts.system>
