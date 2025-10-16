<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

$servidor_bd='localhost';
$usuario_bd ='root';
$contrasena_bd='';
$nombre_bd='Vainilla';

$conexion = new mysqli($servidor_bd, $usuario_bd, $contrasena_bd, $nombre_bd);

if ($conexion->connect_error) {
    die("ERROR DE CONEXIÓN A MYSQL" . $conexion->connect_error);
}
if (!$conexion->set_charset("utf8mb4")) {
    die("Error al configurar UTF-8: " . $conexion->error);
}
?>