<?php 
    encabezado();
?>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Placas Inactivas</h1>
            <div class="d-sm-inline-block">
                <a href="<?= base_url(); ?>Control/Placas" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Regresar</a>
            </div>
        </div>
        <div class="row">
            <?php foreach ($data1 as $activas) { ?>
                <!-- Tarjeta de placas -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-dark shadow h-100 py-2">
                        <div class="card-body text-center">
                            <form action="<?= base_url(); ?>Control/EliminarPlaca?id=<?= $activas['id'];?>" method="post" class="elim">
                                <button class="d-sm-inline-block float-right btn btn-light" type="submit"><i class="fas fa-times fa-sm"></i></button>
                            </form>
                            <form action="<?= base_url(); ?>Control/ActivarPlaca?id=<?= $activas['id'];?>" method="post" class="activar">
                                <button class="d-sm-inline-block float-right btn btn-light" type="submit"><i class="fas fa-undo-alt fa-sm"></i></button>
                            </form> 
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $activas['nombre'];?></div>
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">SKU: <?= $activas['id_placa'];?></div>
                                </div>
                                <div class="col-auto">
                                    <img src="<?= base_url(); ?>Assets/img/otros/ESP8266.png" height="120px" width="120px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- Alertas -->
        <?php if (isset($_GET['msg'])) {
            echo "<div class='d-sm-inline-block'>";
            $alert = $_GET['msg'];
            if ($alert == "eliminado") { ?>
                <div class="alert alert-success" role="alert">
	                <h5 class="section-title">REALIZADO</h5>
	                <div class="section-intro">Se eliminó la placa con éxito.</div>
                </div>
            <?php } elseif ($alert == "reactivo") { ?>
                <div class="alert alert-success" role="alert">
	                <h5 class="section-title">REALIZADO</h5>
	                <div class="section-intro">Se activó la placa con éxito.</div>
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

<?php 
    pie();
?>