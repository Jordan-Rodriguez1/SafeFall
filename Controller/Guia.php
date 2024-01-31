<?php
    class Guia extends Controllers{
        public function __construct()
        {
            session_start();
            if (empty($_SESSION['activo'])) {
                header("location: ".base_url());
            }
            parent::__construct();
        }
        
        public function Ayuda()
        {
            $this->views->getView($this, "Ayuda");
        }
    }
?>