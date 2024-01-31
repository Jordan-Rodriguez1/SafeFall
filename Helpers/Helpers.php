<?php
function base_url()
{
    return BASE_URL;
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
?>