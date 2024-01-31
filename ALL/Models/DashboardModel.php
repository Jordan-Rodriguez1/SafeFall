<?php
    class DashboardModel extends Mysql{
        public $id, $usuario, $nombre, $correo, $rol, $clave, $estado, $perfil;
        public function __construct()
        {
            parent::__construct();
        }
    
        //SELECCIONA LOS DATOS DE UNA PLANTILLA
        public function TotalCultivos()
        {
            $this->user = $_SESSION['id'];
            $sql = "SELECT SUM(CASE WHEN alerta = 0 THEN 1 ELSE 0 END) AS alerta_0, SUM(CASE WHEN alerta = 1 OR alerta = 2 THEN 1 ELSE 0 END) AS alerta_1 FROM cultivos WHERE id_usuario = '{$this->user}' AND estado = 0;";
            $res = $this->select($sql);
            return $res;
        }

        //SELECCIONA LOS DATOS DE UNA PLANTILLA
        public function AvanceCultivos()
        {
            $this->user = $_SESSION['id'];
            $sql = "SELECT c.nombre, m1.altura AS altura_m, co.altura, DATEDIFF(CURDATE(), c.fecha ) AS DiferenciaDias, co.dias FROM cultivos c 
                    LEFT JOIN ( SELECT id_cultivo, MAX(fecha) AS ultima_fecha FROM monitoreo GROUP BY id_Cultivo ) m2 ON c.id = m2.id_cultivo 
                    LEFT JOIN configuracion co ON c.id = co.id_cultivo LEFT JOIN monitoreo m1 ON m2.id_cultivo = m1.id_cultivo AND m2.ultima_fecha = m1.fecha 
                    WHERE c.estado = 0 AND id_usuario = '{$this->user}';";
            $res = $this->select_all($sql);
            return $res;
        }

        //SELECCIONA LOS DATOS DE NOTIFICACIONES
        public function MostrarNotificaciones()
        {
            $this->user = $_SESSION['id'];
            $sql = "SELECT * FROM notificaciones WHERE id_usuario = '{$this->user}' AND estado = 0;";
            $res = $this->select_all($sql);
            return $res;
        }

        //CAMBIA EL ESTADO DE ALERTA DE UNA NOTIFICACIÓN
        public function EliminarNotificacion(int $id)
        {
            $return = "";
            $this->id = $id;
            $query = "UPDATE notificaciones SET estado = 1 WHERE id=?";
            $data = array($this->id);
            $resul = $this->update($query, $data);
            $return = $resul;
            return $return;
        }
    
    }
?>