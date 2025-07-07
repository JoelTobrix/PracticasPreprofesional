<!--
<form action="products.controller.php" method="POST" enctype="multipart/form-data">
    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombre" required><br><br>

    <label for="descripcion">Descripción:</label><br>
    <textarea id="descripcion" name="descripcion" rows="3"></textarea><br><br>

    <label for="precio">Precio:</label><br>
    <input type="number" id="precio" name="precio" step="0.01" required><br><br>

    <label for="stock">Stock:</label><br>
    <input type="number" id="stock" name="stock" required><br><br>

    <label for="categoria">Categoría:</label><br>
    <input type="text" id="categoria" name="categoria"><br><br>

    <label for="imagen">Imagen:</label><br>
    <input type="file" id="imagen" name="imagen" accept="image/*"><br><br>

    <input type="submit" name="add_product" value="Guardar Producto">
</form>
-->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/interpc/img/logo.png" type="image/png">
    <title>Seccion de pagos</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            padding: 30px;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Alinea al inicio verticalmente */
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
            color: #28a745; /* Verde para el total */
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
                display: none; /* Oculta el botón de imprimir en la impresión */
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
                <p>Fecha de Emisión: <?php echo date("Y-m-d H:i:s"); ?></p>
            </div>
            <div class="company-info">
                <img src="/interpc/img/logo.png" alt="Interpc.net Logo" style="width: 100px;">
                <h3>Interpc.net</h3>
                <p>RUC: 1792345678001</p>
                <p>Dir: Av. 24 de Mayo y Calle 10 de Agosto</p>
                <p>Puyo, Pastaza, Ecuador</p>
                <p>Tel: (03) 288-1234</p>
                <p>Email: info@interpc.net</p>
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
                <tr>
                    <td>1</td>
                    <td>Laptop Gamer Ultra X</td>
                    <td>$1200.00</td>
                    <td>$1200.00</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Monitor LED 24" Curvo</td>
                    <td>$250.00</td>
                    <td>$500.00</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Teclado Mecánico RGB</td>
                    <td>$80.00</td>
                    <td>$80.00</td>
                </tr>
                </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;">Subtotal:</td>
                    <td>$1780.00</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">Descuento (0%):</td>
                    <td>$0.00</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">IVA (12%):</td>
                    <td>$213.60</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">TOTAL A PAGAR:</td>
                    <td>$1993.60</td>
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
        <a href="javascript:history.back()" class="btn btn-secondary ms-2">Volver</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
