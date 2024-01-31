<?php
    class Login extends Controllers{
        public function __construct()
        {
        session_start();
            if (!empty($_SESSION['activo'])) {
                header("location: " . base_url()."Dashboard/Inicio");
            }
            parent::__construct();
        }
        
        //VISTAS LOGIN
        public function login()
        {
            $this->views->getView($this, "login");
        }

        //VISTA RECUPERAR CONTRASEÑA
        public function recuperar()
        {
            $this->views->getView($this, "recuperar");
        }

        //VISTA PARA REGISTRO
        public function registrar()
        {
            $this->views->getView($this, "registrar");
        }
        
        /*--------------------------------------------------------- 
        --------------CONTROLADORES VISTAS LOGIN -------------------
        ----------------------------------------------------------*/

        //Iniciar sesión
        public function ingresar()
        {
            if (!empty($_POST['Email']) || !empty($_POST['Password'])) {
                $usuario = Limpiar($_POST['Email']);
                $clave = Limpiar($_POST['Password']);
                $hash = hash("SHA256", $clave);
                $data = $this->model->selectUsuario($usuario, $hash);
                if (!empty($data)) {
                        $_SESSION['id'] = $data['id'];
                        $_SESSION['nombre'] = $data['nombre'];
                        $_SESSION['apellido'] = $data['apellido'];
                        $_SESSION['correo'] = $data['correo'];
                        $_SESSION['perfil'] = $data['perfil'];
                        $_SESSION['activo'] = true;
                        header('location: '.base_url(). 'Dashboard/Inicio');
                } else {
                    $error = 'mal';
                    header("location: ".base_url(). 'Login/login'."?msg=$error");
                }
            } else {
                $error = 0;
                header("location: ".base_url(). 'Login/login'."?msg=$error");
            }
        }

        /*--------------------------------------------------------- 
        ---------CONTROLADORES VISTAS RECUPERAR -------------------
        ----------------------------------------------------------*/

        //Manda correo para cambiar contraseña
        public function restablecer()
        {
            $correo = Limpiar($_POST['correo']);
            $validar = $this->model->editarUsuariosC($correo);
            if ($validar == 0) {
                $alert = 'noexiste';
            } else {
                $contrasenaAleatoria = generarContrasenaAleatoria(12);
                $nuevahash = hash("SHA256", $contrasenaAleatoria);
                $this->model->cambiarContra($nuevahash, $validar['id']);
                $alert = 'mandado';
                //Mandar correo de cambio.
                $asunto = 'RECUPERAR CUENTA';
                $cuerpo = '<h3>Gracias por usarnuestro servicio</h3><p>Tu para ingresar de nuevo a tu cuenta usa la siguiente contraseña.</p><br><strong>'.$contrasenaAleatoria.'</strong><br>
                            <p>Recuerda cambiarla una vez dentro para tener más seguridad en tu cuenta.</p>';
                EnviarCorreo($correo, $validar['nombre'], $asunto, $cuerpo);
            }
            header("location: " . base_url() . "Login/recuperar?msg=$alert");
            die();   
        }

        /*--------------------------------------------------------- 
        ----------CONTROLADORES VISTAS REGISTRO -------------------
        ----------------------------------------------------------*/

        //Añade un nuevo usuario
        public function insertar()
        {
            $nombre = Limpiar($_POST['FirstName']);
            $apellido = Limpiar($_POST['LastName']);
            $correo = Limpiar($_POST['Email']);
            $clave = Limpiar($_POST['Password']);
            $clave2 = Limpiar($_POST['RepeatPassword']);
            $hash = hash("SHA256", $clave);
            if ($clave == $clave2) {
                $insert = $this->model->insertarUsuarios($nombre, $apellido,  $correo, $hash);
                if ($insert == 'existe') {
                        $alert = 'existe';
                } else if ($insert > 0) {
                    $alert = 'registrado';

                    //Mandar correo de registro.
                    $asunto = 'CREACIÓN DE USUARIO';
                    $cuerpo = '<h3>Gracias por usarnuestro servicio</h3><p>Tu usuario ha sido registrado exitosamente, ahora puedes utilizar la plataforma.</p>';
                    EnviarCorreo($correo, $nombre, $asunto, $cuerpo);

                } else {
                    $alert = 'error';
                }
            } else {
                $alert = 'nopassword';
            }
            header("location: " . base_url() . "Login/registrar?msg=$alert");
            die();   
        }

    }
?>