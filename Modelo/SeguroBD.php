<?php
class SeguroBD {
    //LÓGICAS PANEL ADMIN
    private static function conectar() {
        return new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
    }
    public static function listar() {
        $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
        $stmt = $conexion->prepare("SELECT id, tipo, cobertura, precio, descripcion FROM seguros");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function actualizar($id, $tipo, $cobertura, $precio, $descripcion) {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
            $stmt = $conexion->prepare("UPDATE seguros SET tipo = ?, cobertura = ?, precio = ?, descripcion = ? WHERE id = ?");
            $stmt->execute([$tipo, $cobertura, $precio, $descripcion, $id]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public static function eliminar($id) {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
            $stmt = $conexion->prepare("DELETE FROM seguros WHERE id = ?");
            $stmt->execute([$id]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public static function agregar($tipo, $cobertura, $precio, $descripcion) {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
            $stmt = $conexion->prepare("INSERT INTO seguros (tipo, cobertura, precio, descripcion) VALUES (?, ?, ?, ?)");
            $stmt->execute([$tipo, $cobertura, $precio, $descripcion]);

            // Obtén el último ID insertado
            $id = $conexion->lastInsertId();

            // Devuelve los datos del nuevo seguro
            return [
                'success' => true,
                'seguro' => [
                    'id' => $id,
                    'tipo' => $tipo,
                    'cobertura' => $cobertura,
                    'precio' => $precio,
                    'descripcion' => $descripcion
                ]
            ];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    //LÓGICAS PARA USUARIO
    public static function obtenerSegurosPorTipo($tipo) {
        $conexion = self::conectar();
        $stmt = $conexion->prepare("SELECT * FROM seguros WHERE tipo = :tipo");
        $stmt->bindParam(':tipo', $tipo);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



}


?>
