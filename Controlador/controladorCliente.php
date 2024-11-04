<?php
/*Importamos lo necesario*/
require_once "../Modelo/BaseDeDatosConexion.php";
require_once "../Modelo/Password.php";
require_once "../Modelo/UsuarioBD.php";

// Métodos para panel de admin
    // Lista los usuarios en la tabla al entrar en la sección
if (isset($_GET['accion']) && $_GET['accion'] == 'listar') {
    $clientes = UsuarioBD::listar();
    echo json_encode($clientes);

    // Elimina un usuario
} elseif (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    $id = $_POST['id'];
    $resultado = UsuarioBD::eliminar($id);
    echo json_encode($resultado);

    // Confirma cambios en un usuario
} elseif (isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
    $id = $_POST['id'];
    $dni = $_POST['dni'];
    $apellidos = $_POST['apellidos'];
    $nombre = $_POST['nombre'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $localidad = $_POST['localidad'];
    $provincia = $_POST['provincia'];
    $cp = $_POST['cp'];

    // Llama a la función de actualización en UsuarioBD
    $resultado = UsuarioBD::actualizar($id, $dni, $apellidos, $nombre, $fechaNacimiento, $telefono, $correo, $localidad, $provincia, $cp);
    echo json_encode($resultado);
} else {
    // Respuesta por si la acción no es válida
    echo json_encode(['success' => false, 'error' => 'Acción no válida']);
}




?>

