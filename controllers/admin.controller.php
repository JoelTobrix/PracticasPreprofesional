<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);


$conexion = new mysqli("localhost", "interpc", "Codex2017.@1987", "interpc.net@");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if (isset($_POST['codigo'])) {
    $code = $_POST['codigo'];

    // Consulta SQL con la tabla correcta
    $sql_consultar = "SELECT * FROM codigo_admin WHERE codigo = ?";
    $stmt = $conexion->prepare($sql_consultar);

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si se encuentra el código
    if ($result->num_rows > 0) {
        $_SESSION['autenticado'] = true;

        header("Location: ../views/admin/products.php"); 
        exit; 
    } else {   
        echo "Código incorrecto";

         header("Location: ../views/admin/admin.php/?error=incorrecto");
         exit;
    }

    $stmt->close();
} else {

    echo "Error: no se envió el código";
 
     header("Location: ../views/admin/admin.php");
     exit;
}

$conexion->close();
?>