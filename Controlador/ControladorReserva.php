<?php
/*Importaciones*/
require_once '../Modelo/ReservaBD.php';

//ADMIN
//Listar
if (isset($_GET['accion']) && $_GET['accion'] == 'listar') {
    $reservas = ReservaBD::listar();
    echo json_encode($reservas);
//Eliminar
} elseif (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    $id = $_POST['id'];
    $resultado = ReservaBD::eliminar($id);
    echo json_encode($resultado);

//Actualizar
} elseif (isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
    $id = $_POST['id'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $estado = $_POST['estado'];
    //Operación a BD
    $resultado = ReservaBD::actualizar($id, $fechaInicio, $fechaFin, $estado);
    echo json_encode($resultado);

} else {
    echo json_encode(['success' => false, 'error' => 'Acción no válida']);
}

?>

