<?php 
    encabezado();
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between">
            <h1 class="h3 mb-2 text-gray-800">Historial* de Registros (Gráficas)</h1>
            <div class="d-sm-inline-block">
                <a href="<?= base_url(); ?>Cultivos/Monitoreo?id=<?= $_GET['id']; ?>" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Regresar</a>
            </div>
        </div>
        <p class="mb-4">*Últimos 100 datos recabados.</p>
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
                <!-- Area Chart -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Monitoreo de Temperatura</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="LineasTemperaturaChart" style="height:100%; width:100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Donut Chart -->
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Monitoreo de la Humedad</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-bar">
                            <canvas id="LineasHumedadChart" style="height:100%; width:100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Area Chart -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Niveles de Luz</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="LineasLuzChart" style="height:100%; width:100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Donut Chart -->
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Niveles de CO<sub>2</sub></h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-bar">
                            <canvas id="LineasCO2Chart" style="height:100%; width:100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Donut Chart -->
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Crecimiento de la Planta</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-bar">
                            <canvas id="LineasAlturaChart" style="height:100%; width:100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <script>
        window.addEventListener("load", function() {
            // Llama a la función para obtener el valor del parámetro "id" de la URL
            var elementoId = obtenerParametroDeURL('id');

            // Asegúrate de que elementoId tenga el valor correcto antes de llamar a BarrasTemperatura
            if (elementoId !== null) {
              LineasTemperatura(elementoId);
              LineasHumedad(elementoId);
              LineasLuz(elementoId);
              LineasCO2(elementoId);
              LineasAltura(elementoId);
            } else {
              console.error('El parámetro "id" no se encontró en la URL.');
            }
        })
    </script>

<?php 
    pie();
?>