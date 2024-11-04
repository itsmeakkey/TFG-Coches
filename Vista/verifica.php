<!DOCTYPE html>
<html>
<head>

</head>
<body>
<h1>Verificación de Email</h1>
<?php

require_once "../Modelo/BaseDeDatosConexion.php";
require_once "../Modelo/Password.php";
require_once "../Modelo/UsuarioBD.php";

if (!isset($_SESSION)) {
    session_start();
}

/*Hacemos la conexion a la base de datos*/
$conexion = BaseDeDatosConexion::getConexion('coches');

/*Si existe el email accedemos*/
if (isset($_GET['email']) && isset($_GET['token'])){
    /*Lo guardamos en variables*/
    $email = $_GET['email'];
    $token = $_GET['token'];

    /*Creamos una nueva personaBD donde le pasamos la conexion*/
    $personaBD = new UsuarioBD($conexion);


    if ($personaBD->activarCuenta($email, $token)) {

        echo '<span style="color: green;">Usuario verificado correctamente, ya puede iniciar sesión en la página principal.</span>';
    } else {

        echo '<span style="color: red;">Hubo un error al activar la cuenta.</span>';
    }
} else {
    echo '<span style="color: red;">Email no encontrado.</span>';
}
?>

</body>
</html>
