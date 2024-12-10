<?php
require_once '../Modelo/PagoBD.php';

if ($_GET['accion'] == 'listar') {
    $pagos = PagoBD::listar();
    echo json_encode($pagos);
}


?>
