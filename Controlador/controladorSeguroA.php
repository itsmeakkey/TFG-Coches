<?php
session_start();
/*Importaciones*/
require_once '../Modelo/ReservaBD.php';
require_once '../Modelo/ReservaSeguroBD.php';

//CLIENTE(USUARIO)

// Añadir una reserva
if (isset($_POST['vehiculo_id']) && isset($_POST['fechaInicio']) && isset($_POST['fechaFin']) && isset($_POST['seguros'])) {
    $vehiculoId = $_POST['vehiculo_id'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $usuarioId = $_SESSION['usuario_id']; //El id de usuario se coge de la sesión
    $seguros = $_POST['seguros'];

    //Inserta la reserva en la base de datos
    $reservaInsertada = ReservaBD::insertarReserva($fechaInicio, $fechaFin, $usuarioId, $vehiculoId);

    if ($reservaInsertada) {
        //Cojo el último id de la reserva
        $reservaId = ReservaBD::obtenerUltimaReservaId($usuarioId);

        //Inserto los seguros
        foreach ($seguros as $seguroId) {
            ReservaSeguroBD::insertarReservaSeguro($reservaId, $seguroId);
        }

        //Cambio el estado del vehículo a "Ocupado"
        VehiculoBD::actualizarEstadoVehiculo($vehiculoId, 'Ocupado');

        echo json_encode(['success' => true]);
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al insertar la reserva']);
        exit;
    }
}

//Obtención de los seguros por reserva
if (isset($_GET['accion']) && $_GET['accion'] == 'listarSegurosPorUsuario' && isset($_SESSION['usuario_id'])) {
    $usuarioId = $_SESSION['usuario_id']; //Cojo el ID del usuario de la sesión
    //Realizamos operación a BD
    $segurosPorReserva = ReservaSeguroBD::obtenerSegurosPorUsuario($usuarioId);

    if (!empty($segurosPorReserva)) {
        echo json_encode(['success' => true, 'segurosPorReserva' => $segurosPorReserva]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se encontraron seguros para las reservas del usuario.']);
    }
    exit;
}

