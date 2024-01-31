<?php
    class Cultivos extends Controllers{
        public function __construct()
        {
            session_start();
            if (empty($_SESSION['activo'])) {
                header("location: ".base_url());
            }
            parent::__construct();
        }
        
        //VISTA DE CULTIVOS ACTIVOS
        public function Lista()
        {
            $data1 = $this->model->CultivosActivos();
            $data2 = $this->model->PlantillasDisponibles();
            $data3 = $this->model->PlacasDisponibles();
            $this->views->getView($this, "Lista", '', $data1, $data2, $data3);
        }

        //VISTA CULTIVOS INACTIVOS
        public function Inactivos()
        {
            $data1 = $this->model->CultivosInactivos();
            $this->views->getView($this, "Inactivos", '', $data1);
        }

        //VISTA DE ULTIMAS MEDICIONES
        public function Monitoreo()
        {
            if (!isset($_GET['id'])) {
                header("location: " . base_url() . "Cultivos/Lista");
            } else {
                $id = Limpiar($_GET['id']);
                $data1 = $this->model->datoscultivo($id);
                if ($data1 == null) {
                    header("location: " . base_url() . "Cultivos/Lista");
                } elseif ($data1['estado'] == 1) {
                    header("location: " . base_url() . "Cultivos/Inactivos");
                } else {
                    $data2 = $this->model->datosconfiguracion($id);
                    $data3 = $this->model->SelecUltimaMedicion($id);
                    if ($data3 == null) {
                        $data3 = array("fecha" => "Aún no se registra ningún dato.");
                    }
                    $this->views->getView($this, "Monitoreo", '', $data1, $data2, $data3);
                }
                die();
            }
        }

        //VISTA PARA CAMBIAR LA CONFIGURACIÓN
        public function Configuracion()
        {
            if (!isset($_GET['id'])) {
                header("location: " . base_url() . "Cultivos/Lista");
            } else {
                $id = Limpiar($_GET['id']);
                $data1 = $this->model->datoscultivo($id);
                if ($data1 == null) {
                    header("location: " . base_url() . "Cultivos/Lista"); 
                } elseif ($data1['estado'] == 1) {
                    header("location: " . base_url() . "Cultivos/Inactivos"); 
                } else {
                    $data2 = $this->model->datosconfiguracion($id);
                    $this->views->getView($this, "Configuracion", '', $data1, $data2);
                }
                die();
            }
        }

        //VISTA DE MONITOREO HISTÓRICO
        public function Detalle()
        {
            if (!isset($_GET['id'])) {
                header("location: " . base_url() . "Cultivos/Lista");
            } else {
                $id = Limpiar($_GET['id']);
                $data1 = $this->model->datoscultivo($id);
                if ($data1 == null) {
                    header("location: " . base_url() . "Cultivos/Lista");    
                } else {
                    $data2 = $this->model->datostablas($id);
                    $data3 = $this->model->datosalertas($id);
                    $this->views->getView($this, "DetalleTablas", '', $data1, $data2, $data3);
                }
                die();
            }
        }

        //VISTA DE MONITOREO HISTÓRICO
        public function Graficas()
        {
            if (!isset($_GET['id'])) {
                header("location: " . base_url() . "Cultivos/Lista");
            } else {
                $id = Limpiar($_GET['id']);
                $data1 = $this->model->datoscultivo($id);
                if ($data1 == null) {
                    header("location: " . base_url() . "Cultivos/Lista");
                } elseif ($data1['estado'] == 1) {
                    header("location: " . base_url() . "Cultivos/Inactivos");
                } else {
                    $data2 = $this->model->datosconfiguracion($id);
                    $this->views->getView($this, "DetalleGraficas", '', $data1, $data2);
                }
                die();
            }
        }

        /*--------------------------------------------------------- 
        ----- CONTROLADORES VISTAS CULTIVOS ACTIVOS --------------
        ----------------------------------------------------------*/

        //INGRESA UNA NUEVA PLANTILLA
        public function RegistroCultivo()
        {
            $nombre = Limpiar($_POST['nombre']);
            //DATOS PLACA
            $placa = Limpiar($_POST['placa']);
            //ACTUALIZA EL USO DE LA PLACA
            $estado = 1;
            $this->model->UsoPlaca($placa, $estado);
            //DATOS PLANTILLA
            $plantilla = Limpiar($_POST['plantilla']);
            //SELECCIONA LOS DATOS DE LA PLANTILLA
            $datos = $this->model->DatosPlantilla($plantilla);
            //PASA LOS DATOS DE LA PLANTILLA A CONFIG
            $tem_max = $datos['tem_max'];
            $tem_min = $datos['tem_min'];
            $humedad_max = $datos['humedad_max'];
            $humedad_min = $datos['humedad_min'];
            $stem_max = $datos['stem_max'];
            $stem_min = $datos['stem_min'];
            $shumedad_max = $datos['shumedad_max'];
            $shumedad_min = $datos['shumedad_min'];
            $luz = $datos['luz'];
            $co2 = $datos['co2_max'];
            $altura = $datos['altura'];
            $dias = $datos['dias'];
            //DATOS FOTO PLANTILLA
            $noregistro = $this->model->contarCultivos();
            $noregistro = $noregistro['total']+1;
            // Ruta del archivo original
            $archivoOriginal = 'Assets/img/cultivos/plantillas/'.$datos['foto'];
            // Ruta de la carpeta de destino
            $carpetaDestino = 'Assets/img/cultivos/monitoreo/';
            // Separar el nombre del archivo en partes usando el punto como delimitador
            $partes = explode(".", $datos['foto']);
            $extension = $partes[1];
            // Nuevo nombre para el archivo 
            $nuevoNombre = $noregistro.'.'.$extension;
            // Combinar la ruta de la carpeta de destino con el nuevo nombre
            $rutaDestinoCompleta = $carpetaDestino.$nuevoNombre;
            // Copiar el archivo a la carpeta de destino con el nuevo nombre
            copy($archivoOriginal, $rutaDestinoCompleta);
            //INSERTA DATOS AL CULTIVO
            $agregar = $this->model->insertarCultivo($nombre, $placa);
            //INSERTA LA CONFIGURACIÓN
            $insert = $this->model->insertarConfiguracion($tem_max, $tem_min, $humedad_max, $humedad_min, $stem_max, $stem_min, $shumedad_max, $shumedad_min, $luz, $co2, $altura, $dias, $noregistro, $nuevoNombre);
            if ($insert == 'registrado') {
                $alert = 'registrado';
            } else {
                $alert = 'error';
            }
            header("location: " . base_url() . "Cultivos/Lista?msg=$alert");
            die();   
        }

        //CAMBIA DE ESTADO UNA PLANTILLA
        public function InactivarCultivo()
        {
            $id = Limpiar($_GET['id']);
            $estado = 1;
            $insert = $this->model->EstadoCultivo($id, $estado);
            $cultivo = $this->model->datoscultivo($id);
            $uso = 0;
            $cambio = $this->model->UsoPlaca($cultivo['id_placa'], $uso);
            $alert = 'inactivo';
            header("location: " . base_url() . "Cultivos/Lista?msg=$alert");
            die();   
        }

        /*--------------------------------------------------------- 
        ----------CONTROLADORES VISTAS INACTIVAS -----------------
        ----------------------------------------------------------*/

        //EN ESTA VISTA NO SE REALIZA NINGUNA ACCIÓN

        /*--------------------------------------------------------- 
        ------- CONTROLADORES VISTAS MONITOREO ----------------
        ----------------------------------------------------------*/

        //Datos para los gráficos de ultima medición
        public function UltimaMedicion()
        {
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $data1 = $this->model->SelecUltimaMedicion($id);
                $data2 = $this->model->datosconfiguracion($id);

                $response = [
                    'data1' => $data1,
                    'data2' => $data2,
                ];

                echo json_encode($response);
            } else {
                echo json_encode(['error' => 'ID no proporcionado']);
            }
            die();
        }

        /*--------------------------------------------------------- 
        ------- CONTROLADORES VISTAS CONFIGURACIÓN ----------------
        ----------------------------------------------------------*/

        //EDITAR UNA PLANTILLA***********
        public function ActualizarConfiguracion()
        {
            $nombre = Limpiar($_POST['nombre']);
            $tem_max = Limpiar($_POST['tem_max']);
            $tem_min = Limpiar($_POST['tem_min']);
            $humedad_max = Limpiar($_POST['humedad_max']);
            $humedad_min = Limpiar($_POST['humedad_min']);
            $stem_max = Limpiar($_POST['stem_max']);
            $stem_min = Limpiar($_POST['stem_min']);
            $shumedad_max = Limpiar($_POST['shumedad_max']);
            $shumedad_min = Limpiar($_POST['shumedad_min']);
            $luz = Limpiar($_POST['luz']);
            $co2 = Limpiar($_POST['co2']);
            $altura = Limpiar($_POST['altura']);
            $dias = Limpiar($_POST['dias']);
            $id = Limpiar($_POST['id']);
            $insert = $this->model->EditarConfiguracion($tem_max, $tem_min, $humedad_max, $humedad_min, $stem_max, $stem_min, $shumedad_max, $shumedad_min, $luz, $co2, $altura, $dias, $id);
            if ($insert > 0) {
                $editar = $this->model->EditarCultivo($nombre, $id);
                $alert = 'editado';
            } else {
                $alert = 'error';
            }
            header("location: " . base_url() . "Cultivos/Configuracion?id=$id&msg=$alert");
            die();   
        }

        //Cambiar Imagen de Cultivo
        public function ImagenCultivo()
        {
            $id = Limpiar($_POST['id']);
            $data = $this->model->datosconfiguracion($id);
            $imgactual = $data['foto'];
            $name = pathinfo($_FILES["archivo"]["name"]);
            $nombre_archivo = $_FILES["archivo"]["name"];
            $nombre_nuevo = $id.".".$name["extension"];
            $tipo_archivo = $_FILES["archivo"]["type"];
            $tamano_archivo = $_FILES["archivo"]["size"];
            $ruta_temporal = $_FILES["archivo"]["tmp_name"];
            $error_archivo = $_FILES["archivo"]["error"];
            $tmaximo = 20 * 1024 * 1024;
            if(($tamano_archivo < $tmaximo && $tamano_archivo != 0) && ($name["extension"] == "png" || $name["extension"] == "jpg" || $name["extension"] == "jpeg")){
                if ($error_archivo == UPLOAD_ERR_OK) {
                    unlink("Assets/img/cultivos/monitoreo/".$imgactual);
                    $ruta_destino = "Assets/img/cultivos/monitoreo/".$nombre_nuevo;
                    if (move_uploaded_file($ruta_temporal, $ruta_destino)) {
                        $this->model->EditarImgCultivo($nombre_nuevo, $id);
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
            header('location: ' . base_url() . "Cultivos/Configuracion?id=$id&msg=$alert");
            die();
        }

        /*--------------------------------------------------------- 
        ----------CONTROLADORES VISTAS DETALLE TABLAS -------------
        ----------------------------------------------------------*/

        //EN ESTA VISTA NO SE REALIZA NINGUNA ACCIÓN

        /*--------------------------------------------------------- 
        ------- CONTROLADORES VISTAS DETALLE GRÁFICAS -------------
        ----------------------------------------------------------*/

        public function GraficaTemperatura()
        {
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $data = $this->model->SelecMonitoreo($id);
                echo json_encode($data);
            } else {
                echo json_encode(['error' => 'ID no proporcionado']);
            }
            die();
        }

    }
?>