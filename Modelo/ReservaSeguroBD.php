<?php

class ReservaSeguroBD {

    public static function insertarReservaSeguro($reservaId, $seguroId) {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO reserva_seguro (reserva_id, seguro_id) VALUES (:reservaId, :seguroId)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':reservaId', $reservaId);
            $stmt->bindParam(':seguroId', $seguroId);

            return $stmt->execute();
        } catch (PDOException $e) {
            // Manejo de errores
            return false;
        }
    }

// Modelo: ReservaSeguroBD.php
    public static function obtenerSegurosPorUsuario($usuarioId) {
        $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');

        $sql = "
        SELECT s.id, s.tipo, s.cobertura, s.precio, s.descripcion, rs.reserva_id, v.marca, v.modelo
        FROM reserva_seguro rs
        INNER JOIN seguros s ON rs.seguro_id = s.id
        INNER JOIN reservas r ON rs.reserva_id = r.id
        INNER JOIN vehiculos v ON r.vehiculo_id = v.id
        WHERE r.usuario_id = :usuarioId";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':usuarioId', $usuarioId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }





}
?>
