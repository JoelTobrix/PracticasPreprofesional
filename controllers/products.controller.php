<?php
//Archivo conexion Database
include '/config/conex.php'; 

// Verificar si se ha enviado el formulario de añadir producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria'];
    $imagen_path = ''; // Inicializar la ruta de la imagen

    // Manejo de la subida de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $target_dir = "uploads/"; // Directorio donde se guardarán las imágenes
        // Crear el directorio si no existe
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Considera permisos más restrictivos en producción (e.g., 0755)
        }
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Permitir ciertos formatos de archivo
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        if (in_array($imageFileType, $allowed_extensions)) {
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                $imagen_path = $target_file; // Guardar la ruta relativa
            } else {
                // Error al mover el archivo
                header("Location: products.php?status=error&message=" . urlencode("Hubo un error al subir la imagen."));
                exit();
            }
        } else {
            // Extensión de archivo no permitida
            header("Location: products.php?status=error&message=" . urlencode("Solo se permiten archivos JPG, JPEG, PNG y GIF para la imagen."));
            exit();
        }
    }

    // Preparar la consulta SQL para evitar inyecciones SQL
    $stmt = $conn->prepare("INSERT INTO producto (nombre, descripcion, precio, stock, categoria, imagen) VALUES (?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        // Error en la preparación de la consulta
        header("Location: products.php?status=error&message=" . urlencode("Error en la preparación de la consulta: " . $conn->error));
        exit();
    }

    // "ssdiss" => s (string), s (string), d (double/float), i (integer), s (string), s (string)
    $stmt->bind_param("ssdiss", $nombre, $descripcion, $precio, $stock, $categoria, $imagen_path);

    if ($stmt->execute()) {
        // Éxito en la inserción
        header("Location: products.php?status=success&message=" . urlencode("Producto añadido correctamente."));
        exit();
    } else {
        // Error en la ejecución de la consulta
        header("Location: products.php?status=error&message=" . urlencode("Error al añadir el producto: " . $stmt->error));
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // Si se accede a este archivo directamente sin enviar el formulario
    header("Location: products.php");
    exit();
}
?>