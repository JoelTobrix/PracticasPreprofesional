<?php

function uploadImage($file) {
    if ($file['error'] === UPLOAD_ERR_OK) {
        $imagen_tmp = $file['tmp_name'];
        $imagen_nombre = basename($file['name']);
        $ruta_relativa = 'uploads/' . $imagen_nombre;
        $ruta_fisica = __DIR__ . '/../' . $ruta_relativa;

        // Asegúrate de que la carpeta 'uploads' exista al nivel de la raíz de tu proyecto
        // (es decir, en el mismo nivel que 'controllers', 'views', etc.)
        $uploads_dir_fisica = __DIR__ . '/../uploads';
        if (!is_dir($uploads_dir_fisica)) {
            mkdir($uploads_dir_fisica, 0755, true);
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

    $imagen_para_db = ''; 

    
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $resultado_subida = uploadImage($_FILES['imagen']);
        if ($resultado_subida['success']) {
            $imagen_para_db = $resultado_subida['path']; // Guardamos la ruta relativa
        } else {
            // Manejo de error si la subida falla
            echo "Error al subir imagen: " . $resultado_subida['message'];
            exit; // Detenemos la ejecución si hay un error crítico
        }
    } else {
        
    }
    // --- FIN DE CAMBIO IMPORTANTE PARA LA INSERCIÓN ---

    // Conectar a BD y guardar producto
    include '../config/conex.php'; 

    
    $stmt = $conn->prepare("INSERT INTO producto (nombre, descripcion, precio, stock, categoria, imagen) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdiis", $nombre, $descripcion, $precio, $stock, $categoria, $imagen_para_db); // Usamos $imagen_para_db
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ../views/admin/products.php"); 
        exit;
    } else {
        echo "Error al guardar en la base de datos: " . $stmt->error; // Añadimos $stmt->error para mejor depuración
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

            // Solo intentar borrar si la ruta antigua existe y es diferente a la nueva
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