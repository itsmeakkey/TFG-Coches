<?php
// Limpia el búfer de salida antes de cualquier salida
ob_start();
header('Content-Type: application/json');
require_once '../Modelo/VehiculoBD.php';
require_once '../Modelo/ReservaBD.php';

// Asegúrate de que estás recibiendo la solicitud POST

    // Comprueba si se ha enviado el campo 'buscarAlquiler'
    if (isset($_POST['buscarAlquiler'])) {
        // Captura las fechas
        if (isset($_POST['fechaDesde']) && isset($_POST['fechaHasta'])) {
            $fechaDesde = $_POST['fechaDesde'];
            $fechaHasta = $_POST['fechaHasta'];

            // Obtén los vehículos disponibles
            $vehiculos = VehiculoBD::listarVehiculosDisponibles($fechaDesde, $fechaHasta);

            if (!empty($vehiculos)) {
                ob_start(); // Inicia la captura del output
                echo '<h3>VEHÍCULOS DISPONIBLES PARA TI:</h3>';
                echo '<div class="car-grid">'; // Abre el contenedor de la cuadrícula

                foreach ($vehiculos as $vehiculo): ?>
                    <div class="car-card" id="car-<?php echo $vehiculo['id']; ?>">
                        <div class="car-info">
                            <img src="<?php echo $vehiculo['imagen']; ?>"
                                 alt="Coche <?php echo $vehiculo['marca'] . ' ' . $vehiculo['modelo']; ?>" class="car-image">
                            <h3><?php echo $vehiculo['marca'] . ' ' . $vehiculo['modelo']; ?></h3>
                            <p><b>Precio por día:</b> €<?php echo $vehiculo['precioDia']; ?></p>
                            <p><b>Plazas: </b><?php echo $vehiculo['plazas']; ?></p>
                            <p><b>Combustible: </b> <?php echo $vehiculo['combustible']; ?></p>

                            <!-- Botón "Reservar" -->
                            <button class="reservar-btn"
                                    onclick="mostrarModalSeguros(<?php echo $vehiculo['id']; ?>, '<?php echo $fechaDesde; ?>', '<?php echo $fechaHasta; ?>')">
                                Reservar
                            </button>
                        </div>
                    </div>
                <?php endforeach;

                echo '</div>'
                ;

                // Cierra el contenedor de la cuadrícula

                $html = ob_get_clean(); // Captura el HTML generado
                echo json_encode(['success' => true, 'html' => $html]); // Retorna como JSON
            } else {
                echo json_encode(['success' => false, 'error' => 'No hay vehículos disponibles']);
            }
        }
    }
?>


