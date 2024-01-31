<?php
    class Usuarios extends Controllers
    {
        public function __construct()
        {
            session_start();
            if (empty($_SESSION['activo'])) {
                header("location: ".base_url());
            }
            parent::__construct();
        }

        //VISTA PARA DATOS DEL PERFIL
        public function Perfil()
        {
            $this->views->getView($this, "Perfil");
        }

        /*--------------------------------------------------------- 
        ------------- CONTROLADORES VISTAS PERFIL -----------------
        ----------------------------------------------------------*/

        //Actualiza los datos de un Usuario
        public function actualizar()
        {
            $id = Limpiar($_POST['id']);
            $correo = Limpiar($_POST['correo']);
            $nombre = Limpiar($_POST['nombre']);
            $apellido = Limpiar($_POST['apellido']); 
            $actualizar = $this->model->actualizarUsuario($nombre, $apellido, $id, $correo);     
            if ($actualizar == 1) {
                $alert = 'editado';
            } else {
                $alert =  'error';
            }
            header("location: " . base_url() . "Usuarios/Perfil?msg=$alert");
            die();
        }

        //Cambiar contraseña
        public function cambiar()
        {
            $actual = Limpiar($_POST['actual']);
            $id = Limpiar($_POST['id']);
            $nueva = Limpiar($_POST['nueva']);
            $nuevar = Limpiar($_POST['nuevar']);
            $hash = hash("SHA256", $actual);
            $nuevahash = hash("SHA256", $nueva);
            if ($nueva == $nuevar) {
                $data = $this->model->verificarPass($hash, $id);
                if ($data != null) {
                    $this->model->cambiarContra($nuevahash, $id);
                    $alert =  'editado';
                }  else{
                    $alert =  'erronea';
                }
            } else {
                $alert =  'noiguales';
            }
            header('location: ' . base_url() . "Usuarios/Perfil?msg=$alert");  
        }

        //Cambiar Imagen Perfil
        public function cambiarpic()
        {
            $usuario = $this->model->editarUsuarios($_SESSION['id']);
            $imgactual = $usuario['perfil'];
            $name = pathinfo($_FILES["archivo"]["name"]);
            $nombre_archivo = $_FILES["archivo"]["name"];
            $nombre_nuevo = $_SESSION['id'].".".$name["extension"];
            $tipo_archivo = $_FILES["archivo"]["type"];
            $tamano_archivo = $_FILES["archivo"]["size"];
            $ruta_temporal = $_FILES["archivo"]["tmp_name"];
            $error_archivo = $_FILES["archivo"]["error"];
            $tmaximo = 20 * 1024 * 1024;
            if(($tamano_archivo < $tmaximo && $tamano_archivo != 0) && ($name["extension"] == "png" || $name["extension"] == "jpg" || $name["extension"] == "jpeg")){
                if ($error_archivo == UPLOAD_ERR_OK) {
                    if($imgactual != "undraw_profile.svg"){
                        unlink("Assets/img/users/".$imgactual);
                    }
                    $ruta_destino = "Assets/img/users/".$nombre_nuevo;
                    if (move_uploaded_file($ruta_temporal, $ruta_destino)) {
                        $id = $_SESSION['id'];
                        $this->model->img($nombre_nuevo, $id);
                        $alert =  'imagen';
                    } else {
                        $alert =  'noimagen';
                    }
                } else {
                $alert =  'noimagen';
                }
            } else {
                $alert =  'noimagen';
            }
            header('location: ' . base_url() . "Usuarios/Perfil?msg=$alert");
            die();
        }

        /*--------------------------------------------------------- 
        --------------CONTROLADORES FOOTER -------------------------
        ----------------------------------------------------------*/

        //Cerrar Sesión
        public function salir()
        {
            session_destroy();
            header("Location: ".base_url());
        }
    }
?>