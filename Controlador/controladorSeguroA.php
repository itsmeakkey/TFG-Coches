<?php
session_start();
require_once '../Modelo/ReservaBD.php';
require_once '../Modelo/ReservaSeguroBD.php';

// Añadir una reserva
if (isset($_POST['vehiculo_id']) && isset($_POST['fechaInicio']) && isset($_POST['fechaFin']) && isset($_POST['seguros'])) {
    $vehiculoId = $_POST['vehiculo_id'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $usuarioId = $_SESSION['usuario_id']; // Asume que el usuario está en la sesión
    $seguros = $_POST['seguros'];

    // Insertar la reserva en la base de datos
    $reservaInsertada = ReservaBD::insertarReserva($fechaInicio, $fechaFin, $usuarioId, $vehiculoId);

    if ($reservaInsertada) {
        // Obtener el ID de la reserva recién insertada
        $reservaId = ReservaBD::obtenerUltimaReservaId($usuarioId);

        // Insertar los seguros asociados
        foreach ($seguros as $seguroId) {
            ReservaSeguroBD::insertarReservaSeguro($reservaId, $seguroId);
        }

        // Cambiar el estado del vehículo a "Ocupado"
        VehiculoBD::actualizarEstadoVehiculo($vehiculoId, 'Ocupado');

        echo json_encode(['success' => true]);
        exit; // Salir después de enviar la respuesta exit para evitar otras ejecuciones
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al insertar la reserva']);
        exit;
    }
}

// Obtener los seguros por reserva
if (isset($_GET['accion']) && $_GET['accion'] == 'listarSegurosPorUsuario' && isset($_SESSION['usuario_id'])) {
    $usuarioId = $_SESSION['usuario_id']; // Obtener el ID del usuario en sesión
    // Obtener los seguros asociados a las reservas del usuario
    $segurosPorReserva = ReservaSeguroBD::obtenerSegurosPorUsuario($usuarioId);

    if (!empty($segurosPorReserva)) {
        echo json_encode(['success' => true, 'segurosPorReserva' => $segurosPorReserva]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se encontraron seguros para las reservas del usuario.']);
    }
    exit;
}

