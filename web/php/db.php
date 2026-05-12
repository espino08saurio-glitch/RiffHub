<?php
$host = 'localhost';
$user = 'riffh_resenyes';
$password = 'POSA_AQUI_LA_CONTRASENYA';
$dbname = 'riffh_resenyes';

$conexion = new mysqli($host, $user, $password, $dbname);

if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}

if (!$conexion->set_charset('utf8mb4')) {
    $conexion->set_charset('utf8');
}
?>
