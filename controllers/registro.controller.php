<?php
// Mostrar errores en desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión
$conexion = new mysqli("localhost", "interpc", "Codex2017.@1987", "interpc.net@");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar si llegan todos los campos del formulario
if (isset($_POST['nombre'], $_POST['correo'], $_POST['contrasena'], $_POST['direccion'], $_POST['telefono'])) {
    $name = $_POST['nombre'];
    $email = $_POST['correo'];
    $pass = $_POST['contrasena'];
    $direction = $_POST['direccion'];
    $telf = $_POST['telefono'];

    // Encriptar la contraseña
    $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

    // Usar sentencia preparada
    $stmt = $conexion->prepare("INSERT INTO usuario(nombre, email, password, direccion, telefono) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error en prepare: " . $conexion->error);
    }

    $stmt->bind_param("sssss", $name, $email, $hashedPass, $direction, $telf);

    if ($stmt->execute()) {
       
        header("Location: ../views/registro.php?mensaje=ok");
        exit;
    } else {
        header("Location: ../views/registro.php?mensaje=error");
        exit;
    }

    $stmt->close();
} else {
    echo "Complete todos los campos";
}

$conexion->close();
?>
