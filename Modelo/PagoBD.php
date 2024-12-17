<?php

class PagoBD
{

    private static function conectar()
    {
        return new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
    }
    //LÓGICAS PANEL ADMIN
    public static function listar()
    {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
            $stmt = $conexion->prepare("SELECT 
                                        id,  
                                        descripcion, 
                                        monto_total, 
                                        metodo_pago, 
                                        reserva_id
                                    FROM pagos");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function eliminar($id)
    {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
            $stmt = $conexion->prepare("DELETE FROM pagos WHERE id = ?");
            $stmt->execute([$id]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public static function actualizar($id, $descripcion, $monto_total, $metodo_pago)
    {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');

            $stmt = $conexion->prepare("UPDATE pagos 
                                    SET descripcion = ?, 
                                        monto_total = ?, 
                                        metodo_pago = ? 
                                    WHERE id = ?");
            $stmt->execute([$descripcion, $monto_total, $metodo_pago, $id]);

            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }


    //LÓGICAS USUARIO
    public static function insertarPago($pagoData)
    {
        $conexion = self::conectar();
        $sql = "INSERT INTO pagos (descripcion, monto_total, metodo_pago, reserva_id) VALUES (:descripcion, :monto_total, :metodo_pago, :reserva_id)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':descripcion', $pagoData['descripcion']);
        $stmt->bindParam(':monto_total', $pagoData['monto_total']);
        $stmt->bindParam(':metodo_pago', $pagoData['metodo_pago']);
        $stmt->bindParam(':reserva_id', $pagoData['reserva_id']);

        return $stmt->execute();
    }

}

?>
