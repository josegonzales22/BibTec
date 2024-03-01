<x-layouts.system
title2="Inicio"
iname="Dashboard">
<style>.d-icons{font-size:40px;color:whitesmoke;}</style>
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
                                <?php
                                    try {
                                        if(contarTotalLibros()){echo "".contarTotalLibros();}
                                        else{echo "0";}
                                    } catch (\Throwable $th) {echo "0";}
                                ?>
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
                                <?php
                                    try {
                                        if(contarTotalEstudiantes()){echo "".contarTotalEstudiantes();}
                                        else{echo "0";}
                                    } catch (\Throwable $th) {echo "0";}
                                ?>
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
                                <?php
                                    try {
                                        if(contarTotalPrestamosMens()){echo "".contarTotalPrestamosMens();}
                                        else{echo "0";}
                                    } catch (\Throwable $th) {echo "0";}
                                ?>
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
                                <?php
                                    try {
                                        if(contarTotalDevolucionesMens()){echo "".contarTotalDevolucionesMens();}
                                        else{echo "0";}
                                    } catch (\Throwable $th) {echo "0";}
                                ?>
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
</x-layouts.system>
