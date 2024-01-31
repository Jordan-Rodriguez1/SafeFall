<?php
    class UsuariosModel extends Mysql{
        public $id, $usuario, $nombre, $correo, $rol, $clave, $estado, $perfil;
        public function __construct()
        {
            parent::__construct();
        }
    
        /*--------------------------------------------------------- 
        --------------- MODELOS VISTAS PERFIL ---------------------
        ----------------------------------------------------------*/
    
        //Edita los datos de un usuario
        public function actualizarUsuario(string $nombre, string $apellido, int $id, string $correo)
        {
            $return = "";
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->id = $id;
            $this->correo = $correo;
            $query = "UPDATE usuarios SET nombre=?, apellido=?, correo=? WHERE id=?";
            $data = array($this->nombre, $this->apellido, $this->correo, $this->id);
            $resul = $this->update($query, $data);
            $return = $resul;
            return $return;
        }
    
        //verifica contraseña actual para cambiarla
        public function verificarPass(string $clave, int $id)
        {
            $this->clave = $clave;
            $this->id = $id;
            $query = "SELECT * FROM usuarios WHERE clave = '$clave' AND id = '$id'";
            $resul = $this->select($query);
            return $resul;
        }
    
        //cambia contraseña actual
        public function cambiarContra(string $clave, int $id)
        {
            $this->clave = $clave;
            $this->id = $id;
            $query = "UPDATE usuarios SET clave = ? WHERE id = ?";
            $data = array($this->clave, $this->id);
            $resul = $this->update($query, $data);
            return $resul;
        }
    
        //Seleciona los datos de un usuario para obtener nombre actual de img
        public function editarUsuarios(int $id)
        {
            $this->id = $id;
            $sql = "SELECT * FROM usuarios WHERE id = '{$this->id}'";
            $res = $this->select($sql);
            if (empty($res)) {
                $res = 0;
            }
            return $res;
        }

        //cambia ruta de imagen cargada
        public function img (string $perfil, int $id)
        {
            $this->perfil = $perfil;
            $this->id = $id;
            $query = "UPDATE usuarios SET perfil = ? WHERE id = ?";
            $data = array($this->perfil, $this->id);
            $resul = $this->update($query, $data);
            return $resul;
        }
    }
?>