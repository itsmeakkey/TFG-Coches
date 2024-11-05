<?php
session_start();
require_once '../Modelo/ReservaBD.php';
require_once '../Modelo/ReservaSeguroBD.php';
require_once '../Modelo/VehiculoBD.php';
require_once '../Modelo/PagoBD.php';

header('Content-Type: application/json');

// Verificar si la sesión de usuario está activa
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'error' => 'Usuario no autenticado.']);
    exit;
}

$usuarioId = $_SESSION['usuario_id'];

// Añadir una reserva con la confirmación de vehículo
if (isset($_POST['vehiculo_id']) && isset($_POST['fechaInicio']) && isset($_POST['fechaFin'])) {
    $vehiculoId = $_POST['vehiculo_id'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $montoTotal = $_POST['montoTotal'];
    $metodoPago = $_POST['metodoPago'];

    // Insertar la reserva en la base de datos
    $reservaInsertada = ReservaBD::insertarReserva($fechaInicio, $fechaFin, $usuarioId, $vehiculoId);

    if ($reservaInsertada) {
        // Cambiar el estado del vehículo a "Ocupado"
        $estadoActualizado = VehiculoBD::actualizarEstadoVehiculo($vehiculoId, 'Ocupado');

        if ($estadoActualizado) {
            $response['success'] = true;

            // Verificar si se han enviado seguros
            if (isset($_POST['seguros']) && is_array($_POST['seguros'])) {
                $seguros = $_POST['seguros'];
                $reservaId = ReservaBD::obtenerUltimaReservaId();

                foreach ($seguros as $seguroId) {
                    ReservaSeguroBD::insertarReservaSeguro($reservaId, $seguroId);
                }
            }

            // Insertar el pago en la tabla `pagos`
            $pagoInsertado = PagoBD::insertarPago([
                'tipo' => 'pago único',
                'descripcion' => 'Pago de reserva',
                'monto_total' => $montoTotal,
                'metodo_pago' => $metodoPago,
                'reserva_id' => $reservaId,
            ]);

            if ($pagoInsertado) {
                $response['success'] = true;
                $response['message'] = 'Reserva y pago confirmados con éxito.';
            } else {
                $response['success'] = false;
                $response['error'] = 'Error al procesar el pago.';
            }

            // Devuelve la respuesta y termina la ejecución del script
            echo json_encode($response);
            exit;
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al actualizar el estado del vehículo.']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al insertar la reserva.']);
        exit;
    }
}

// Obtener las reservas del usuario
if (isset($_GET['obtenerReservas'])) {
    $reservas = ReservaBD::obtenerReservasPorUsuario($usuarioId);

    if ($reservas) {
        echo json_encode(['success' => true, 'reservas' => $reservas]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se encontraron reservas.']);
    }
    exit;
}

// Cancelar una reserva
if (isset($_POST['cancelarReserva']) && isset($_POST['reserva_id'])) {
    $reservaId = $_POST['reserva_id'];
    $cancelada = ReservaBD::cancelarReserva($reservaId);

    if ($cancelada) {
        echo json_encode(['success' => true, 'message' => 'Reserva cancelada con éxito.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al cancelar la reserva.']);
    }
    exit;
}

// Si no se ha llegado a ninguna de las condiciones anteriores, salida de error
echo json_encode(['success' => false, 'error' => 'Acción no válida.']);
exit;
?>



