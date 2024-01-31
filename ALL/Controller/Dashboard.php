<?php
    class Dashboard extends Controllers{
        public function __construct()
        {
            session_start();
            if (empty($_SESSION['activo'])) {
                header("location: ".base_url());
            }
            parent::__construct();
        }
        
        public function Inicio()
        {
            $data1 = $this->model->TotalCultivos(); 
            $data2 = $this->model->AvanceCultivos();
            if ($data2 == 0 || $data2 == null || $data2 == '') {
                $data3 = 0; 
            } else {
                $avance = 0;
                foreach ($data2 as $pm) {
                    //PROMEDIO DE AVANCE ALTURA
                    if ($pm['altura_m'] == null || $pm['altura_m'] == "") {
                        $mon = 0;
                    } else {
                        $mon = $pm['altura_m'];
                    }
                    $final = $pm['altura'];
                    $avance_altura = $mon*100/$final;
                    //PROMEDIO DE AVANCE DIAS
                    $mond = $pm['DiferenciaDias'];
                    $finald = $pm['dias'];
                    $avance_dias = $mond*100/$finald;
                    //PROMEDIO DE LOS DOS
                    $promedio = ($avance_altura+$avance_dias)/2;
                    $avance += $promedio;
                }
                $cantidadElementos = count($data2);  // Obtiene la cantidad de elementos
                $promedioFinal = $avance / $cantidadElementos;  // Calcula el promedio final
                $data3 = round($promedioFinal,2); 
            }
            $this->views->getView($this, "Inicio",'', $data1, $data2, $data3);
        }

        public function Notificaciones()
        {
            $data1 = $this->model->MostrarNotificaciones(); 
            $this->views->getView($this, "Notificaciones", '', $data1);
            die();
        }

        public function EliminarNoti()
        {
            $id = $_GET['id'];
            $this->model->EliminarNotificacion($id); 
            header('location: ' . base_url() . "Dashboard/Notificaciones");
            die();
        }
    }
?>