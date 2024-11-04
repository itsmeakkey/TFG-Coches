<?php

require_once '../Modelo/SeguroBD.php';

//LÓGICAS PANEL ADMIN
if (isset($_GET['accion']) && $_GET['accion'] == 'listar') {
    $seguros = SeguroBD::listar();
    echo json_encode(['success' => true, 'seguros' => $seguros]);
    exit;
} elseif (isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $cobertura = $_POST['cobertura'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    $resultado = SeguroBD::actualizar($id, $tipo, $cobertura, $precio, $descripcion);
    echo json_encode($resultado);
    exit;
} elseif (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    $id = $_POST['id'];
    $resultado = SeguroBD::eliminar($id);
    echo json_encode($resultado);
    exit;
} elseif (isset($_POST['accion']) && $_POST['accion'] == 'agregar') {
    $tipo = $_POST['tipo'];
    $cobertura = $_POST['cobertura'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    $resultado = SeguroBD::agregar($tipo, $cobertura, $precio, $descripcion);
    echo json_encode($resultado);
    exit;
} else {
    echo json_encode(['success' => false, 'error' => 'Acción no válida']);
}exit;
?>

