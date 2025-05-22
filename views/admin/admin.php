<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interpc.net</title>
     <link href="/interpc/css/admin.css" rel="stylesheet">

     <link rel="icon" href="/interpc/img/logo.png" type="image/png">
</head>
<body>
     <h2 align="center">Ingrese su codigo</h2>
     <img src="/interpc/img/logo.png">
     <form align="center" id="accesoForm" action="/interpc/controllers/admin.controller.php" method="POST">
        <input type="text" name="codigo"  placeholder="Codigo">
        <button type="submit">Enviar</button>
</body>
</html>