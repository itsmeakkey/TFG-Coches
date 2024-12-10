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

    public static function actualizar($id, $tipo, $descripcion, $monto_total, $metodo_pago, $reserva_id)
    {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
            $stmt = $conexion->prepare("UPDATE pagos 
                                    SET tipo = ?, 
                                        descripcion = ?, 
                                        monto_total = ?, 
                                        metodo_pago = ?, 
                                        reserva_id = ? 
                                    WHERE id = ?");
            $stmt->execute([$tipo, $descripcion, $monto_total, $metodo_pago, $reserva_id, $id]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }


    //LÓGICAS USUARIO
    public static function insertarPago($pagoData)
    {
        $conexion = self::conectar();

        $sql = "INSERT INTO pagos (tipo, descripcion, monto_total, metodo_pago, reserva_id) VALUES (:tipo, :descripcion, :monto_total, :metodo_pago, :reserva_id)";
        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':tipo', $pagoData['tipo']);
        $stmt->bindParam(':descripcion', $pagoData['descripcion']);
        $stmt->bindParam(':monto_total', $pagoData['monto_total']);
        $stmt->bindParam(':metodo_pago', $pagoData['metodo_pago']);
        $stmt->bindParam(':reserva_id', $pagoData['reserva_id']);

        return $stmt->execute();
    }

}

?>
