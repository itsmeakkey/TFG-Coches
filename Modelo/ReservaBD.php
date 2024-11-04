<?php
class ReservaBD
{
    //LÓGICAS PANEL ADMIN
    public static function listar()
    {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', '');
            $stmt = $conexion->prepare("SELECT * FROM reservas");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function eliminar($id) {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
            $stmt = $conexion->prepare("DELETE FROM reservas WHERE id = ?");
            $stmt->execute([$id]);
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



    //Obtener las reservas para la opción mis reservas de la barra de navegación
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

    //Operación para cancelar una reserva concreta
    public static function cancelarReserva($reservaId) {
        $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
        $sql = "DELETE FROM reservas WHERE id = :reservaId";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':reservaId', $reservaId);

        return $stmt->execute();
    }






}
?>
