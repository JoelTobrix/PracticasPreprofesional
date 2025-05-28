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


 //Actualizar productos
 if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['uptade_product'])){
    
    $id_producto = $_POST['producto_id'] ?? null; 
    if (empty($id_producto)) {
        echo json_encode(['success' => false, 'message' => 'ID del producto no proporcionado para la actualización.']);
        $conn->close();
        exit();
    }

    // 2. Obtener los demás datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? 0.0;
    $stock = $_POST['stock'] ?? 0;
    $categoria = $_POST['categoria'] ?? '';

    // Validaciones básicas de campos obligatorios
    if (empty($nombre) || empty($descripcion) || empty($precio) || empty($stock) || empty($categoria)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos obligatorios deben ser completados para actualizar.']);
        $conn->close();
        exit();
    }

    $imagenPath = null;
    $new_image_url = null; // Para devolver la URL de la nueva imagen al frontend

    // 3. Manejo de la imagen: Verificar si se ha subido una nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imageUploadResult = uploadImage($_FILES['imagen']); // Llama a tu función de subida de imagen
        if ($imageUploadResult['success']) {
            $imagenPath = $imageUploadResult['path'];
            $new_image_url = $imagenPath; // Guarda la nueva URL para la respuesta JSON

            // Opcional: Eliminar la imagen antigua del servidor
            // Consulta la ruta de la imagen actual del producto desde la base de datos
            $stmt_old_img = $conn->prepare("SELECT imagen FROM producto WHERE producto_id = ?"); // Asegúrate de 'producto_id' aquí
            if ($stmt_old_img) {
                $stmt_old_img->bind_param("i", $id_producto);
                $stmt_old_img->execute();
                $stmt_old_img->bind_result($oldImagePath);
                $stmt_old_img->fetch();
                $stmt_old_img->close();

                $fullOldImagePath = '../../' . $oldImagePath; // Ruta física de la imagen antigua

                // Si hay una imagen antigua y es diferente de la nueva (y el archivo existe), elimínala
                if ($oldImagePath && $oldImagePath !== $imagenPath && file_exists($fullOldImagePath) && is_file($fullOldImagePath)) {
                    unlink($fullOldImagePath); // Elimina el archivo físico del servidor
                }
            }
        } else {
            // Error en la subida de la nueva imagen
            echo json_encode(['success' => false, 'message' => 'Error al subir la nueva imagen: ' . $imageUploadResult['message']]);
            $conn->close();
            exit();
        }
    }

    // 4. Construir la consulta SQL UPDATE dinámicamente
    $sql = "UPDATE producto SET nombre = ?, descripcion = ?, precio = ?, stock = ?, categoria = ?";
    $types = "ssdiss"; // Tipos de datos 
    $params = [$nombre, $descripcion, $precio, $stock, $categoria]; 

    if ($imagenPath) { 
        $sql .= ", imagen = ?";
        $types .= "s"; // Añadir el tipo 's' para la imagen
        $params[] = $imagenPath; // Añadir la ruta de la nueva imagen
    }

    $sql .= " WHERE producto_id = ?";
    $types .= "i";
    $params[] = $id_producto;

    // 5. Preparar la consulta SQL
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta UPDATE: ' . $conn->error]);
        $conn->close();
        exit();
    }

   
    call_user_func_array([$stmt, 'bind_param'], refValues(array_merge([$types], $params)));

    // 7. Ejecutar consulta
    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => 'Producto actualizado con éxito.'];
        if ($new_image_url) {
            $response['new_image_url'] = $new_image_url; // Devolver la nueva URL de la imagen al frontend
        }
        echo json_encode($response);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar producto: ' . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit();

 }
?>
