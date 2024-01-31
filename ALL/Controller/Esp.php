<?php
    class Esp extends Controllers{
        public function __construct()
        {
        session_start();
            if (!empty($_SESSION['activo'])) {
                header("location: " . base_url()."Dashboard/Inicio");
            }
            parent::__construct();
        }
        
        //INGRESA LAS MEDICIONES TOMADAS
        public function RegistroDatos()
        {
            $id_placa = Limpiar($_POST['id_placa']);
            //Obtenemos el id del cultivo que tiene asignada esa placa.
            //$data = $this->model->BuscarCultivo($id_placa);
            //$id_usuario = $data['id_usuario'];
            //$id_cultivo = $data['id'];
            $pulso = Limpiar($_POST['pulso']);
            $estado = Limpiar($_POST['estado']);

            //$insert = $this->model->insertarMonitoreo($id_cultivo, $tem, $humendad, $stem, $shumendad, $lum, $co2, $altura);

            $insert = $this->model->insertarMonitoreo($id_placa, $pulso, $estado);

            echo "TA BIEN";
            die();   
        }

    }
?>