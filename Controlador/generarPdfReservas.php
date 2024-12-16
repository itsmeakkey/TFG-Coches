<?php
require_once '../vendor/autoload.php';

use setasign\Fpdi\Fpdi;
class PDFConPie extends Fpdi
{
    // Función para el pie de página
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0, 10, 'Pag ' . $this->PageNo(), 0, 0, 'C');
    }
}

class GenerarPdfReservas {
    public static function generarPdf()
    {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
            $stmt = $conexion->prepare("SELECT reservas.id, reservas.fechaInicio, reservas.fechaFin, usuarios.nombre AS usuarioNombre, usuarios.apellidos AS usuarioApellidos, vehiculos.marca, vehiculos.modelo FROM reservas 
                                        INNER JOIN usuarios ON reservas.usuario_id = usuarios.id
                                        INNER JOIN vehiculos ON reservas.vehiculo_id = vehiculos.id");
            $stmt->execute();
            $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //Instancia de la clase personalizada con pie
            $pdf = new PDFConPie();
            $pdf->AddPage();

            // Encabezado
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->SetTextColor(50, 50, 50);
            $pdf->Cell(0, 10, 'RENT A CAR - RESERVAS ACTIVAS', 0, 1, 'C');
            $pdf->Ln(5);
            $pdf->SetDrawColor(128, 128, 128);
            $pdf->Line(10, 20, 200, 20);
            $pdf->Ln(10);

            // Encabezado de la tabla
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetFillColor(230, 230, 230);
            $pdf->SetDrawColor(200, 200, 200);
            $pdf->Cell(20, 10, 'Num', 1, 0, 'C', true);
            $pdf->Cell(50, 10, 'Usuario', 1, 0, 'C', true);
            $pdf->Cell(50, 10, 'Vehiculo', 1, 0, 'C', true);
            $pdf->Cell(35, 10, 'Inicio', 1, 0, 'C', true);
            $pdf->Cell(35, 10, 'Fin', 1, 1, 'C', true);

            // Datos de las reservas
            $pdf->SetFont('Arial', '', 10);
            foreach ($reservas as $reserva) {
                $usuario = $reserva['usuarioNombre'] . ' ' . $reserva['usuarioApellidos'];
                $vehiculo = $reserva['marca'] . ' ' . $reserva['modelo'];

                $pdf->Cell(20, 8, $reserva['id'], 1, 0, 'C');
                $pdf->Cell(50, 8, $usuario, 1, 0, 'C');
                $pdf->Cell(50, 8, $vehiculo, 1, 0, 'C');
                $pdf->Cell(35, 8, $reserva['fechaInicio'], 1, 0, 'C');
                $pdf->Cell(35, 8, $reserva['fechaFin'], 1, 1, 'C');
            }

            // Generado del archivo PDF
            $pdf->Output('I', 'Reservas_Activas.pdf');
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

// Llamada a la función para generar el PDF
GenerarPdfReservas::generarPdf();
?>
