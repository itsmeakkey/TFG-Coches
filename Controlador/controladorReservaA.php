<?php
session_start();
require_once '../Modelo/ReservaBD.php';
require_once '../Modelo/ReservaSeguroBD.php';
require_once '../Modelo/VehiculoBD.php';
//MIS RESERVAS
// Inicializa un array para almacenar los mensajes de respuesta
$response = [];

// Verificar si la sesión de usuario está activa
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'error' => 'Usuario no autenticado.']);
    exit;
}

$usuarioId = $_SESSION['usuario_id']; // Obtener el id del usuario de la sesión

// Añadir una reserva con la confirmación de vehiculo
if (isset($_POST['vehiculo_id']) && isset($_POST['fechaInicio']) && isset($_POST['fechaFin'])) {
    $vehiculoId = $_POST['vehiculo_id'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $usuarioId = $_SESSION['usuario_id']; // Tomamos el id del usuario de la sesión

    // Insertar la reserva en la base de datos
    $reservaInsertada = ReservaBD::insertarReserva($fechaInicio, $fechaFin, $usuarioId, $vehiculoId);

    if ($reservaInsertada) {
        // Si la reserva se inserta correctamente, cambia el estado del vehículo a "Ocupado"
        $estadoActualizado = VehiculoBD::actualizarEstadoVehiculo($vehiculoId, 'Ocupado');

        if ($estadoActualizado) {
            $response['success'] = true;

            // Verificar si se han enviado seguros
            if (isset($_POST['seguros']) && is_array($_POST['seguros'])) {
                $seguros = $_POST['seguros'];
                $reservaId = ReservaBD::obtenerUltimaReservaId(); // Obtener la ID de la última reserva

                foreach ($seguros as $seguroId) {
                    ReservaSeguroBD::insertarReservaSeguro($reservaId, $seguroId); // Insertar cada seguro asociado a la reserva
                }
            }
        } else {
            $response['success'] = false;
            $response['error'] = 'Error al actualizar el estado del vehículo';
        }
    } else {
        $response['success'] = false;
        $response['error'] = 'Error al insertar la reserva';
    }

    echo json_encode($response);
    exit; // Salir después de enviar la respuesta
}


// Obtener las reservas del usuario
if (isset($_GET['obtenerReservas'])) { // Usamos GET para obtener reservas
    $reservas = ReservaBD::obtenerReservasPorUsuario($usuarioId);

    if ($reservas) {
        $response['success'] = true;
        $response['reservas'] = $reservas;
    } else {
        $response['success'] = false;
        $response['error'] = 'No se encontraron reservas.';
    }

    echo json_encode($response);
    exit; // Salir después de enviar la respuesta
}

// Cancelar una reserva
if (isset($_POST['cancelarReserva']) && isset($_POST['reserva_id'])) {
    $reservaId = $_POST['reserva_id'];
    $cancelada = ReservaBD::cancelarReserva($reservaId); // Método para eliminar la reserva

    if ($cancelada) {
        $response['success'] = true;
        $response['message'] = 'Reserva cancelada con éxito';
    } else {
        $response['success'] = false;
        $response['error'] = 'Error al cancelar la reserva';
    }

    echo json_encode($response);
    exit; // Salir después de enviar la respuesta
}

// Si no se ha llegado a ninguna de las condiciones anteriores
echo json_encode(['success' => false, 'error' => 'Acción no válida.']);
exit; // Salir para evitar cualquier salida adicional
?>


