<?php
    class PlantillasModel extends Mysql{
        public $id, $nombre, $tem_max, $tem_min, $humedad_max, $humedad_min, $stem_max, $stem_min, $shumedad_max, $shumedad_min, $altura, $dias, $id_usuario, $nombre_nuevo;
        public function __construct()
        {
            parent::__construct();
        }
    
        /*--------------------------------------------------------- 
        --------------MODELOS COMPARTIDOS  ------------------------
        ----------------------------------------------------------*/

        //SELECCIONA LOS DATOS DE UNA PLANTILLA
        public function datosplantilla(int $id)
        {
            $this->id = $id;
            $this->user = $_SESSION['id'];
            $sql = "SELECT * FROM plantillas WHERE id = '{$this->id}' AND id_usuario = '{$this->user}' AND estado = 0";
            $res = $this->select($sql);
            return $res;
        }

        //CAMBIA EL ESTADO DE UNA PLANTILLA
        public function EstadoPlantilla(int $id, int $estado)
        {
            $return = "";
            $this->id = $id;
            $this->estado = $estado;
            $query = "UPDATE plantillas SET estado = ? WHERE id=?";
            $data = array($this->estado, $this->id);
            $resul = $this->update($query, $data);
            $return = $resul;
            return $return;
        }
    
        /*--------------------------------------------------------- 
        --------------MODELOS VISTAS PLANTILLA ------------------
        ----------------------------------------------------------*/

        //SELECCIONA PLANTILLAS ACTIVAS
        public function plantillasactivas()
        {
            $this->user = $_SESSION['id'];
            $sql = "SELECT * FROM plantillas WHERE estado = 0 AND id_usuario = '{$this->user}'";
            $res = $this->select_all($sql);
            return $res;
        }

        //CUENTA LAS PLANTILLAS EXISTENTES
        public function contarplantillas()
        {
            $sql = "SELECT COUNT(*) AS total FROM plantillas";
            $res = $this->select($sql);
            return $res;
        }

        //Registra una nueva plantilla
        public function insertarPlantilla(string $nombre, string $tem_max, string $tem_min, string $humedad_max, string $humedad_min, string $stem_max, string $stem_min, string $shumedad_max, string $shumedad_min, string $luz, string $co2, string $altura, string $dias, string $usuario, string $nombre_nuevo)
        {
            $return = "";
            $this->nombre = $nombre;
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
            $this->usuario = $usuario;
            $this->nombre_nuevo = $nombre_nuevo;
            $query = "INSERT INTO plantillas(nombre, tem_max, tem_min, humedad_max, humedad_min, stem_max, stem_min, shumedad_max, shumedad_min, luz, co2_max, altura, dias, id_usuario, foto) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $data = array($this->nombre, $this->tem_max, $this->tem_min, $this->humedad_max, $this->humedad_min, $this->stem_max, $this->stem_min, $this->shumedad_max, $this->shumedad_min, $this->luz, $this->co2, $this->altura, $this->dias, $this->usuario, $this->nombre_nuevo);
            $resul = $this->insert($query, $data);
            $return = "registrado";
            return $return;
        }

        /*--------------------------------------------------------- 
        --------------MODELOS VISTAS INACTIVAS -------------------
        ----------------------------------------------------------*/

        //SELECCIONA PLANTILLA INACTIVAS
        public function plantillasInactivas()
        {
            $this->user = $_SESSION['id'];
            $sql = "SELECT * FROM plantillas WHERE estado = 1 AND id_usuario = '{$this->user}'";
            $res = $this->select_all($sql);
            return $res;
        }

        /*--------------------------------------------------------- 
        --------------MODELOS VISTAS DETALLE -------------------
        ----------------------------------------------------------*/

        //EDITAR UNA PLANTILLA
        public function EditarPlantilla(string $nombre, string $tem_max, string $tem_min, string $humedad_max, string $humedad_min, string $stem_max, 
                                        string $stem_min, string $shumedad_max, string $shumedad_min, string $luz, string $co2, string $altura, 
                                        string $dias, string $id)
        {
            $return = "";
            $this->nombre = $nombre;
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
            $query = "UPDATE plantillas SET nombre=?, tem_max=?, tem_min=?, humedad_max=?, humedad_min=?, stem_max=?, stem_min=?, 
                        shumedad_max=?, shumedad_min=?, luz=?, co2_max=?, altura=?, dias=? WHERE id=?";
            $data = array($this->nombre, $this->tem_max, $this->tem_min, $this->humedad_max, $this->humedad_min, $this->stem_max, $this->stem_min, 
                        $this->shumedad_max, $this->shumedad_min, $this->luz, $this->co2, $this->altura, $this->dias, $this->id);
            $resul = $this->update($query, $data);
            return $resul;
        }

        //EDITAR IMAGEN PLANTILLA
        public function EditarImgPlantilla(string $nombre, string $id)
        {
            $return = "";
            $this->nombre = $nombre;
            $this->id = $id;
            $query = "UPDATE plantillas SET foto=? WHERE id=?";
            $data = array($this->nombre, $this->id);
            $resul = $this->update($query, $data);
        }
    
    }
?>