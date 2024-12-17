<?php

class ReparacionBD
{
    private static function conectar()
    {
        return new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
    }

    public static function agregar($vehiculoId, $fecha, $descripcion, $costo) {
        $query = "INSERT INTO reparaciones (vehiculo_id, fecha, descripcion, costo) VALUES (:vehiculoId, :fecha, :descripcion, :costo)";
        $id = self::conectar()->lastInsertId();
        $stmt = self::conectar()->prepare($query);
        $stmt->bindParam(':vehiculoId', $vehiculoId);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':costo', $costo);
        if ($stmt->execute()) {
            return [
                'success' => true,
                'reparacion' => [
                    'id' => $id,
                    'vehiculoId' => $vehiculoId,
                    'fecha' => $fecha,
                    'descripcion' => $descripcion,
                    'costo' => $costo
                ]
            ];
        } else {
            return ['success' => false];
        }
    }
    public static function listar() {
        $query = "
        SELECT 
            r.id, 
            r.fecha, 
            r.descripcion, 
            r.costo, 
            v.marca AS marcaVehiculo,
            v.modelo AS modeloVehiculo
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

    public static function actualizar($id, $fecha, $descripcion, $costo) {
        try {
            $conexion = self::conectar();
            $stmt = $conexion->prepare("UPDATE reparaciones SET fecha = ?, descripcion = ?, costo = ? WHERE id = ?");
            $stmt->execute([$fecha, $descripcion, $costo, $id]);

            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    public static function eliminar($id) {
        try {
            $conexion = self::conectar();
            $stmt = $conexion->prepare("DELETE FROM reparaciones WHERE id = ?");
            $stmt->execute([$id]);

            // Verificar si se eliminó alguna fila
            if ($stmt->rowCount() > 0) {
                return ['success' => true];
            } else {
                return ['success' => false, 'error' => 'No se encontró la reparación con el ID especificado'];
            }

        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

}