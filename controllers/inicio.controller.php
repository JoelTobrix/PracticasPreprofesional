<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$conexion = new mysqli("localhost", "interpc", "Codex2017.@1987", "interpc.net@"); // Info

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if (isset($_POST['correo']) && isset($_POST['contraseña'])) {

    $mail = $_POST['correo'];
    $pass = $_POST['contraseña'];

    $sql_consultar = "SELECT * FROM usuario WHERE email = ?";
    $stmt = $conexion->prepare($sql_consultar);
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($pass, $row['password'])) {
            $_SESSION['usuario'] = $row['email']; // Guarda el usuario en sesión
            header("Location: ../views/interpc.php");
            exit();
        } else {
            $_SESSION['error'] = "Contraseña incorrecta.";
            header("Location: ../views/login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Correo no registrado.";
        header("Location: ../views/login.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Complete los campos.";
    header("Location: ../views/login.php");
    exit();
}

$conexion->close();
?>

