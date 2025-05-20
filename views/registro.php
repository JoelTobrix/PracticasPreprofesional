<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="icon" href="../img/logo.png" type="image/png">
    <link href="../css/register.css" rel="stylesheet">
</head>
<body>
    
    <h1 class="h3 mb-3 fw-normal">Registre sus datos</h1>
    <img src="../img/logo.png" width="100px" height="100px">

    <!--Line aparece mensaje-->
    <div id="mensaje" style="display:none; margin: 15px auto; padding: 12px; border-radius: 5px; width: 300px; text-align: center; font-weight: bold;"></div>

    <form  id="registroForm" action="../controllers/registro.controller.php" method="POST">
        
            <h3>Nombre
            <input type="text" name="nombre" placeholder="nombre" required>
             </h3>
        
            <h3>Correo
            <input type="text" name="correo" placeholder="correo" required>
         </h3>
        
            <h3>Contraseña
            <input type="text" name="contrasena" placeholder="contraseña" required>
        </h3>
        
            <h3>Dirección
            <input type="text" name="direccion" placeholder="direccion" required>
        </h3>
        
            <h3>Teléfono
            <input type="text" name="telefono" placeholder="telefono" required>
        </h3>

        <button class="w-100 btn btn-lg btn-primary mb-3" type="submit">Registrar</button>
        <button class="w-100 btn btn-lg btn-primary" type="button" onclick="borrarFormulario()">Borrar</button>
        <button class="w-100 btn btn-lg btn-primary" type="button" onclick="window.location.href='../views/login.php'" >Regresar</button>
    </form> 

    <script>
        function borrarFormulario() {
            document.getElementById("registroForm").reset();
        }

        //  Script para mostrar mensaje si la URL tiene "?mensaje=ok"
        window.onload = function() {
            const params = new URLSearchParams(window.location.search);
            const mensajeDiv = document.getElementById("mensaje");

            if (params.get("mensaje") === "ok") {
                mensajeDiv.style.display = "block";
                mensajeDiv.style.backgroundColor = "#d4edda";
                mensajeDiv.style.color = "#155724";
                mensajeDiv.innerText = "Usuario registrado correctamente.";

                // Ocultar luego de 3 segundos
                setTimeout(() => {
                    mensajeDiv.style.display = "none";
                }, 3000);
            }
        }
    </script>
</body>
</html>
