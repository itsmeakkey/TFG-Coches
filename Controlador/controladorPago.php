<?php
/*Importaciones*/
require_once '../Modelo/PagoBD.php';

//ADMIN
//Eliminar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $resultado = PagoBD::eliminar($id);
        echo json_encode($resultado);
    }
//Actualizar
    if (isset($_POST['accion']) && $_POST['accion'] === 'actualizar') {
        $id = $_POST['id'];
        $descripcion = $_POST['descripcion'];
        $monto_total = $_POST['monto_total'];
        $metodo_pago = $_POST['metodo_pago'];
        $resultado = PagoBD::actualizar($id, $descripcion, $monto_total, $metodo_pago);
        echo json_encode($resultado);
    }
//Listar
} elseif ($_GET['accion'] === 'listar') {
    $pagos = PagoBD::listar();
    echo json_encode($pagos);
}

