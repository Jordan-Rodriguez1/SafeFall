<?php
    class EspModel extends Mysql{
    
        public function __construct()
        {
            parent::__construct();
        }

        //Registra una nuevo placa
        public function BuscarCultivo(string $id_placa)
        {
            $return = "";
            $this->id_placa = $id_placa;
            $sql = "SELECT * FROM cultivos WHERE id_placa = '{$this->id_placa}' AND estado = 0";
            $result = $this->selecT($sql);
            return $result;
        }

        //Registra una nuevo placa
        public function insertarMonitoreo(string $id_cultivo, string $tem, string $humendad, string $stem, string $shumendad, string $lum, string $co2, string $altura)
        {
            $return = "";
            $this->id_cultivo = $id_cultivo;
            $this->tem = $tem;
            $this->humendad = $humendad;
            $this->stem = $stem;
            $this->shumendad = $shumendad;
            $this->lum = $lum;
            $this->co2 = $co2;
            $this->altura = $altura;
            $query = "INSERT INTO monitoreo(id_cultivo, tem, humendad, stem, shumendad, lum, co2, altura) VALUES (?,?,?,?,?,?,?,?)";
            $data = array($this->id_cultivo, $this->tem, $this->humendad, $this->stem, $this->shumendad, $this->lum, $this->co2, $this->altura);
            $resul = $this->insert($query, $data);
            return $resul;
        }

        //Trae la configuración del cultivo.
        public function CultivoConfiguracion(string $id_cultivo)
        {
            $return = "";
            $this->id_cultivo = $id_cultivo;
            $sql = "SELECT * FROM configuracion WHERE id_cultivo = '{$this->id_cultivo}'";
            $result = $this->select($sql);
            return $result;
        }

        //Trae la configuración del cultivo.
        public function DatosUsuario(string $id_usuario)
        {
            $return = "";
            $this->id_usuario = $id_usuario;
            $sql = "SELECT * FROM usuarios WHERE id = '{$this->id_usuario}'";
            $result = $this->select($sql);
            return $result;
        }

        //Registra una nueva notificación
        public function insertarNotificaciones(string $id_usuario, string $descripcion, string $relevancia)
        {
            $return = "";
            $this->id_usuario = $id_usuario;
            $this->descripcion = $descripcion;
            $this->relevancia = $relevancia;
            $query = "INSERT INTO notificaciones(id_usuario, descripcion, relevancia) VALUES (?,?,?)";
            $data = array($this->id_usuario, $this->descripcion, $this->relevancia);
            $resul = $this->insert($query, $data);
            return $return;
        }

        //CAMBIA EL ESTADO DE ALERTA DE UN CULTIVO
        public function CultivoAlerta(int $id_cultivo, int $alerta)
        {
            $return = "";
            $this->id_cultivo = $id_cultivo;
            $this->alerta = $alerta;
            $query = "UPDATE cultivos SET alerta = ? WHERE id=?";
            $data = array($this->alerta, $this->id_cultivo);
            $resul = $this->update($query, $data);
            $return = $resul;
            return $return;
        }

        //Registra una nueva acción
        public function insertarAcciones(string $id_cultivo, string $descripcion, string $codigo)
        {
            $return = "";
            $this->id_cultivo = $id_cultivo;
            $this->descripcion = $descripcion;
            $this->codigo = $codigo;
            $query = "INSERT INTO acciones(id_cultivo, descripcion, codigo) VALUES (?,?,?)";
            $data = array($this->id_cultivo, $this->descripcion, $this->codigo);
            $resul = $this->insert($query, $data);
            return $return;
        }
    
    }
?>