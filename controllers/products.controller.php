<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    // Recibir datos
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria'];

    // Validar y mover la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_nombre = basename($_FILES['imagen']['name']);
        $ruta_destino = 'uploads/' . $imagen_nombre;

        // Crear carpeta si no existe
        if (!is_dir('uploads')) {
            mkdir('uploads', 0755, true);
        }

        move_uploaded_file($imagen_tmp, $ruta_destino);
    } else {
        echo "Error al subir imagen";
        exit;
    }

    // Conectar a BD y guardar producto
    include '../config/conex.php'; // Asegúrate que este archivo contenga tu conexión a la BD

    $stmt = $conn->prepare("INSERT INTO producto (nombre, descripcion, precio, stock, categoria, imagen) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdiis", $nombre, $descripcion, $precio, $stock, $categoria, $ruta_destino);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ../views/admin/products.php"); // Cambia al archivo que muestra la tabla
        exit;
    } else {
        echo "Error al guardar en la base de datos";
    }

    $stmt->close();
    $conn->close();
}
?>
