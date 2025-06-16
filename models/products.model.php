<?php
header('Content-Type: application/json');

$conexion = new mysqli("localhost", "interpc", "Codex2017.@1987", "interpc.net@"); 

if ($conexion->connect_error) {
    echo json_encode(["error" => "Error de conexión: " . $conexion->connect_error]);
    exit;
}

$sql = "SELECT producto_id, nombre, descripcion, precio, stock, categoria, imagen FROM producto";
$result = $conexion->query($sql);

$productos = [];

while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

echo json_encode($productos);

$conexion->close();
