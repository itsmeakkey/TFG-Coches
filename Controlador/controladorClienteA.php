<?php
session_start();
/*Importaciones*/
require_once '../Modelo/UsuarioBD.php';

//CLIENTE(USUARIO)

//Verificamos si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'error' => 'Usuario no autenticado']);
    exit;
}

//Obtengo el id de usuario de la sesión
$usuarioId = $_SESSION['usuario_id'];

// Manejar la petición para obtener los datos del perfil
if (isset($_GET['accion']) && $_GET['accion'] == 'obtenerPerfil') {
    // Obtener los datos del usuario
    $usuario = UsuarioBD::obtenerUsuarioPorId($usuarioId);

    if ($usuario) {
        echo json_encode(['success' => true, 'usuario' => $usuario]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se encontraron datos del usuario.']);
    }
    exit;
}

//Actualización de los datos del perfil
if (isset($_POST['accion']) && $_POST['accion'] == 'actualizarPerfil') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $localidad = $_POST['localidad'];
    $provincia = $_POST['provincia'];
    $cp = $_POST['cp'];

    //Operación de actualización en la base de datos
    $actualizado = UsuarioBD::actualizarUsuario($usuarioId, $nombre, $apellidos, $correo, $telefono, $localidad, $provincia, $cp);
    if ($actualizado) {
        echo json_encode(['success' => true, 'message' => 'Perfil actualizado con éxito.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al actualizar el perfil.']);
    }
    exit;
}

echo json_encode(['success' => false, 'error' => 'Acción no válida.']);
