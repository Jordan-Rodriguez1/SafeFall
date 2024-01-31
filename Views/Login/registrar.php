<?php encabezadologin() ?>
    
    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> <!-- SOLO FALTA EDITAR LAIMAGEN --> 
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Crear Cuenta</h1>
                            </div>
                            <form class="user" id="registrar" action="<?php echo base_url(); ?>Login/insertar" method="POST" autocomplete="off">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="FirstName" name="FirstName" placeholder="Nombres" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="LastName" name="LastName" placeholder="Apellidos" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="Email" name="Email" placeholder="Email" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="Password" name="Password" placeholder="Contraseña" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="RepeatPassword" name="RepeatPassword" placeholder="Repite la Contraseña" required>
                                    </div>
                                </div>
                                <?php if (isset($_GET['msg'])) {
                                    $alert = $_GET['msg'];
                                    if ($alert == "registrado") { ?>
                                        <div class="alert alert-success" role="alert">
                                            <strong>Usuario registrado con éxito.</strong>
                                        </div>
                                    <?php } elseif ($alert == "existe") { ?>
                                        <div class="alert alert-warning" role="alert">
                                            <strong>Ya existe un usuario con ese correo.</strong>
                                        </div>
                                     <?php } elseif ($alert == "nopassword") { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <strong>Las contraseñas no coinciden.</strong>
                                        </div>
                                    <?php } else { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <strong>Error. Contacte a soporte.</strong>
                                        </div>
                                    <?php }
                                } ?>
                                <input type="submit" class="btn btn-primary btn-user btn-block" value="Registrar Cuenta"/>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?php echo base_url(); ?>Login/recuperar">¿Olvidaste la contraseña?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="<?php echo base_url(); ?>">¿Ya tienes cuenta? Ingresa</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php pielogin() ?>