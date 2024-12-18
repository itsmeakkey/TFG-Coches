<?php

class ReparacionBD
{
    //LÓGICAS ADMIN (ÚNICAMENTE)
    private static function conectar()
    {
        return new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
    }

    public static function agregar($vehiculoId, $fecha, $descripcion, $costo) {
        try {
            $db = self::conectar();

            //Inserta la reparación en la base de datos
            $query = "INSERT INTO reparaciones (vehiculo_id, fecha, descripcion, costo) VALUES (:vehiculoId, :fecha, :descripcion, :costo)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':vehiculoId', $vehiculoId);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':costo', $costo);

            if ($stmt->execute()) {

                $id = $db->lastInsertId();

                $vehiculoQuery = "SELECT marca, modelo FROM vehiculos WHERE id = :vehiculoId";
                $stmtVehiculo = $db->prepare($vehiculoQuery);
                $stmtVehiculo->bindParam(':vehiculoId', $vehiculoId);
                $stmtVehiculo->execute();

                $vehiculo = $stmtVehiculo->fetch(PDO::FETCH_ASSOC);

                if ($vehiculo) {
                    return [
                        'success' => true,
                        'reparacion' => [
                            'id' => $id,
                            'marcaVehiculo' => $vehiculo['marca'],
                            'modeloVehiculo' => $vehiculo['modelo'],
                            'fecha' => $fecha,
                            'descripcion' => $descripcion,
                            'costo' => $costo
                        ]
                    ];
                } else {
                    return ['success' => false, 'error' => 'No se encontró el vehículo.'];
                }
            } else {
                return ['success' => false, 'error' => 'Error al insertar la reparación.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
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