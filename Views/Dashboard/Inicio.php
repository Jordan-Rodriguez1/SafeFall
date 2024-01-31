<?php 
    encabezado();
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Inicio</h1>
        </div>
        <!-- Content Row -->
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Cultivos Activos</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data1['alerta_0']+$data1['alerta_1']; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fab fa-pagelines fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Avance Cultivos
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $data3; ?>%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: <?= $data3; ?>%" aria-valuenow="<?= $data3; ?>" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-battery-three-quarters fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Cultivos en Peligro</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data1['alerta_1']; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Cultivos a Salvo</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data1['alerta_0']; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content Row -->
        <div class="row">
            <!-- Content Column -->
            <div class="col-lg-6 mb-4">
                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Avance Estimado Cultivos</h6>
                    </div>
                    <div class="card-body">
                        <?php foreach ($data2 as $cul) { 
                            //PROMEDIO DE AVANCE ALTURA
                            if ($cul['altura_m'] == null || $cul['altura_m'] == "") {
                                $mon = 0;
                            } else {
                                $mon = $cul['altura_m'];
                            }
                            $final = $cul['altura'];
                            $avance_altura = $mon*100/$final;
                            //PROMEDIO DE AVANCE DIAS
                            $mond = $cul['DiferenciaDias'];
                            $finald = $cul['dias'];
                            $avance_dias = $mond*100/$finald;
                            //PROMEDIO DE LOS DOS
                            $promedio = round(($avance_altura+$avance_dias)/2,2);
                            ?>
                            <h4 class="small font-weight-bold"><?= $cul['nombre']; ?><span
                                    class="float-right"><?= $promedio; ?>%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-success" role="progressbar" style="width: <?= $promedio; ?>%"
                                    aria-valuenow="<?= $promedio; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <!-- Approach -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Notas del Desarrollador</h6>
                    </div>
                    <div class="card-body">
                        <p>Este software es un solo un prototipo de lo que podría llegar a ser, además depende en gran medida del hardware
                            que se implemente en la cámara de cultivo, por lo que el uso del mismo de manera profesional queda en consideración
                            del usuario.</p>
                        <p class="mb-0">Para contactar con el autor puede hacerlo mediante el correo mrodriguez74@ucol.mx.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

<?php 
    pie();
?>