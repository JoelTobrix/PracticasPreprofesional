<?php

function uploadImage($file) {
    if ($file['error'] === UPLOAD_ERR_OK) {
        $imagen_tmp = $file['tmp_name'];
        $imagen_nombre = basename($file['name']);
        $ruta_relativa = 'uploads/' . $imagen_nombre;
        $ruta_fisica = __DIR__ . '/../' . $ruta_relativa;

        if (!is_dir(__DIR__ . '/../uploads')) {
            mkdir(__DIR__ . '/../uploads', 0755, true);
        }

        if (move_uploaded_file($imagen_tmp, $ruta_fisica)) {
            return ['success' => true, 'path' => $ruta_relativa];
        } else {
            return ['success' => false, 'message' => 'Error al mover la imagen al destino'];
        }
    } else {
        return ['success' => false, 'message' => 'Error en la subida: ' . $file['error']];
    }
}


//1. Insertar Datos
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
        $ruta_destino = '/interpc/uploads/' . $imagen_nombre;

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


// 2. Actualizar productos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    include '../config/conex.php';

    $id_producto = $_POST['producto_id'] ?? null;
    if (empty($id_producto)) {
        echo json_encode(['success' => false, 'message' => 'ID del producto no proporcionado.']);
        $conn->close();
        exit();
    }

    $campos = [];
    $parametros = [];
    $tipos = "";

    // Validar y preparar campos
    if (!empty($_POST['nombre'])) {
        $campos[] = "nombre = ?";
        $parametros[] = $_POST['nombre'];
        $tipos .= "s";
    }
    if (!empty($_POST['descripcion'])) {
        $campos[] = "descripcion = ?";
        $parametros[] = $_POST['descripcion'];
        $tipos .= "s";
    }
    if (!empty($_POST['precio'])) {
        $precio = filter_var($_POST['precio'], FILTER_VALIDATE_FLOAT);
        if ($precio !== false) {
            $campos[] = "precio = ?";
            $parametros[] = $precio;
            $tipos .= "d";
        }
    }
    if (!empty($_POST['stock'])) {
        $stock = filter_var($_POST['stock'], FILTER_VALIDATE_INT);
        if ($stock !== false) {
            $campos[] = "stock = ?";
            $parametros[] = $stock;
            $tipos .= "i";
        }
    }
    if (!empty($_POST['categoria'])) {
        $campos[] = "categoria = ?";
        $parametros[] = $_POST['categoria'];
        $tipos .= "s";
    }

    // Imagen nueva
    $imagenPath = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imageUploadResult = uploadImage($_FILES['imagen']);
        if ($imageUploadResult['success']) {
            $imagenPath = $imageUploadResult['path'];
            $campos[] = "imagen = ?";
            $parametros[] = $imagenPath;
            $tipos .= "s";

            // Eliminar imagen antigua
            $stmt_old_img = $conn->prepare("SELECT imagen FROM producto WHERE producto_id = ?");
            $stmt_old_img->bind_param("i", $id_producto);
            $stmt_old_img->execute();
            $stmt_old_img->bind_result($oldImagePath);
            $stmt_old_img->fetch();
            $stmt_old_img->close();

            $fullOldImagePath = realpath(__DIR__ . '/../' . $oldImagePath);
            if ($oldImagePath && $oldImagePath !== $imagenPath && file_exists($fullOldImagePath)) {
                unlink($fullOldImagePath);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al subir imagen: ' . $imageUploadResult['message']]);
            $conn->close();
            exit();
        }
    }

    if (empty($campos)) {
        echo json_encode(['success' => false, 'message' => 'No se proporcionaron datos para actualizar.']);
        $conn->close();
        exit();
    }

    // Construir consulta SQL dinámica
    $sql = "UPDATE producto SET " . implode(", ", $campos) . " WHERE producto_id = ?";
    $tipos .= "i";
    $parametros[] = $id_producto;

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Error preparando consulta: ' . $conn->error]);
        $conn->close();
        exit();
    }

    // Bind dinámico
    $bind_names[] = $tipos;
    foreach ($parametros as $key => $value) {
        $bind_names[] = &$parametros[$key];
    }
    call_user_func_array([$stmt, 'bind_param'], $bind_names);

    if ($stmt->execute()) {
        header("Location: ../views/admin/products.php?mensaje=ok"); exit;
    } else {
        header("Location: ../views/admin/products.php?mensaje=error"); exit;
    }

    $stmt->close();
    $conn->close();
    exit();
}


 
?>
