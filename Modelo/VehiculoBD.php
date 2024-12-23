<?php
class VehiculoBD {
    private static function conectar() {
        return new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
    }

    public static function listar() {
        $conexion = self::conectar();
        $stmt = $conexion->prepare("SELECT id, marca, modelo, matricula, plazas, combustible, precioDia, estado, imagen FROM vehiculos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerMarcas() {
        $query = "SELECT DISTINCT marca FROM vehiculos";
        $stmt = self::conectar()->query($query);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function obtenerModelosPorMarca($marca) {
        $query = "SELECT DISTINCT modelo FROM vehiculos WHERE marca = :marca";
        $stmt = self::conectar()->prepare($query);
        $stmt->bindParam(':marca', $marca, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function obtenerCombustiblesPorMarca($marca) {
        $query = "SELECT DISTINCT combustible FROM vehiculos WHERE marca = :marca";
        $stmt = self::conectar()->prepare($query);
        $stmt->bindParam(':marca', $marca, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }


    //PANEL CLIENTE
    public static function listarprincipal() {
        $conexion = self::conectar();
        $stmt = $conexion->prepare("SELECT id, marca, modelo, matricula, plazas, combustible, precioDia, estado, imagen FROM vehiculos LIMIT 9");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarVehiculosDisponibles($fechaDesde, $fechaHasta) {
        $conexion = self::conectar();
        $sql = "SELECT * FROM vehiculos WHERE estado = 'Disponible' AND id NOT IN (
            SELECT vehiculo_id FROM reservas WHERE fechaInicio <= :fechaHasta AND fechaFin >= :fechaDesde
        )";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':fechaDesde', $fechaDesde);
        $stmt->bindParam(':fechaHasta', $fechaHasta);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function actualizarEstadoVehiculo($vehiculoId, $nuevoEstado) {
        $conexion = self::conectar();
        $sql = "UPDATE vehiculos SET estado = :estado WHERE id = :vehiculoId";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':estado', $nuevoEstado);
        $stmt->bindParam(':vehiculoId', $vehiculoId);

        return $stmt->execute();
    }

    //SECCIÓN DE COMPARACIÓN
    public static function obtenerDetallesVehiculo($vehiculoId) {
        $conexion = self::conectar();
        $stmt = $conexion->prepare("SELECT id, marca, modelo, matricula, plazas, combustible, precioDia, estado, imagen FROM vehiculos WHERE id = ?");
        $stmt->execute([$vehiculoId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function filtrarVehiculos($marca, $modelo, $combustible, $precioMin, $precioMax) {
        $conexion = self::conectar();
        $query = "SELECT * FROM vehiculos WHERE precioDia BETWEEN :precioMin AND :precioMax";
        $params = [
            ':precioMin' => $precioMin,
            ':precioMax' => $precioMax,
        ];

        if (!empty($marca)) {
            $query .= " AND marca = :marca";
            $params[':marca'] = $marca;
        }

        if (!empty($modelo)) {
            $query .= " AND modelo = :modelo";
            $params[':modelo'] = $modelo;
        }

        if (!empty($combustible)) {
            $query .= " AND combustible = :combustible";
            $params[':combustible'] = $combustible;
        }

        //Depuración
        error_log("Consulta SQL: $query");
        error_log("Parámetros: " . print_r($params, true));

        $stmt = $conexion->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function obtenerPrecioVehiculo($vehiculoId) {
        $conexion = self::conectar();
        $sql = "SELECT precioDia FROM vehiculos WHERE id = :vehiculoId";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':vehiculoId', $vehiculoId, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado['precioDia'] : null;
    }


    //PANEL ADMIN
    public static function agregar($marca, $modelo, $matricula, $plazas, $combustible, $precioDia, $fechaMatriculacion, $estado, $rutaImagen) {
        try {
            $conexion = self::conectar();
            $stmt = $conexion->prepare("INSERT INTO vehiculos (marca, modelo, matricula, plazas, combustible, precioDia, fechaMatriculacion, estado, imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$marca, $modelo, $matricula, $plazas, $combustible, $precioDia, $fechaMatriculacion, $estado, $rutaImagen]);

            // Si la inserción fue bien, devuelve el ID del vehículo insertado
            $id = $conexion->lastInsertId();
            return ['success' => true, 'vehiculo' => [
                'id' => $id,
                'marca' => $marca,
                'modelo' => $modelo,
                'matricula' => $matricula,
                'plazas' => $plazas,
                'combustible' => $combustible,
                'precioDia' => $precioDia,
                'fechaMatriculacion' => $fechaMatriculacion,
                'estado' => $estado,
                'imagen' => $rutaImagen
            ]];
        } catch (PDOException $e) {
            // Manejo de errores
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public static function actualizar($id, $marca, $modelo, $matricula, $plazas, $combustible, $precioDia, $estado) {
        try {
            $conexion = self::conectar();
            $stmt = $conexion->prepare("UPDATE vehiculos SET marca = ?, modelo = ?, matricula = ?, plazas = ?, combustible = ?, precioDia = ?, estado = ? WHERE id = ?");
            $stmt->execute([$marca, $modelo, $matricula, $plazas, $combustible, $precioDia, $estado, $id]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public static function eliminar($id) {
        try {
            $conexion = self::conectar();
            $stmt = $conexion->prepare("DELETE FROM vehiculos WHERE id = ?");
            $stmt->execute([$id]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public static function verificarDuplicado($matricula) {
        $conexion = self::conectar();
        $stmt = $conexion->prepare("SELECT COUNT(*) FROM vehiculos WHERE matricula = ?");
        $stmt->execute([$matricula]);
        return $stmt->fetchColumn() > 0; // Devuelve true si ya existe un registro con la misma matrícula
    }
}
?>

