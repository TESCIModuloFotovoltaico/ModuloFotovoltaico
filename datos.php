<?php
$conexion = new mysqli("localhost", "usuario", "contraseña", "nombre_base_datos");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$sql = "SELECT fecha, valor FROM datos_panel ORDER BY fecha ASC";
$resultado = $conexion->query($sql);

$datos = [];

while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
}

echo json_encode($datos);
?>
