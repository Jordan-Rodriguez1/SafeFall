<?php
    class GuiaModel extends Mysql{
        public $id, $usuario, $nombre, $correo, $rol, $clave, $estado, $perfil;
        public function __construct()
        {
            parent::__construct();
        }
    
        //Selecciona usuarios activos
        public function selectUsuarios()
        {
            $sql = "SELECT * FROM usuarios WHERE estado = 1";
            $res = $this->select_all($sql);
            return $res;
        }
    
    }
?>