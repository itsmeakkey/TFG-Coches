<?php
require_once '../Modelo/ReparacionBD.php';

if (isset($_GET['accion']) && $_GET['accion'] == 'listar') {
    $reparaciones = ReparacionBD::listar();
    echo json_encode(['success' => true, 'reparaciones' => $reparaciones]);
    exit;
} elseif (isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    if ($accion == 'agregar') {
        $vehiculo_id = $_POST['vehiculo_id'];
        $fecha = $_POST['fecha'];
        $descripcion = $_POST['descripcion'];
        $costo = $_POST['costo'];
        $resultado = ReparacionBD::agregar($vehiculo_id, $fecha, $descripcion, $costo);
        echo json_encode($resultado);
        exit;

    } elseif ($accion == 'actualizar') {
        $id = $_POST['id'];
        $descripcion = $_POST['descripcion'];
        $costo = $_POST['costo'];
        $fecha = $_POST['fecha'];

        $resultado = ReparacionBD::actualizar($id, $fecha, $descripcion, $costo);
        echo json_encode($resultado);
        exit;

    } elseif ($accion === 'eliminar') {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $resultado = ReparacionBD::eliminar($id);
            echo json_encode($resultado);
        } else {
            echo json_encode(['success' => false, 'error' => 'ID no proporcionado']);
        }
        exit;
    }
}

echo json_encode(['success' => false, 'error' => 'Acción no válida']);
exit;

