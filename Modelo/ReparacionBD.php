<?php

class ReparacionBD
{
    private static function conectar()
    {
        return new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
    }

    public static function agregarReparacion($vehiculoId, $fecha, $descripcion, $costo) {
        $query = "INSERT INTO reparaciones (vehiculo_id, fecha, descripcion, costo) VALUES (:vehiculoId, :fecha, :descripcion, :costo)";
        $stmt = self::conectar()->prepare($query);
        $stmt->bindParam(':vehiculoId', $vehiculoId);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':costo', $costo);
        return $stmt->execute();
    }

    public static function listar() {
        $query = "
        SELECT 
            r.id, 
            r.fecha, 
            r.descripcion, 
            r.costo, 
            v.marca, 
            v.modelo
        FROM 
            reparaciones r
        JOIN 
            vehiculos v
        ON 
            r.vehiculo_id = v.id
    ";
        $stmt = self::conectar()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}