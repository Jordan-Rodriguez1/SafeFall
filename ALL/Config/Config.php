<?php
    //const BASE_URL = "http://localhost/safefall/";
    const BASE_URL = "http://192.168.1.9/safefall/";
    const HOST = "localhost";
    const BD = "safefall";
    const DB_USER = "root";
    const PASS = "";
    const CHARSET = "charset=utf8";

    //AJUSTA EL HORARIO AL LOCAL
    date_default_timezone_set('America/Mexico_City'); 
	setlocale(LC_ALL,'es_ES', 'Spanish_Spain', 'Spanish');
    error_reporting(0); 

    //PONE EL DOMINIO PARA EL SIDEBAR
    const DOM = "/safefall";

    // Establecer un nuevo límite de tiempo de ejecución a 600 segundos (5 minutos)
    set_time_limit(600);
?>