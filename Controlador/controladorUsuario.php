<?php
/*Importamos lo necesario*/
require_once "../Modelo/BaseDeDatosConexion.php";
require_once "../Modelo/Password.php";
require_once "../Modelo/UsuarioBD.php";



session_start();

/*Hacemos la conexion a la base de datos*/
$conexion = BaseDeDatosConexion::getConexion('coches');

//LÓGICAS INDEX
/*Aqui hacemos lo necesario cuando le demos al boton de loguearnos*/
if (isset($_POST['login'])){
    $correo = $_POST['correo'];
    $password = $_POST['pwd'];
    $_SESSION["UsuarioLogs"] = $_POST['correo'];

    $personaBD = new UsuarioBD($conexion);
    $personaBD->login($correo, $password);
}


if (isset($_POST['registrar'])){
    require_once '../Vista/vistaRegistro.php';
}

//Control de botón de registro
if (isset($_POST['registroUsuario'])){
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $correo = $_POST['correo'];
    $password = Password::hash($_POST['pwd']);
    $fechaNacimiento = DateTime::createFromFormat('d/m/Y', $_POST['fechaNacimiento'])->format('Y-m-d');
    $telefono = $_POST['telefono'];
    $localidad = $_POST['localidad'];
    $provincia = $_POST['provincia'];
    $cp = $_POST['cp'];
    $tipo = 0;
    $personaBD = new UsuarioBD($conexion);
    $personaBD->registrar($nombre, $apellidos, $dni, $correo, $password, $fechaNacimiento, $telefono, $localidad, $provincia, $cp, $tipo);
}

if (isset($_POST['salir'])) {
    /*Borra las variables de las sesiones*/
    session_unset();
    /*Destruye la sesion*/
    session_destroy();
    /*Inicia una nueva sesion y establece un nuevo mensaje cuando se haya cerrado
    y vuelve a la pagina del login*/
    session_start();
    $_SESSION ['error'] = "Has cerrado sesion";
    header('Location: ../index.php');
    exit();
}


?>


