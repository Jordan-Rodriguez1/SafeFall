<?php
    class ControlModel extends Mysql{
        public $id, $id_placa, $nombre, $id_usuario, $estado, $uso;
        public function __construct()
        {
            parent::__construct();
        }

        /*--------------------------------------------------------- 
        --------------MODELOS COMPARTIDOS  ------------------------
        ----------------------------------------------------------*/

        //SELECCIONA LOS DATOS DE UNA PLACA
        public function datosplaca(int $id)
        {
            $this->id = $id;
            $sql = "SELECT * FROM placas WHERE id = '{$this->id}'";
            $res = $this->select($sql);
            return $res;
        }

        //CAMBIA EL ESTADO DE UNA PLACA
        public function EstadoPlaca(int $id, int $estado)
        {
            $return = "";
            $this->id = $id;
            $this->estado = $estado;
            $query = "UPDATE placas SET estado = ? WHERE id=?";
            $data = array($this->estado, $this->id);
            $resul = $this->update($query, $data);
            $return = $resul;
            return $return;
        }
    
        /*--------------------------------------------------------- 
        --------------MODELOS VISTAS PLACA ------------------
        ----------------------------------------------------------*/

        //SELECCIONA PLACAS ACTIVAS
        public function placasactivas()
        {
            $this->user = $_SESSION['id'];
            $sql = "SELECT * FROM placas WHERE estado = 0  AND id_usuario = '{$this->user}'";
            $res = $this->select_all($sql);
            return $res;
        }

        //Registra una nuevo placa
        public function insertarPlaca(string $nombre, string $key, string $usuario)
        {
            $return = "";
            $this->nombre = $nombre;
            $this->key = $key;
            $this->usuario = $usuario;
            $sql = "SELECT * FROM placas WHERE id_placa = '{$this->key}'";
            $result = $this->selecT($sql);
            if (empty($result)) {
                $query = "INSERT INTO placas(nombre, id_placa, id_usuario) VALUES (?,?,?)";
                $data = array($this->nombre, $this->key, $this->usuario);
                $resul = $this->insert($query, $data);
                $return = "registrado";
            }else {
                $return = "existe";
            }
            return $return;
        }

        //EDITAR UNA PLACA
        public function EditarPlaca(string $nombre, string $key, string $id)
        {
            $return = "";
            $this->nombre = $nombre;
            $this->key = $key;
            $this->id = $id;
            $sql = "SELECT * FROM placas WHERE id_placa = '{$this->key}'";
            $result = $this->selecT($sql);
            if (empty($result)) {
                $query = "UPDATE placas SET nombre = ?, id_placa = ? WHERE id=?";
                $data = array($this->nombre, $this->key, $this->id);
                $resul = $this->update($query, $data);
                $return = "registrado";
            }else {
                $return = "existe";
            }
            return $return;
        }

        /*--------------------------------------------------------- 
        --------------MODELOS VISTAS INACTIVAS -------------------
        ----------------------------------------------------------*/

        //SELECCIONA PLACAS ACTIVAS
        public function placasinactivas()
        {
            $this->user = $_SESSION['id'];
            $sql = "SELECT * FROM placas WHERE estado = 1 AND id_usuario = '{$this->user}'";
            $res = $this->select_all($sql);
            return $res;
        }
    
    }
?>