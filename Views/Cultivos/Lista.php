<?php 
    encabezado();
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Cultivos Activos</h1>
            <div class="d-sm-inline-block">
                <a href="#" data-toggle="modal" data-target="#nuevocultivo" class="btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Nueva</a>
                <a href="<?= base_url(); ?>Cultivos/Inactivos" class="btn btn-sm btn-danger shadow-sm"><i class="far fa-eye-slash fa-sm text-white-50"></i> Inactivas</a>
            </div>
        </div>
        <div class="row">
            <?php foreach ($data1 as $activas) { 
                // Obtener la fecha actual
                $fechaHoy = new DateTime(); 
                // Supongamos que tienes otra fecha en formato "Y-m-d", por ejemplo:
                $otraFecha = $activas['fecha'];
                // Crear un objeto DateTime para la otra fecha
                $fechaOtra = new DateTime($otraFecha);
                // Calcular la diferencia en días
                $diferencia = $fechaHoy->diff($fechaOtra);
                // Acceder al número de días de la diferencia
                $diasDiferencia = $diferencia->days;?>
                <!-- Tarjeta de Cultivos -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card <?php if ($activas['alerta'] == 0) { echo 'border-left-success'; } elseif ($activas['alerta'] == 1) { echo 'border-left-warning'; }else { echo 'border-left-danger'; }?> shadow h-100 py-2">
                        <div class="card-body text-center">
                            <form action="<?= base_url(); ?>Cultivos/InactivarCultivo?id=<?= $activas['id'];?>" method="post" class="inactcult">
                                <button class="d-sm-inline-block float-right btn btn-light" type="submit"><i class="fas fa-times fa-sm"></i></button>
                            </form>
                            <a href="<?= base_url(); ?>Cultivos/Monitoreo?id=<?= $activas['id'];?>">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $activas['nombre'];?></div>
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?= $diasDiferencia;?> Días de cultivo.</div>
                                    </div>
                                    <div class="col-auto">
                                        <img src="<?= base_url(); ?>Assets/img/cultivos/monitoreo/<?= $activas['foto'];?>" height="120px" width="120px">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- Alertas -->
        <?php if (isset($_GET['msg'])) {
            echo "<div class='d-sm-inline-block'>";
            $alert = $_GET['msg'];
            if ($alert == "registrado") { ?>
                <div class="alert alert-success" role="alert">
	                <h5 class="section-title">REALIZADO</h5>
	                <div class="section-intro">Se regitró el cultivo con éxito.</div>
                </div>
            <?php } elseif ($alert == "inactivo") { ?>
                <div class="alert alert-success" role="alert">
	                <h5 class="section-title">REALIZADO</h5>
	                <div class="section-intro">Se inactivó el cultivo con éxito.</div>
                </div>
            <?php } else { ?>
                <div class="alert alert-danger" role="alert">
	                <h5 class="section-title">ERROR</h5>
	                <div class="section-intro">Hubo un error, intente de nuevo.</div>
                </div>
            <?php }
            echo "</div>";
        } ?>
    </div>
    <!-- /.container-fluid -->
    <!-- Nueva Modal-->
    <div class="modal fade" id="nuevocultivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo Cultivo</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="formulario1" method="post" action="<?php echo base_url(); ?>Cultivos/RegistroCultivo" autocomplete="off" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                          <label for="nombre">Nombre del Cultivo</label>
                          <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="placa">Selecciones Placa</label>
                            <select class="form-control" id="placa" name="placa" required>
                                <?php foreach ($data3 as $placa) {
                                    echo "<option value='".$placa['id_placa']."'>".$placa['nombre']."</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="placa">Selecciones Plantilla</label>
                            <select class="form-control" id="plantilla" name="plantilla" required>
                                <?php foreach ($data2 as $plantilla) {
                                    echo "<option value='".$plantilla['id']."'>".$plantilla['nombre']."</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Registrar</button>
                        <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php 
    pie();
?>