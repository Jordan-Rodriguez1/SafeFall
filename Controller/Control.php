<?php
    class Control extends Controllers{
        public function __construct()
        {
            session_start();
            if (empty($_SESSION['activo'])) {
                header("location: ".base_url());
            }
            parent::__construct();
        }

        //MUESTRA LA LISTA DE PLACAS ACTIVAS
        public function Placas()
        {
            $data1 = $this->model->placasactivas();
            $this->views->getView($this, "Placas",'',$data1);
            die(); 
        }

        //MUESTAR LA LISTA DE PLACAS INACTIVAS
        public function Inactivas()
        {
            $data1 = $this->model->placasinactivas();
            $this->views->getView($this, "Inactivas",'', $data1);
            die(); 
        }

        /*--------------------------------------------------------- 
        --------------CONTROLADORES VISTAS PLACA ------------------
        ----------------------------------------------------------*/

        //INGRESA UNA NUEVA PLACA
        public function Registroplaca()
        {
            $nombre = Limpiar($_POST['nombre']);
            $key = Limpiar($_POST['key']);
            $usuario = $_SESSION['id'];
            $insert = $this->model->insertarPlaca($nombre, $key, $usuario);
            if ($insert == 'existe') {
                    $alert = 'existe';
            } else if ($insert > 0) {
                $alert = 'registrado';
            } else {
                $alert = 'error';
            }
            header("location: " . base_url() . "Control/Placas?msg=$alert");
            die();   
        }

        //EDITAR UNA PLACA
        public function EditarPlaca()
        {
            $nombre = Limpiar($_POST['nombree']);
            $key = Limpiar($_POST['keye']);
            $id = Limpiar($_POST['ide']);
            $datos = $this->model->datosplaca($id);
            if ($datos['uso'] == 0) {
                $insert = $this->model->EditarPlaca($nombre, $key, $id);
                if ($insert == 'existe') {
                        $alert = 'existe';
                } else if ($insert > 0) {
                    $alert = 'editado';
                } else {
                    $alert = 'error';
                }
            } else {
                $alert = 'uso';
            }
            header("location: " . base_url() . "Control/Placas?msg=$alert");
            die();   
        }

        //CAMBIA DE ESTADO UNA PLACA
        public function InactivarPlaca()
        {
            $id = Limpiar($_GET['id']);
            $estado = 1;
            $datos = $this->model->datosplaca($id);
            if ($datos['uso'] == 0) {
                $insert = $this->model->EstadoPlaca($id, $estado);
                $alert = 'inactivo';
            } else {
                $alert = 'uso';
            }
            header("location: " . base_url() . "Control/Placas?msg=$alert");
            die();   
        }

        /*--------------------------------------------------------- 
        ----------CONTROLADORES VISTAS INACTIVAS -----------------
        ----------------------------------------------------------*/

        //CAMBIA DE ESTADO UNA PLACA
        public function ActivarPlaca()
        {
            $id = Limpiar($_GET['id']);
            $estado = 0;
            $insert = $this->model->EstadoPlaca($id, $estado);
            $alert = 'reactivo';
            header("location: " . base_url() . "Control/Inactivas?msg=$alert");
            die();   
        }

        //CAMBIA DE ESTADO UNA PLACA
        public function EliminarPlaca()
        {
            $id = Limpiar($_GET['id']);
            $estado = 2;
            $insert = $this->model->EstadoPlaca($id, $estado);
            $alert = 'eliminado';
            header("location: " . base_url() . "Control/Inactivas?msg=$alert");
            die();   
        }

    }
?>