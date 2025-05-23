<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <title>Iniciar Sesion</title>
        <!-- Bootstrap core CSS -->
        <link href="../css/loginmodel.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="../css/login.css" rel="stylesheet">
        <link rel="icon" href="../img/logo.png" type="image/png">

    </head>
    <body class="text-center">
        <main class="form-signin">
            <form  id="inicioForm" action="../controllers/inicio.controller.php" method="POST">
                <img class="mb-4" src="../img/logo.png" alt="" width="100" height="100">
                <h1 class="h3 mb-3 fw-normal">Iniciar sesion</h1>
             
                 <label for="inputEmail" class="visually-hidden">Email address</label>
                <input type="email" id="inputEmail" name="correo" class="form-control" placeholder="Correo electronico" required="" autofocus="">
                <label for="inputPassword" class="visually-hidden">Password</label>
                <input type="password" id="inputPassword" name="contraseña" class="form-control" placeholder="Contraseña" required="">
                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                 <button type="submit" class="w-100 btn btn-lg btn-primary mb-3">Ingresar</button>
                 <a href="../views/registro.php" class="w-100 btn btn-lg btn-primary">Registrarse</a>

                <p class="mt-5 mb-3 text-muted">© 2025-2030</p>
            </form>
        </main>
        <script src="assets/js/popper.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
