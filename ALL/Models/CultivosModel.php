<?php
    class CultivosModel extends Mysql{
        public $id, $nombre, $tem_max, $tem_min, $humedad_max, $humedad_min, $stem_max, $stem_min, $shumedad_max, $shumedad_min, $altura, $dias, $id_usuario, $nombre_nuevo;
        public function __construct()
        {
            parent::__construct();
        }
    
        /*--------------------------------------------------------- 
        --------------MODELOS COMPARTIDOS  ------------------------
        ----------------------------------------------------------*/

        //SELECCIONA LOS DATOS DE UNA PLANTILLA
        public function DatosPlantilla(int $id)
        {
            $this->id = $id;
            $sql = "SELECT * FROM plantillas WHERE id = '{$this->id}'";
            $res = $this->select($sql);
            return $res;
        }

        //SELECCIONA LOS DATOS DE UN CULTIVO
        public function datoscultivo(int $id)
        {
            $this->id = $id;
            $this->user = $_SESSION['id'];
            $sql = "SELECT * FROM cultivos WHERE id = '{$this->id}' AND id_usuario = '{$this->user}'";
            $res = $this->select($sql);
            return $res;
        }

        //SELECCIONA LOS DATOS DE CONFIGURACION DE UN CULTIVO
        public function datosconfiguracion(int $id)
        {
            $this->id = $id;
            $sql = "SELECT * FROM configuracion WHERE id_cultivo = '{$this->id}'";
            $res = $this->select($sql);
            return $res;
        }

        //CAMBIA EL ESTADO DE UN CULTIVO
        public function EstadoCultivo(int $id, int $estado)
        {
            $return = "";
            $this->id = $id;
            $this->estado = $estado;
            $query = "UPDATE cultivos SET estado = ? WHERE id=?";
            $data = array($this->estado, $this->id);
            $resul = $this->update($query, $data);
            $return = $resul;
            return $return;
        }

        //CAMBIA EL USO DE UNA PLACA
        public function UsoPlaca(int $id, int $estado)
        {
            $return = "";
            $this->id = $id;
            $this->estado = $estado;
            $query = "UPDATE placas SET uso = ? WHERE id_placa=?";
            $data = array($this->estado, $this->id);
            $resul = $this->update($query, $data);
            $return = $resul;
            return $return;
        }

        //SELECCIONA LAS PLANTILLAS DISPONIBLES
        public function PlantillasDisponibles()
        {
            $this->user = $_SESSION['id'];
            $sql = "SELECT * FROM plantillas WHERE id_usuario = '{$this->user}' AND estado = 0";
            $res = $this->select_all($sql);
            return $res;
        }

        //SELECCIONA LAS PLACAS DISPONIBLES
        public function PlacasDisponibles()
        {
            $this->user = $_SESSION['id'];
            $sql = "SELECT * FROM placas WHERE id_usuario = '{$this->user}' AND estado = 0 AND uso = 0";
            $res = $this->select_all($sql);
            return $res;
        }
    
        /*--------------------------------------------------------- 
        --------------MODELOS VISTAS PLANTILLA ------------------
        ----------------------------------------------------------*/

        //SELECCIONA CULTIVOS ACTIVOS
        public function CultivosActivos()
        {
            $this->user = $_SESSION['id'];
            $sql = "SELECT cultivos.*, configuracion.foto FROM cultivos, configuracion WHERE estado = 0 AND id_usuario = '{$this->user}' AND configuracion.id_cultivo = cultivos.id";
            $res = $this->select_all($sql);
            return $res;
        }

        //Registra una nueva plantilla
        public function insertarCultivo(string $nombre, string $placa)
        {
            $return = "";
            $this->nombre = $nombre;
            $this->placa = $placa;
            $this->user = $_SESSION['id'];
            $query = "INSERT INTO cultivos(nombre, id_placa, id_usuario) VALUES (?,?,?)";
            $data = array($this->nombre, $this->placa, $this->user);
            $resul = $this->insert($query, $data);
            $return = "registrado";
            return $return;
        }

        //Registra una nueva plantilla
        public function insertarConfiguracion(string $tem_max, string $tem_min, string $humedad_max, string $humedad_min, string $stem_max, string $stem_min, string $shumedad_max, string $shumedad_min, string $luz, string $co2, string $altura, string $dias, string $id_cultivo, string $nombre_nuevo)
        {
            $return = "";
            $this->tem_max = $tem_max;
            $this->tem_min = $tem_min;
            $this->humedad_max = $humedad_max;
            $this->humedad_min = $humedad_min;
            $this->stem_max = $stem_max;
            $this->stem_min = $stem_min;
            $this->shumedad_max = $shumedad_max;
            $this->shumedad_min = $shumedad_min;
            $this->luz = $luz;
            $this->co2 = $co2;
            $this->altura = $altura;
            $this->dias = $dias;
            $this->id_cultivo = $id_cultivo;
            $this->nombre_nuevo = $nombre_nuevo;
            $query = "INSERT INTO configuracion(tem_max, tem_min, humedad_max, humedad_min, stem_max, stem_min, shumedad_max, shumedad_min, luz, co2_max, altura, dias, id_cultivo, foto) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $data = array($this->tem_max, $this->tem_min, $this->humedad_max, $this->humedad_min, $this->stem_max, $this->stem_min, $this->shumedad_max, $this->shumedad_min, $this->luz, $this->co2, $this->altura, $this->dias, $this->id_cultivo, $this->nombre_nuevo);
            $resul = $this->insert($query, $data);
            $return = "registrado";
            return $return;
        }

        //SELECCIONA PLANTILLA ACTIVAS
        public function contarCultivos()
        {
            $sql = "SELECT COUNT(*) AS total FROM cultivos";
            $res = $this->select($sql);
            return $res;
        }

        /*--------------------------------------------------------- 
        --------------MODELOS VISTAS INACTIVAS -------------------
        ----------------------------------------------------------*/

        //SELECCIONA PLACAS ACTIVAS
        public function CultivosInactivos()
        {
            $this->user = $_SESSION['id'];
            $sql = "SELECT cultivos.*, configuracion.foto FROM cultivos, configuracion WHERE estado = 1 AND id_usuario = '{$this->user}' AND configuracion.id_cultivo = cultivos.id";
            $res = $this->select_all($sql);
            return $res;
        }

        /*--------------------------------------------------------- 
        ---------- MODELOS VISTAS CONFIGURACIÓN -------------------
        ----------------------------------------------------------*/

        //EDITAR CONFIGURACION DE CULTIVO
        public function EditarConfiguracion(string $tem_max, string $tem_min, string $humedad_max, string $humedad_min, string $stem_max, 
                                        string $stem_min, string $shumedad_max, string $shumedad_min, string $luz, string $co2, string $altura, string $dias, string $id)
        {
            $return = "";
            $this->tem_max = $tem_max;
            $this->tem_min = $tem_min;
            $this->humedad_max = $humedad_max;
            $this->humedad_min = $humedad_min;
            $this->stem_max = $stem_max;
            $this->stem_min = $stem_min;
            $this->shumedad_max = $shumedad_max;
            $this->shumedad_min = $shumedad_min;
            $this->luz = $luz;
            $this->co2 = $co2;
            $this->altura = $altura;
            $this->dias = $dias;
            $this->id = $id;
            $query = "UPDATE configuracion SET tem_max=?, tem_min=?, humedad_max=?, humedad_min=?, stem_max=?, stem_min=?, 
                        shumedad_max=?, shumedad_min=?, luz=?, co2_max=?, altura=?, dias=? WHERE id_cultivo=?";
            $data = array($this->tem_max, $this->tem_min, $this->humedad_max, $this->humedad_min, $this->stem_max, $this->stem_min, 
                        $this->shumedad_max, $this->shumedad_min, $this->luz, $this->co2, $this->altura, $this->dias, $this->id);
            $resul = $this->update($query, $data);
            return $resul;
        }

        //EDITAR NOMBRE CULTIVO
        public function EditarCultivo(string $nombre, string $id)
        {
            $return = "";
            $this->nombre = $nombre;
            $this->id = $id;
            $query = "UPDATE cultivos SET nombre=? WHERE id=?";
            $data = array($this->nombre, $this->id);
            $resul = $this->update($query, $data);
        }

        //EDITAR IMAGEN PLANTILLA
        public function EditarImgCultivo(string $nombre, string $id)
        {
            $return = "";
            $this->nombre = $nombre;
            $this->id = $id;
            $query = "UPDATE configuracion SET foto=? WHERE id_cultivo=?";
            $data = array($this->nombre, $this->id);
            $resul = $this->update($query, $data);
        }

        /*--------------------------------------------------------- 
        --------------- MODELOS VISTAS MONITOREO ------------------
        ----------------------------------------------------------*/

        //SELECCIONA LA ULTIMA MEDICIÓN DEL CUTLIVO
        public function SelecUltimaMedicion(int $id)
        {
            $this->id = $id;
            $sql = "SELECT * FROM monitoreo WHERE id_cultivo = '{$this->id}' ORDER BY fecha DESC LIMIT 1;";
            $res = $this->select($sql);
            return $res;
        }

        /*--------------------------------------------------------- 
        ---------- MODELOS VISTAS DETALLE TABLAS ------------------
        ----------------------------------------------------------*/
    
        //SELECCIONA DATOS DE MONITOREO
        public function datostablas(int $id)
        {
            $this->id = $id;
            $sql = "SELECT * FROM monitoreo WHERE id_cultivo = '{$this->id}'";
            $res = $this->select_all($sql);
            return $res;
        }

        //SELECCIONA ACCIONES REALIZADAS
        public function datosalertas(int $id)
        {
            $this->id = $id;
            $sql = "SELECT * FROM acciones WHERE id_cultivo = '{$this->id}'";
            $res = $this->select_all($sql);
            return $res;
        }

        /*--------------------------------------------------------- 
        -------- MODELOS VISTAS DETALLE GRÁFICAS ------------------
        ----------------------------------------------------------*/

        //SELECCIONA LOS ULTIMOS 100 DATOS DEL CULTIVO
        public function SelecMonitoreo(int $id)
        {
            $this->id = $id;
            $sql = "SELECT * FROM (SELECT * FROM monitoreo WHERE id_cultivo = '{$this->id}' ORDER BY fecha DESC LIMIT 100) AS subquery ORDER BY fecha ASC;";
            $res = $this->select_all($sql);
            return $res;
        }



    }
?>