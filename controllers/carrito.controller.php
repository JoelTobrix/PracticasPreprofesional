<?php
session_start();
header('Content-Type: application/json');


ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once '../config/conex.php'; 

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$cart = $input['cart'] ?? [];

if (empty($cart)) {
    echo json_encode(['success' => false, 'message' => 'Carrito vacío']);
    exit;
}

// Iniciar transacción
$conn->begin_transaction();

try {
    // Insertar carrito
    $sql = "INSERT INTO carrito (usuario_id, fecha_creacion) VALUES (?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();

    $carrito_id = $conn->insert_id;

    // Insertar items del carrito
    $sqlItem = "INSERT INTO itemcarrito (Carrito_id, producto_id, cantidad, subtotal) VALUES (?, ?, ?, ?)";
    $stmtItem = $conn->prepare($sqlItem);

    foreach ($cart as $item) {
        $producto_id = $item['producto_id'];
        $cantidad = $item['cantidad'];
        $subtotal = $item['precio'] * $item['cantidad'];

        $stmtItem->bind_param("iiid", $carrito_id, $producto_id, $cantidad, $subtotal);
        $stmtItem->execute();
    }

    $conn->commit();

    echo json_encode(['success' => true, 'carrito_id' => $carrito_id]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Error al guardar carrito: ' . $e->getMessage()]);
}
?>
