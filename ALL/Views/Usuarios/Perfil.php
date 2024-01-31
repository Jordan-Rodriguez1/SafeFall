<?php 
    encabezado();
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-1 text-gray-800">Perfil</h1>
        <!-- Content Row -->
        <div class="row">
            <!-- Grow In Utility -->
            <div class="col-lg-4">
                <!-- Información del perfil -->
                <div class="card position-relative">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Datos del Perfil</h6>
                    </div>
                    <div class="card-body text-center">
                      <img height="120px" style="margin: 0 0 10px 0;" class="img-profile rounded-circle" src="<?= base_url().'Assets/img/users/'.$_SESSION['perfil'] ?>">
                      <h5 style="color: black;"><strong><?= $_SESSION['nombre'].'<br>'.$_SESSION['apellido'] ?></strong></h5>
                      <h6 style="color: black;"><?= $_SESSION['correo'] ?></h6>
                    </div>
                </div>
                <div class="my-2"></div>
                <!-- Alertas -->
                <?php if (isset($_GET['msg'])) {
                    echo "<div class='d-sm-inline-block'>";
                    $alert = $_GET['msg'];
                    if ($alert == "editado") { ?>
                        <div class="alert alert-success" role="alert">
    	                      <h5 class="section-title">REALIZADO</h5>
    	                      <div class="section-intro">Se actualizó la información correctamente. Cierra sesión e ingresa de nuevo para ver los cambios reflejados.</div>
                        </div>
                    <?php } elseif ($alert == "imagen") { ?>
                        <div class="alert alert-success" role="alert">
    	                      <h5 class="section-title">REALIZADO</h5>
    	                      <div class="section-intro">Se cambió la imágen con éxito. Cierra sesión e ingresa de nuevo para ver los cambios reflejados.</div>
                        </div>
                    <?php } elseif ($alert == "noiguales") { ?>
                        <div class="alert alert-warning" role="alert">
    	                      <h5 class="section-title">ATENCIÓN</h5>
    	                      <div class="section-intro">Las contraseñas no son iguales.</div>
                        </div>
                    <?php } elseif ($alert == "erronea") { ?>
                        <div class="alert alert-warning" role="alert">
    	                      <h5 class="section-title">ATENCIÓN</h5>
    	                      <div class="section-intro">La contraseña actual es erronea.</div>
                        </div>
                    <?php } elseif ($alert == "noimagen") { ?>
                        <div class="alert alert-danger" role="alert">
    	                      <h5 class="section-title">ERROR</h5>
    	                      <div class="section-intro">Hubo un error al cambiar la imágen.</div>
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
            <!-- Actualizar Foto -->
            <div class="col-lg-8">
                <div class="card position-relative">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Actulizar Imagen</h6>
                    </div>
                    <div class="card-body text-center">
                      <img height="120px" style="margin: 0 0 10px 0;" class="img-profile rounded-circle" src="<?= base_url().'Assets/img/users/'.$_SESSION['perfil'] ?>">
                      <div class="my-2"></div>
                      <form id="formulario2" method="post" action="<?php echo base_url(); ?>Usuarios/cambiarpic" autocomplete="off" enctype="multipart/form-data">
                          <div class="form-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="archivo" name="archivo" required>
                              <label class="custom-file-label" for="archivo">Selecciona el archivos</label>
                            </div>
                            <input type="hidden" class="form-control" id="id" name="id" value="<?= $_SESSION['id']; ?>">
                          </div>
                          <button type="submit" class="btn btn-success btn-icon-split">
                              <span class="icon text-white-50">
                                  <i class="fas fa-pen"></i>
                              </span>
                              <span class="text">Editar</span>
                          </button>
                      </form>
                    </div>
                </div>
                <div class="my-2"></div>
                <!-- Actualizar Datos -->
                <div class="card position-relative">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Actulizar Datos</h6>
                    </div>
                    <div class="card-body">
                        <form id="formulario1" method="post" action="<?php echo base_url(); ?>Usuarios/actualizar" autocomplete="off" enctype="multipart/form-data">
                            <div class="form-group">
                              <label for="correo">Correo</label>
                              <input type="text" class="form-control" id="correo" name="correo" value="<?= $_SESSION['correo']; ?>" required>
                              <input type="hidden" class="form-control" id="id" name="id" value="<?= $_SESSION['id']; ?>">
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                  <label for="nombre">Nombres</label>
                                  <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $_SESSION['nombre']; ?>" required>
                                </div>
                                <div class="form-group col-6">
                                  <label for="apellido">Apellidos</label>
                                  <input type="text" class="form-control" id="apellido" name="apellido" value="<?= $_SESSION['apellido']; ?>" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="text">Guardar</span>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="my-2"></div>
                <!-- Actualizar Contraseña -->
                <div class="card position-relative">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Actulizar Datos</h6>
                    </div>
                    <div class="card-body">
                        <form id="formulario1" method="post" action="<?php echo base_url(); ?>Usuarios/cambiar" autocomplete="off" enctype="multipart/form-data">
                            <div class="form-group">
                              <label for="actual">Contraseña Actual</label>
                              <input type="password" class="form-control" id="actual" name="actual" value="" required>
                              <input type="hidden" class="form-control" id="id" name="id" value="<?= $_SESSION['id']; ?>">
                            </div>
                            <div class="form-group">
                              <label for="nueva">Nueva Contraseña</label>
                              <input type="password" class="form-control" id="nueva" name="nueva" value="" required>
                            </div>
                            <div class="form-group">
                              <label for="nuevar">Repite Nueva Contraseña</label>
                              <input type="password" class="form-control" id="nuevar" name="nuevar" value="" required>
                            </div>
                            <button type="submit" class="btn btn-success btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="text">Guardar</span>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="my-2"></div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    
<?php 
    pie();
?>