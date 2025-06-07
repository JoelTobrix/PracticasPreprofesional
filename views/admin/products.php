<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interpc.net@</title>
    <link rel="icon" href="/interpc/img/logo.png" type="image/png">
    <link href="/interpc/css/tableproducts.css" rel="stylesheet">
    <style>
        /* Estilos básicos para el modal (si no usas Bootstrap) */
        .modal {
            display: none; /* Oculto por defecto */
            position: fixed; /* Posición fija para cubrir toda la ventana */
            z-index: 1000; /* Estar por encima de otros elementos */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Habilitar scroll si el contenido es demasiado grande */
            background-color: rgba(0,0,0,0.4); /* Fondo semi-transparente */
            justify-content: center; /* Centrar contenido */
            align-items: center; /* Centrar contenido */
        }
        .modal-content {
            background-color: #fefefe;
            margin: auto; /* Centrar en la pantalla */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Ancho del modal */
            max-width: 600px; /* Ancho máximo */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            position: relative;
        }
        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        /* Estilos para los mensajes de estado */
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <img src="/interpc/img/logo.png" alt="Logo Interpc">

    <?php
    // --- Sección para mostrar mensajes de estado (éxito/error) ---
    // Activar la visualización de errores de PHP para depuración (¡quitar en producción!)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (isset($_GET['status']) && isset($_GET['message'])) {
        $status = htmlspecialchars($_GET['status']);
        $message = htmlspecialchars(urldecode($_GET['message'])); 
        if ($status == 'success') {
            echo "<p class='message success'>" . $message . "</p>";
        } elseif ($status == 'error') {
            echo "<p class='message error'>" . $message . "</p>";
        }
    }
    ?>
    
    <table class="table">
        <thead> 
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Precio</th>
                <th scope="col">Stock</th>
                <th scope="col">Categoria</th>
                <th scope="col">Imagen</th>
                <th scope="col">Acciones</th> </tr> 
        </thead>
        
    </table>

    <div style="display: flex; gap: 10px; margin-top: 20px;"> 
        <button class="color-green" id="btnAddProduct">  <img src="/interpc/icons/basket.svg" alt="Basket" width="20" height="20"> Añadir producto      </button> 
        <button class="color-blue"><img src="/interpc/icons/uptade.svg" alt="Update" width="20" height="20">Actualizar</button>
        <button class="color-red"><img src="/interpc/icons/delete.svg" alt="Delete" width="20" height="20">Eliminar</button>
        <button class="color-orange"><img src="/interpc/icons/reports.svg" alt="Reports" width="20" height="20">Generar reporte</button>
    </div>

    
</body>
</html>