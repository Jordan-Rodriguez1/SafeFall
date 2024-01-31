<?php 
    encabezado();
    // Obtener la fecha actual
    $fechaHoy = new DateTime(); 
    // Supongamos que tienes otra fecha en formato "Y-m-d", por ejemplo:
    $otraFecha = $data1['fecha'];
    // Crear un objeto DateTime para la otra fecha
    $fechaOtra = new DateTime($otraFecha);
    // Calcular la diferencia en días
    $diferencia = $fechaHoy->diff($fechaOtra);
    // Acceder al número de días de la diferencia
    $diasDiferencia = $diferencia->days;
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Últimas Mediciones</h1>
          <div class="d-sm-inline-block">
              <a href="<?= base_url(); ?>Cultivos/Lista" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Regresar</a>
          </div>
      </div>
        <!-- Content Row -->
        <div class="row d-flex">
            <!-- Grow In Utility -->
            <div class="col-lg-3">
                <!-- Información del perfil -->
                <div class="card position-relative h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Cultivo</h6>
                    </div>
                    <div class="card-body text-center">
                      <div class="row no-gutters align-items-center">
                          <div class="col-6">
                              <div class="h5 mb-0 font-weight-bold" style="color: black;"><?= $data1['nombre']; ?></div>
                              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?= $data1['fecha'];?></div>
                          </div>
                          <div class="col-auto">
                              <img src="<?= base_url(); ?>Assets/img/cultivos/monitoreo/<?= $data2['foto']; ?>" height="120px">
                          </div>
                      </div>
                    </div>
                    <div class="card-footer text-center">
                      <a href="<?= base_url(); ?>Cultivos/Configuracion?id=<?= $_GET['id']; ?>" class="btn btn-info btn-circle btn-sm">
                          <i class="fas fa-cog"></i>
                      </a>
                      <a href="<?= base_url(); ?>Cultivos/Detalle?id=<?= $_GET['id']; ?>" class="btn btn-info btn-circle btn-sm">
                          <i class="fas fa-table"></i>
                      </a>
                      <a href="<?= base_url(); ?>Cultivos/Graficas?id=<?= $_GET['id']; ?>" class="btn btn-info btn-circle btn-sm">
                          <i class="fas fa-chart-area"></i>
                      </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <!-- Información del perfil -->
                <div class="card position-relative h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Temperatura del Aire</h6>
                    </div>
                    <div class="card-body text-center">
                      <div class="row no-gutters align-items-center justify-content-center">
                        <!-- /.AQUÍ VA EL GRÁFICO -->
                        <div class="align-items-center justify-content-center" id="TemperaturaAireChart"></div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <!-- Información del perfil -->
                <div class="card position-relative h-100"">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Humedad del Aire</h6>
                    </div>
                    <div class="card-body text-center">
                      <div class="row no-gutters align-items-center justify-content-center">
                        <!-- /.AQUÍ VA EL GRÁFICO -->
                        <div class="align-items-center justify-content-center" id="HumedadAireChart"></div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <!-- Información del perfil -->
                <div class="card position-relative h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Datos Generales</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2 my-5">
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $diasDiferencia;?> Días de cultivo.</div>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Faltan <?= $data2['dias']-$diasDiferencia;?> Días para el transplante</div>
                                <br>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data3['altura'];?> CM de altura.</div>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Faltan <?= $data2['altura']-$data3['altura'];?> CM para el transplante</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 py-3">
                <!-- Información del perfil -->
                <div class="card position-relative h-100"">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Estado de Cultivo</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2 mt-5">
                                <?php if ($data1['alerta'] == 0) { ?>
                                    <a href="" class="btn btn-success btn-circle btn-lg">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <div class="h5 my-2 font-weight-bold text-gray-800">Cultivo en Orden</div>
                                <?php } elseif ($data1['alerta'] == 1) { ?>
                                    <a href="" class="btn btn-warning btn-circle btn-lg">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </a>
                                    <div class="h5 my-2 font-weight-bold text-gray-800">Precaución el cultivo está saliendo de rango</div>
                                <?php } else { ?>
                                    <a href="" class="btn btn-danger btn-circle btn-lg">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </a>
                                    <div class="h5 my-2 font-weight-bold text-gray-800">Atención algo está mal en el cultivo</div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 py-3">
                <!-- Información del perfil -->
                <div class="card position-relative h-100"">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Temperatura del Suelo</h6>
                    </div>
                    <div class="card-body text-center">
                      <div class="row no-gutters align-items-center justify-content-center">
                        <!-- /.AQUÍ VA EL GRÁFICO -->
                        <div class="align-items-center justify-content-center" id="TemperaturaSueloChart"></div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 py-3">
                <!-- Información del perfil -->
                <div class="card position-relative h-100"">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Humedad del Suelo</h6>
                    </div>
                    <div class="card-body text-center">
                      <div class="row no-gutters align-items-center justify-content-center">
                        <!-- /.AQUÍ VA EL GRÁFICO -->
                        <div class="align-items-center justify-content-center" id="HumedadSueloChart"></div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 py-3">
                <!-- Información del perfil -->
                <div class="card position-relative h-100"">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Niveles de CO<sub>2</sub></h6>
                    </div>
                    <div class="card-body text-center">
                      <div class="row no-gutters align-items-center justify-content-center">
                        <!-- /.AQUÍ VA EL GRÁFICO -->
                        <div class="align-items-center justify-content-center" id="CO2Chart"></div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <p><strong>Última Medición: </strong><?= $data3['fecha']; ?></p>
    </div>
    <!-- /.container-fluid -->

    <script>
        window.addEventListener("load", function() {
            // Llama a la función para obtener el valor del parámetro "id" de la URL
            var elementoId = obtenerParametroDeURL('id');

            // Asegúrate de que elementoId tenga el valor correcto antes de llamar a BarrasTemperatura
            if (elementoId !== null) {
                TemperaturaAire(elementoId);
                HumedadAire(elementoId);  
                TemperaturaSuelo(elementoId);
                HumedadSuelo(elementoId);  
                CO2(elementoId);
            } else {
              console.error('El parámetro "id" no se encontró en la URL.');
            }
        })
    </script>

<?php 
    pie();
?>