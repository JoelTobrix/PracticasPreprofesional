<?php
session_start();
include '../../config/conex.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: /interpc/views/login.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$carrito_id = intval($_GET['carrito_id'] ?? 0);

if (!$carrito_id) {
    die("Carrito no especificado");
}

// Opcional: Verificar que el carrito pertenezca al usuario
$sqlCheck = "SELECT * FROM carrito WHERE carrito_id = ? AND usuario_id = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("ii", $carrito_id, $usuario_id);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();
if ($resultCheck->num_rows === 0) {
    die("Carrito no encontrado o no autorizado");
}

// Obtener items carrito y calcular total
$sql = "
SELECT p.nombre, p.descripcion, p.precio, ic.cantidad, ic.subtotal
FROM itemcarrito ic
JOIN producto p ON p.producto_id = ic.producto_id
WHERE ic.Carrito_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $carrito_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
    $total += $row['subtotal'];
}

// Calcular IVA y total final
$iva = $total * 0.12;
$final = $total + $iva;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="/interpc/img/logo.png" type="image/png" />
    <title>Seccion de pagos</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            padding: 30px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }
        .invoice-container {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 800px;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            border-bottom: 2px solid #343a40;
            padding-bottom: 20px;
        }
        .invoice-header h1 {
            color: #343a40;
            font-size: 2.2rem;
            margin: 0;
        }
        .invoice-header .company-info {
            text-align: right;
            font-size: 0.9rem;
            color: #555;
        }
        .invoice-header .company-info img {
            max-height: 60px;
            margin-bottom: 10px;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            font-size: 0.95rem;
            color: #444;
        }
        .invoice-details div {
            flex: 1;
        }
        .invoice-details .right-align {
            text-align: right;
        }
        .invoice-details strong {
            color: #333;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .invoice-table th, .invoice-table td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }
        .invoice-table th {
            background-color: #e9ecef;
            color: #343a40;
            font-weight: 600;
        }
        .invoice-table tfoot td {
            font-weight: 600;
            background-color: #f8f9fa;
        }
        .invoice-table tfoot tr:last-child td {
            font-size: 1.1rem;
            color: #28a745;
        }
        .invoice-footer {
            text-align: center;
            font-size: 0.85rem;
            color: #6c757d;
            border-top: 1px solid #e0e0e0;
            padding-top: 20px;
            margin-top: 30px;
        }
        .print-button-container {
            text-align: center;
            margin-top: 20px;
        }
        @media print {
            body {
                background-color: #fff;
                padding: 0;
            }
            .invoice-container {
                box-shadow: none;
                border: none;
                border-radius: 0;
                padding: 0;
                margin: 0;
            }
            .print-button-container {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="invoice-container">
    <div class="invoice-header">
        <div>
            <h1>FACTURA ELECTRÓNICA</h1>
            <p>No. 001-001-000012345</p>
            <p>Fecha de Emisión: <?= date("Y-m-d H:i:s") ?></p>
        </div>
        <div class="company-info">
            <img src="/interpc/img/logo.png" alt="Interpc.net Logo" style="width: 100px;">
            <h3>Interpc.net</h3>
            <p>RUC: 1792345678001</p>
            <p>Dir: Av. 24 de Mayo y Calle 10 de Agosto</p>
            <p>Puyo, Pastaza, Ecuador</p>
            <p>Tel: 0991956962</p>
            <p>Email: homerortizesp@gmail.com</p>
        </div>
    </div>

    <div class="invoice-details">
        <div>
            <strong>Cliente:</strong><br>
            Nombre del Cliente Ejemplo<br>
            RUC/CI: 1712345678<br>
            Dir: Calle Falsa 123, Quito<br>
            Email: cliente@ejemplo.com
        </div>
        <div class="right-align">
            <strong>Método de Pago:</strong> Tarjeta de Crédito/Débito<br>
            <strong>Estado:</strong> Pagado<br>
        </div>
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th>Cantidad</th>
                <th>Descripción</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['cantidad']) ?></td>
                        <td><?= htmlspecialchars($row['nombre']) ?><br><small><?= htmlspecialchars($row['descripcion']) ?></small></td>
                        <td>$<?= number_format($row['precio'], 2) ?></td>
                        <td>$<?= number_format($row['subtotal'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">No hay productos en el carrito</td></tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right;">Subtotal:</td>
                <td>$<?= number_format($total, 2) ?></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;">Descuento (0%):</td>
                <td>$0.00</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;">IVA (12%):</td>
                <td>$<?= number_format($iva, 2) ?></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;">TOTAL A PAGAR:</td>
                <td>$<?= number_format($final, 2) ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="invoice-footer">
        <p>Gracias por tu compra en Interpc.net.</p>
        <p>Documento generado electrónicamente. Validez su autenticidad en el portal del SRI.</p>
    </div>
</div>

<div class="print-button-container">
    <button class="btn btn-info" onclick="window.print()">Imprimir Factura</button>
    <a href="../interpc.php" class="btn btn-secondary ms-2">Volver</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
