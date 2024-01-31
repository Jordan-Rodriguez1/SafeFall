<?php 
    encabezado();
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Placas</h1>
            <div class="d-sm-inline-block">
                <a href="#" data-toggle="modal" data-target="#nuevaplaca" class="btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Nueva</a>
                <a href="<?= base_url(); ?>Control/Inactivas" class="btn btn-sm btn-danger shadow-sm"><i class="far fa-eye-slash fa-sm text-white-50"></i> Inactivas</a>
            </div>
        </div>
        <div class="row">
            <?php foreach ($data1 as $activas) { ?>
                <!-- Tarjeta de placas -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card <?php if ($activas['uso'] == 0) { echo 'border-left-primary'; }else { echo 'border-left-success'; }?> shadow h-100 py-2">
                        <div class="card-body text-center">
                            <form action="<?= base_url(); ?>Control/InactivarPlaca?id=<?= $activas['id'];?>" method="post" class="inact">
                                <button class="d-sm-inline-block float-right btn btn-light" type="submit"><i class="fas fa-times fa-sm"></i></button>
                            </form>
                            <a href="#" data-toggle="modal" data-target="#editarplaca" data-nombre="<?= $activas['nombre'];?>" data-identificador="<?= $activas['id_placa'];?>" data-id="<?= $activas['id'];?>">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $activas['nombre'];?></div>
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">SKU: <?= $activas['id_placa'];?></div>
                                    </div>
                                    <div class="col-auto">
                                        <img src="<?= base_url(); ?>Assets/img//otros/ESP8266.png" height="120px" width="120px">
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
            if ($alert == "existe") { ?>
                <div class="alert alert-warning" role="alert">
	                <h5 class="section-title">ATENCIÓN</h5>
	                <div class="section-intro">Ya existe una placa con el mismo identificador.</div>
                </div>
            <?php } elseif ($alert == "uso") { ?>
                <div class="alert alert-warning" role="alert">
	                <h5 class="section-title">ATENCIÓN</h5>
	                <div class="section-intro">No se puede editar/eliminar una placa que esté en uso.</div>
                </div>
            <?php } elseif ($alert == "registrado") { ?>
                <div class="alert alert-success" role="alert">
	                <h5 class="section-title">REALIZADO</h5>
	                <div class="section-intro">Se regitró la placa con éxito.</div>
                </div>
            <?php } elseif ($alert == "editado") { ?>
                <div class="alert alert-success" role="alert">
	                <h5 class="section-title">REALIZADO</h5>
	                <div class="section-intro">Se editó la placa con éxito.</div>
                </div>
            <?php } elseif ($alert == "inactivo") { ?>
                <div class="alert alert-success" role="alert">
	                <h5 class="section-title">REALIZADO</h5>
	                <div class="section-intro">Se inactivó la placa con éxito.</div>
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
    <div class="modal fade" id="nuevaplaca" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva Placa</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="formulario1" method="post" action="<?php echo base_url(); ?>Control/Registroplaca" autocomplete="off">
                    <div class="modal-body">
                        <div class="form-group">
                          <label for="nombre">Nombre de la Placa</label>
                          <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                          <label for="key">Identificador de la placa</label>
                          <input type="number" class="form-control" id="key" name="key" required>
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
    <!-- Editar Modal-->
    <div class="modal fade" id="editarplaca" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva Placa</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="formulario1" method="post" action="<?php echo base_url(); ?>Control/EditarPlaca" autocomplete="off">
                    <div class="modal-body">
                        <div class="form-group">
                          <label for="nombree">Nombre de la Placa</label>
                          <input type="hidden" class="form-control" id="ide" name="ide">
                          <input type="text" class="form-control" id="nombree" name="nombree" required>
                        </div>
                        <div class="form-group">
                          <label for="keye">Identificador de la placa</label>
                          <input type="number" class="form-control" id="keye" name="keye" required>
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