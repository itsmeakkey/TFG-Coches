<?php
class PagoBD
{
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
}
?>
