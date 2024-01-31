<?php encabezadologin() ?>
    
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">¿Olvidaste la contraseña?</h1>
                                        <p class="mb-4">Lo entendemos, suceden esas cosas. Sólo tienes que introducir tu dirección de correo electrónico a continuación
                                        ¡Y te enviaremos un enlace para restablecer tu contraseña!</p>
                                    </div>
                                    <form class="user" id="recuperar" action="<?php echo base_url(); ?>Login/restablecer" method="POST" autocomplete="off">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="correo" name="correo" aria-describedby="emailHelp"
                                                placeholder="Ingresa tu email ..." required>
                                        </div>
                                        <?php if (isset($_GET['msg'])) {
                                            $alert = $_GET['msg'];
                                            if ($alert == "mandado") { ?>
                                                <div class="alert alert-success" role="alert">
                                                    <strong>Se mandó el enlace con éxito.</strong>
                                                </div>
                                            <?php } elseif ($alert == "noexiste") { ?>
                                                <div class="alert alert-warning" role="alert">
                                                    <strong>No existe una cuenta con ese correo.</strong>
                                                </div>
                                            <?php } else { ?>
                                                <div class="alert alert-danger" role="alert">
                                                    <strong>Error. Contacte a soporte.</strong>
                                                </div>
                                            <?php }
                                        } ?>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Restablecer Contraseña"/>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?php echo base_url(); ?>Login/registrar">Crear una cuenta</a>
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

        </div>

    </div>

<?php pielogin() ?>