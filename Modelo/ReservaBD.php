<?php
class ReservaBD
{
    //LÓGICAS PANEL ADMIN
    public static function listar()
    {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
            $stmt = $conexion->prepare("
            SELECT 
                r.id,
                r.fechaInicio,
                r.fechaFin,
                u.nombre AS nombreUsuario,
                u.apellidos AS apellidosUsuario,
                v.marca AS marcaVehiculo,
                v.modelo AS modeloVehiculo
            FROM 
                reservas r
            JOIN 
                usuarios u ON r.usuario_id = u.id
            JOIN 
                vehiculos v ON r.vehiculo_id = v.id
        ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function eliminar($id) {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');

            // Obtén el ID del vehículo asociado a la reserva
            $stmtVehiculo = $conexion->prepare("SELECT vehiculo_id FROM reservas WHERE id = ?");
            $stmtVehiculo->execute([$id]);
            $vehiculo = $stmtVehiculo->fetch(PDO::FETCH_ASSOC);

            if (!$vehiculo) {
                return ['success' => false, 'error' => 'No se encontró la reserva.'];
            }

            //Elimino la reserva
            $stmtEliminar = $conexion->prepare("DELETE FROM reservas WHERE id = ?");
            $stmtEliminar->execute([$id]);

            //Actualizo el estado del vehículo a 'Disponible'
            $stmtActualizarVehiculo = $conexion->prepare("UPDATE vehiculos SET estado = 'Disponible' WHERE id = ?");
            $stmtActualizarVehiculo->execute([$vehiculo['vehiculo_id']]);

            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }


    public static function actualizar($id, $fechaInicio, $fechaFin) {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
            $stmt = $conexion->prepare("UPDATE reservas SET fechaInicio = ?, fechaFin = ?, WHERE id = ?");
            $stmt->execute([$fechaInicio, $fechaFin, $id]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    //LÓGICAS PANEL USUARIO
    public static function insertarReserva($fechaInicio, $fechaFin, $usuarioId, $vehiculoId) {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configura el modo de error

            $sql = "INSERT INTO reservas (fechaInicio, fechaFin, usuario_id, vehiculo_id) 
                VALUES (:fechaInicio, :fechaFin, :usuarioId, :vehiculoId)";

            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':fechaInicio', $fechaInicio);
            $stmt->bindParam(':fechaFin', $fechaFin);
            $stmt->bindParam(':usuarioId', $usuarioId);
            $stmt->bindParam(':vehiculoId', $vehiculoId);

            return $stmt->execute();
        } catch (PDOException $e) {
            // Manejo de errores
            echo "Error al insertar reserva: " . $e->getMessage();
            return false;
        }
    }

    // Método para obtener el ID de la última reserva
    public static function obtenerUltimaReservaId() {
        $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
        $sql = "SELECT MAX(id) as ultima_id FROM reservas";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['ultima_id'];
    }

    //Obtención de las reservas para la opción "mis reservas" de la barra de navegación
    public static function obtenerReservasPorUsuario($usuarioId) {
        $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
        $sql = "SELECT r.id, r.fechaInicio, r.fechaFin, v.marca, v.modelo
            FROM reservas r
            JOIN vehiculos v ON r.vehiculo_id = v.id
            WHERE r.usuario_id = :usuarioId";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':usuarioId', $usuarioId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Cancelar una reserva concreta
    public static function cancelarReserva($reservaId)
    {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
            $conexion->beginTransaction();

            // Obtengo el id del vehículo
            $sqlVehiculo = "SELECT vehiculo_id FROM reservas WHERE id = :reservaId";
            $stmtVehiculo = $conexion->prepare($sqlVehiculo);
            $stmtVehiculo->bindParam(':reservaId', $reservaId);
            $stmtVehiculo->execute();

            $vehiculo = $stmtVehiculo->fetch(PDO::FETCH_ASSOC);
            if (!$vehiculo) {
                throw new Exception("No se encontró la reserva con ID $reservaId.");
            }

            $vehiculoId = $vehiculo['vehiculo_id'];

            //Si lo encuentra, cambio el estado a Disponible
            $sqlActualizarVehiculo = "UPDATE vehiculos SET estado = 'Disponible' WHERE id = :vehiculoId";
            $stmtActualizarVehiculo = $conexion->prepare($sqlActualizarVehiculo);
            $stmtActualizarVehiculo->bindParam(':vehiculoId', $vehiculoId);
            $stmtActualizarVehiculo->execute();

            //Borro la reserva
            $sqlEliminarReserva = "DELETE FROM reservas WHERE id = :reservaId";
            $stmtEliminarReserva = $conexion->prepare($sqlEliminarReserva);
            $stmtEliminarReserva->bindParam(':reservaId', $reservaId);
            $stmtEliminarReserva->execute();

            $conexion->commit();
            return ['success' => true];
        } catch (Exception $e) {
            $conexion->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
?>
