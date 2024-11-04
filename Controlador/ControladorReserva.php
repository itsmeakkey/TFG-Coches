<?php
require_once '../Modelo/ReservaBD.php';

// Métodos para panel de admin
// Lista las reservas en la tabla al entrar en la sección
if (isset($_GET['accion']) && $_GET['accion'] == 'listar') {
    $reservas = ReservaBD::listar();
    echo json_encode($reservas);

// Elimina una reserva
} elseif (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    $id = $_POST['id'];
    $resultado = ReservaBD::eliminar($id);
    echo json_encode($resultado);

// Confirma cambios en una reserva
} elseif (isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
    $id = $_POST['id'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $estado = $_POST['estado'];

    // Llama a la función de actualización en ReservaBD
    $resultado = ReservaBD::actualizar($id, $fechaInicio, $fechaFin, $estado);
    echo json_encode($resultado);

} else {
    // Respuesta por si la acción no es válida
    echo json_encode(['success' => false, 'error' => 'Acción no válida']);
}

?>

