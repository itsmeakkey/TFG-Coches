<?php
// Limpia el búfer de salida antes de cualquier salida
ob_start();
header('Content-Type: application/json');
require_once '../Modelo/VehiculoBD.php';
require_once '../Modelo/ReservaBD.php';

// Obtener el precio de un vehículo específico
if (isset($_GET['accion']) && $_GET['accion'] == 'obtenerPrecio' && isset($_GET['vehiculo_id'])) {

    $vehiculoId = $_GET['vehiculo_id'];
    $precioDia = VehiculoBD::obtenerPrecioVehiculo($vehiculoId);

    if ($precioDia !== null) {
        echo json_encode(['success' => true, 'precioDia' => $precioDia]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Precio no encontrado']);
    }
    exit;
}

// Acción para filtrar vehículos según los criterios proporcionados
if (isset($_POST['accion']) && $_POST['accion'] == 'filtrarVehiculos') {
    $marca = $_POST['marca'] ?? null;
    $modelo = $_POST['modelo'] ?? null;
    $precioMin = $_POST['precioMin'] ?? 0;
    $precioMax = $_POST['precioMax'] ?? PHP_INT_MAX;

    // Llama a la función del modelo para obtener vehículos que cumplan con los filtros
    $vehiculos = VehiculoBD::filtrarVehiculos($marca, $modelo, $precioMin, $precioMax);

    if (!empty($vehiculos)) {
        echo json_encode(['success' => true, 'vehiculos' => $vehiculos]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se encontraron vehículos con los filtros especificados.']);
    }
    exit;
}


// Acción para comparar dos vehículos
if (isset($_GET['accion']) && $_GET['accion'] == 'comparar' && isset($_GET['id1']) && isset($_GET['id2'])) {
    $id1 = $_GET['id1'];
    $id2 = $_GET['id2'];

    // Obtener detalles de los vehículos desde el modelo
    $vehiculo1 = VehiculoBD::obtenerDetallesVehiculo($id1);
    $vehiculo2 = VehiculoBD::obtenerDetallesVehiculo($id2);

    if ($vehiculo1 && $vehiculo2) {
        echo json_encode([
            'success' => true,
            'vehiculo1' => $vehiculo1,
            'vehiculo2' => $vehiculo2
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Uno o ambos vehículos no encontrados']);
    }
    exit;
}

// Comprueba si se ha enviado el campo 'buscarAlquiler'
if (isset($_POST['buscarAlquiler'])) {
    if (isset($_POST['fechaDesde']) && isset($_POST['fechaHasta'])) {
        $fechaDesde = $_POST['fechaDesde'];
        $fechaHasta = $_POST['fechaHasta'];

        // Obtén los vehículos disponibles
        $vehiculos = VehiculoBD::listarVehiculosDisponibles($fechaDesde, $fechaHasta);

        if (!empty($vehiculos)) {
            ob_start(); // Inicia la captura del output
            echo '<h3>VEHÍCULOS DISPONIBLES PARA TI:</h3>';
            echo '<div class="car-grid">';

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

            echo '</div>';
            $html = ob_get_clean();
            echo json_encode(['success' => true, 'html' => $html]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No hay vehículos disponibles']);
        }
    }
}
?>





