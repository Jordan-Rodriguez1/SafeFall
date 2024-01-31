<?php encabezadologin() ?>

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bienvenido</h1>
                                    </div>
                                    <form class="user" id="login" action="<?php echo base_url(); ?>Login/ingresar" method="POST" autocomplete="off">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="Email" name="Email" aria-describedby="emailHelp" placeholder="Ingresa Email" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="Password" name="Password" placeholder="Contraseña" required>
                                        </div>
                                        <?php if (isset($_GET['msg'])) {
                                            $alert = $_GET['msg'];
                                            if ($alert == "mal") { ?>
                                                <div class="alert alert-danger" role="alert">
                                                    <strong>Usuario y/o contraseña erroneos.</strong>
                                                </div>
                                            <?php } else { ?>
                                                <div class="alert alert-danger" role="alert">
                                                    <strong>Error. Contacte a soporte.</strong>
                                                </div>
                                            <?php }
                                        } ?>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Login"/>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?php echo base_url(); ?>Login/recuperar">¿Olvidaste la contraseña?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="<?php echo base_url(); ?>Login/registrar">Crear una cuenta</a>
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
