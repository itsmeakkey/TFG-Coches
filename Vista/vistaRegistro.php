<?php
if (!isset($_SESSION)) {
    session_start();
}
if(isset($_SESSION['error'])) {
    echo '<div class="mensaje-error">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro</title>
    <link rel="stylesheet" href="../Vista/css/cssRegistro.css">
</head>
<body>
<h1>Registrarse</h1>
<form method="POST" action="../Controlador/controladorUsuario.php" onsubmit="return validarFormulario()">
    <input type="text" id="nombre" name="nombre" placeholder="Nombre:" required><br>
    <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos:" required><br>
    <input type="text" id="dni" name="dni" placeholder="DNI:"required ><br>
    <input type="text" id="correo" name="correo" placeholder="Correo electrónico:"  required><br>
    <input type="password" id="pwd" name="pwd"  placeholder="Contraseña:"required><br>
    <input type="date" id="fechaNacimiento" name="fechaNacimiento" placeholder="Fecha nacimiento:"  required><br>
    <input type="text" id="telefono" name="telefono" placeholder="Teléfono:" required><br>
    <input type="text" id="localidad" name="localidad" placeholder="Localidad:"required><br>
    <input type="text" id="provincia" name="provincia" placeholder="Provincia:" required><br>
    <input type="text" id="cp" name="cp" placeholder="Código postal:" required><br><br>
    <button type="submit" name="registroUsuario">Registrar</button>
    <button type="button" id="volver" onclick="location.href='../index.php'">Volver</button>
</form>
<br/>
<footer>
    <p>&copy; 2024 Rent a Car | Diseñado por David Ruiz Aranda</p>
</footer>
</body>
</html>
