<?php
function base_url()
{
    return BASE_URL;
}

function encabezado($data="")
{
    $VistaH = "Views/Template/header.php";
    require_once($VistaH);
}

function pie($data="")
{
    $VistaP = "Views/Template/footer.php";
    require_once($VistaP);
}

function encabezadologin($data="")
{
    $VistaHL = "Views/Template/header_login.php";
    require_once($VistaHL);
}

function pielogin($data="")
{
    $VistaPL = "Views/Template/footer_login.php";
    require_once($VistaPL);
}

function Limpiar($dato)
{
    // Eliminar espacios en blanco al principio y al final
    $dato = trim($dato);
    // Eliminar barras invertidas
    $dato = stripslashes($dato);
    // Convertir caracteres especiales en entidades HTML
    $dato = htmlspecialchars($dato);
    return $dato;
}

// Utilizar los espacios de nombres necesarios
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception; 

/* Clase para tratar con excepciones y errores */
require 'Assets/PHPMailer/src/Exception.php';
/* Clase PHPMailer */
require 'Assets/PHPMailer/src/PHPMailer.php';
/*Clase SMTP necesaria para conectarte a un servidor SMTP */
require 'Assets/PHPMailer/src/SMTP.php';

//Función para envair correos
function EnviarCorreo($correo, $nombre, $asunto, $cuerpo)
{
        // Intentar crear una nueva instancia de la clase PHPMailer
        $mail = new PHPMailer (true);
    
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        // Datos personales
        $mail->Host = "smtp.gmail.com";
        $mail->Port = "465";
        $mail->Username = "icaroooard@gmail.com";
        $mail->Password = "ooyzmbmuyupnlsgq";
        $mail->SMTPSecure = "ssl";
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);
    
        // Remitente
        $mail->setFrom('icaroooard@gmail.com', 'CULTECH');
        // Destinatario, opcionalmente también se puede especificar el nombre
        $mail->addAddress($correo, $nombre);
    
        // Asunto
        $mail->Subject = $asunto;
        // Contenido HTML
        $mail->Body = $cuerpo."<br><br>".'Mensaje generado automaticamente, favor de no responder.';
    
        // Agregar archivo adjunto
        //$mail->send();
}

function generarContrasenaAleatoria($longitud = 12) {
    // Caracteres que se pueden usar en la contraseña
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+[]{}|;:,.<>?';

    // Generar bytes aleatorios
    $bytesAleatorios = random_bytes($longitud);

    // Convertir bytes en una cadena legible
    $contrasena = '';
    for ($i = 0; $i < $longitud; $i++) {
        $indice = ord($bytesAleatorios[$i]) % strlen($caracteres);
        $contrasena .= $caracteres[$indice];
    }

    return $contrasena;
}

//Para esta función debe ser en cascada, es decir poner los códigos menos importantes arriba y los más abajo.
function EvaluarMinMax($medicion, $min, $max, $nombre) {
    
    $rango = ($max - $min) * 0.1;
    $minrango = $min + $rango;
    $maxrango = $max - $rango;

    if ($medicion <= $min) {
        $codigo = 3001;
    } elseif ($medicion >= $max) {
        $codigo = 3002;
    } elseif ($medicion <= $minrango) {
        $codigo = 2001;
    } elseif ($medicion >= $maxrango) {
        $codigo = 2002;
    } else {
        $codigo = 0;
    }

    switch ($codigo) {
        case 2001:
            $resultados = array(
            'codigo' => 2001,
            'descripcion' => "Precaución: se está llegando al rango mínimo de $nombre, toma precauciones.",
            'relevancia' => 1
            );
            break;
        case 2002:
            $resultados = array(
            'codigo' => 2002,
            'descripcion' => "Precaución: se está llegando al rango máximo de $nombre, toma precauciones.",
            'relevancia' => 1
            );
            break;
        case 3001:
            $resultados = array(
            'codigo' => 3001,
            'descripcion' => "Alerta: se llegó al rango mínimo de $nombre, realiza acciones necesarias.",
            'relevancia' => 2
            );
            break;
        case 3002:
            $resultados = array(
            'codigo' => 3002,
            'descripcion' => "Alerta: se llegó al rango máximo de $nombre, realiza acciones necesarias.",
            'relevancia' => 2
            );
            break;
        default:
            $resultados = array(
            'codigo' => 0,
            'descripcion' => '',
            'relevancia' => 0
            );
            break;
    }
    return $resultados;
}

//Para esta función debe ser en cascada, es decir poner los códigos menos importantes arriba y los más abajo.
function EvaluarMax($medicion, $max, $nombre) {
    
    $maxrango = $max - $max * 0.1;

    if ($medicion >= $max) {
        $codigo = 3002;
    } elseif ($medicion >= $maxrango) {
        $codigo = 2002;
    } else {
        $codigo = 0;
    }

    switch ($codigo) {
        case 2002:
            $resultados = array(
            'codigo' => 2002,
            'descripcion' => "Precaución: se está llegando al rango máximo de $nombre, toma precauciones.",
            'relevancia' => 1
            );
            break;
        case 3002:
            $resultados = array(
            'codigo' => 3002,
            'descripcion' => "Alerta: se llegó al rango máximo de $nombre, realiza acciones necesarias.",
            'relevancia' => 2
            );
            break;
        default:
            $resultados = array(
            'codigo' => 0,
            'descripcion' => '',
            'relevancia' => 0
            );
            break;
    }
    return $resultados;
}

//NOTIFICACIONES
function notificaciones() {  

	// Configuración de la conexión a la base de datos
    $servername = HOST;
    $username = DB_USER;
    $password = PASS;
    $dbname = BD;

    try {
        // Crear una nueva conexión PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        // Configurar el modo de error de PDO para mostrar excepciones
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Ejecutar la consulta
        $sql = "SELECT COUNT(*) AS total FROM notificaciones WHERE id_usuario = '{$_SESSION['id']}' AND estado = 0";
        $querry = $conn->prepare($sql);
        $querry->execute();
        $data = $querry->fetchAll(PDO::FETCH_ASSOC);

       // Cerrar la conexión
       $conn = null;
    } catch (PDOException $e) {
       echo "Error de conexión: " . $e->getMessage();
    }
							
    //VARIABLES GLOBALES
    $dato = $data[0]['total'];
    return $dato;
}

//NOTIFICACIONES
function ultimasnotificaciones() {  

	// Configuración de la conexión a la base de datos
    $servername = HOST;
    $username = DB_USER;
    $password = PASS;
    $dbname = BD;

    try {
        // Crear una nueva conexión PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        // Configurar el modo de error de PDO para mostrar excepciones
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Ejecutar la consulta
        $sql = "SELECT * FROM notificaciones WHERE id_usuario = '{$_SESSION['id']}' AND estado = 0 ORDER BY fecha DESC LIMIT 3";
        $querry = $conn->prepare($sql);
        $querry->execute();
        $data = $querry->fetchAll(PDO::FETCH_ASSOC);

       // Cerrar la conexión
       $conn = null;
    } catch (PDOException $e) {
       echo "Error de conexión: " . $e->getMessage();
    }
							
    //VARIABLES GLOBALES
    return $data;
}

?>