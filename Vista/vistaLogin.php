<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="Vista/css/cssIndex.css">
</head>
<body>

<center><img src="Extras/logo_copy.png"></center>

<h1>Inicio de sesión</h1>
<form method="POST" action="Controlador/controladorUsuario.php">
    <label for="correo">Introduce tu email:</label><br>
    <input type="text" id="correo" name="correo" required><br>
    <label for="pwd">Introduce tu contraseña:</label><br>
    <input type="password" id="pwd" name="pwd" required><br><br>
    <center>
    <button type="submit" name="login">Iniciar sesión</button>
    <button type="submit" name="registrar" formnovalidate>Registrarse</button>
    </center>
</form>
<br>

</body>
</html>
