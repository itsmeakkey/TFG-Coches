<?php
require_once '../Modelo/ReparacionBD.php';
if (isset($_POST['accion']) && $_POST['accion'] == 'agregarReparacion') {
    $vehiculoId = $_POST['vehiculo_id'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    $costo = $_POST['costo'];

    $resultado = ReparacionBD::agregarReparacion($vehiculoId, $fecha, $descripcion, $costo);
    echo json_encode(['success' => $resultado]);
    exit;
}

if (isset($_GET['accion']) && $_GET['accion'] == 'listar') {
    $reparaciones = ReparacionBD::listar();
    echo json_encode(['success' => true, 'reparaciones' => $reparaciones]);
    exit;
}
