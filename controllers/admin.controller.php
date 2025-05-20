<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$conexion = new mysqli("localhost", "interpc", "Codex2017.@1987", "interpc.net@");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if (isset($_POST['codigo'])) {
    $code = $_POST['codigo'];

    $sql_consultar = "SELECT * FROM codigo_admin WHERE codigo = ?";
    $stmt = $conexion->prepare($sql_consultar);
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Bienvenido";
    } else {
        echo "Código incorrecto";
    }

    $stmt->close();
} else {
    echo "Error: no se envió el código";
}

$conexion->close();
?>
