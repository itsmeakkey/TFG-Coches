<?php
class PagoBD
{

    private static function conectar() {
        return new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
    }
    //LÓGICAS PANEL ADMIN
    public static function listar()
    {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
            $stmt = $conexion->prepare("SELECT p.fecha, p.monto, pl.tipo, pl.num_cuotas
                                        FROM pagos p
                                        JOIN plan_pagos pl ON p.id_plan_pagos = pl.id");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }

    }

    //LÓGICAS USUARIO
    public static function insertarPago($pagoData) {
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
