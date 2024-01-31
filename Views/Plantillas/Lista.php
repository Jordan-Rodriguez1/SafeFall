<?php 
    encabezado();
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Plantillas</h1>
            <div class="d-sm-inline-block">
                <a href="#" data-toggle="modal" data-target="#nuevaplantilla" class="btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Nueva</a>
                <a href="<?= base_url(); ?>Plantillas/Inactivas" class="btn btn-sm btn-danger shadow-sm"><i class="far fa-eye-slash fa-sm text-white-50"></i> Inactivas</a>
            </div>
        </div>
        <div class="row">
            <?php foreach ($data1 as $activas) { ?>
                <!-- Tarjeta de plantillas -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body text-center">
                            <form action="<?= base_url(); ?>Plantillas/InactivarPlantilla?id=<?= $activas['id'];?>" method="post" class="inactpla">
                                <button class="d-sm-inline-block float-right btn btn-light" type="submit"><i class="fas fa-times fa-sm"></i></button>
                            </form>
                            <a href="<?= base_url(); ?>Plantillas/Detalle?id=<?= $activas['id'];?>">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $activas['nombre'];?></div>
                                    </div>
                                    <div class="col-auto">
                                        <img src="<?= base_url(); ?>Assets/img/cultivos/plantillas/<?= $activas['foto'];?>" height="120px" width="120px">
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
	                <div class="section-intro">Se regitró la plantilla con éxito.</div>
                </div>
            <?php } elseif ($alert == "inactivo") { ?>
                <div class="alert alert-success" role="alert">
	                <h5 class="section-title">REALIZADO</h5>
	                <div class="section-intro">Se inactivó la plantilla con éxito.</div>
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
    <div class="modal fade" id="nuevaplantilla" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva Plantilla</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="formulario1" method="post" action="<?php echo base_url(); ?>Plantillas/Registroplantilla" autocomplete="off" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                          <label for="nombre">Nombre de la Plantilla</label>
                          <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                              <label for="tem_max">Temperatura Máxima (ºC)</label>
                              <input type="tem_max" step="0.01" class="form-control" id="tem_max" name="tem_max" required>
                            </div>
                            <div class="form-group col-6">
                              <label for="tem_min">Temperatura Mínima (ºC)</label>
                              <input type="number" step="0.01" class="form-control" id="tem_min" name="tem_min" required>
                            </div>
                            <div class="form-group col-6">
                              <label for="humedad_max">Humedad Máxima (%)</label>
                              <input type="number" step="0.01" class="form-control" id="humedad_max" name="humedad_max" required>
                            </div>
                            <div class="form-group col-6">
                              <label for="humedad_min">Humedad Mínima (%)</label>
                              <input type="number" step="0.01" class="form-control" id="humedad_min" name="humedad_min" required>
                            </div>
                            <div class="form-group col-6">
                              <label for="stem_max">Temp. Máxima Suelo (ºC)</label>
                              <input type="number" step="0.01" class="form-control" id="stem_max" name="stem_max" required>
                            </div>
                            <div class="form-group col-6">
                              <label for="stem_min">Temp. Mínima Suelo (ºC)</label>
                              <input type="number" step="0.01" class="form-control" id="stem_min" name="stem_min" required>
                            </div>
                            <div class="form-group col-6">
                              <label for="shumedad_max">Hum. Máxima Suelo (%)</label>
                              <input type="number" step="0.01" class="form-control" id="shumedad_max" name="shumedad_max" required>
                            </div>
                            <div class="form-group col-6">
                              <label for="shumedad_min">Hum. Mínima Suelo (%)</label>
                              <input type="number" step="0.01" class="form-control" id="shumedad_min" name="shumedad_min" required>
                            </div>
                            <div class="form-group col-6">
                              <label for="luz">Horas de luz</label>
                              <input type="number" step="0.01" class="form-control" id="luz" name="luz" required>
                            </div>
                            <div class="form-group col-6">
                              <label for="co2">CO<sub>2</sub> Máximo (ppm)</label>
                              <input type="number" step="0.01" class="form-control" id="co2" name="co2" required>
                            </div>
                            <div class="form-group col-6">
                              <label for="altura">Altura de Transplante (cm)</label>
                              <input type="number" step="0.01" class="form-control" id="altura" name="altura" required>
                            </div>
                            <div class="form-group col-6">
                              <label for="dias">Días de Transplante</label>
                              <input type="number" class="form-control" id="dias" name="dias" required>
                            </div>
                        </div>
                        <div class="form-group">
                          <label for="nombre">Imágen de Previzualización</label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="archivo" name="archivo" required>
                            <label class="custom-file-label" for="archivo">Selecciona el archivos</label>
                          </div>
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