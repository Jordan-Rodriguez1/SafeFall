<?php
    class LoginModel extends Mysql{
    
        public function __construct()
        {
            parent::__construct();
        }
    
        //Validad contraseña de usuario
        public function selectUsuario(string $usuario, string $clave)
        {
            $this->usuario = $usuario;
            $this->clave = $clave;
            $sql = "SELECT * FROM usuarios WHERE correo = '{$this->usuario}' AND clave = '{$this->clave}'";
            $res = $this->select($sql);
            return $res;
        }
    
        //Seleciona los datos de un usuario mediante correo
        public function editarUsuariosC(string $correo)
        {
            $this->correo = $correo;
            $sql = "SELECT * FROM usuarios WHERE correo = '{$this->correo}'";
            $res = $this->select($sql);
            if (empty($res)) {
                $res = 0;
            }
            return $res;
        }
    
        //Registra un nuevo usuario
        public function insertarUsuarios(string $nombre, string $apellido, string $correo, string $clave)
        {
            $return = "";
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->correo = $correo;
            $this->clave = $clave;
            $sql = "SELECT * FROM usuarios WHERE correo = '{$this->correo}'";
            $result = $this->selecT($sql);
            if (empty($result)) {
                $query = "INSERT INTO usuarios(nombre, apellido, correo, clave) VALUES (?,?,?,?)";
                $data = array($this->nombre, $this->apellido, $this->correo, $this->clave);
                $resul = $this->insert($query, $data);
                $return = "registrado";
            }else {
                $return = "existe";
            }
            return $return;
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
    
    }
?>