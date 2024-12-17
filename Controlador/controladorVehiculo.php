<?php
/*Importaciones*/
require_once '../Modelo/VehiculoBD.php';

//ADMIN
//Listar
if (isset($_GET['accion']) && $_GET['accion'] == 'listar') {
    $vehiculos = VehiculoBD::listar();
    echo json_encode($vehiculos);
//Eliminar
} elseif (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    $id = $_POST['id'];
    $resultado = VehiculoBD::eliminar($id);
    echo json_encode($resultado);
//Actualizar
} elseif (isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
    $id = $_POST['id'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $matricula = $_POST['matricula'];
    $plazas = $_POST['plazas'];
    $combustible = $_POST['combustible'];
    $precioDia = $_POST['precioDia'];
    $estado = $_POST['estado'];

    $resultado = VehiculoBD::actualizar($id, $marca, $modelo, $matricula, $plazas, $combustible, $precioDia, $estado);
    echo json_encode($resultado);
//Crear
} elseif (isset($_POST['accion']) && $_POST['accion'] == 'agregar') {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $matricula = $_POST['matricula'];
    $plazas = $_POST['plazas'];
    $combustible = $_POST['combustible'];
    $precioDia = $_POST['precioDia'];
    $fechaMatriculacion = $_POST['fechaMatriculacion'];
    $estado = $_POST['estado'];

    //Manejo de la imagen
    $imagen = $_FILES['imagen'];
    $rutaImagen = '../Extras/principal/coche' . time() . '.' . pathinfo($imagen['name'], PATHINFO_EXTENSION);

    //Limpia cualquier salida previa
    ob_clean();
    header('Content-Type: application/json');

    //Verifica si la matrícula existe
    $resultado = VehiculoBD::verificarDuplicado($matricula);
    if ($resultado) {
        echo json_encode(['success' => false, 'error' => 'La matrícula ya existe']);
    } else {
        //Agrego el nuevo vehículo
        $resultado = VehiculoBD::agregar($marca, $modelo, $matricula, $plazas, $combustible, $precioDia, $fechaMatriculacion, $estado, $rutaImagen);

        //Mueve la imagen a la ruta
        if (move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
            echo json_encode($resultado);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al subir la imagen']);
        }
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Acción no válida']);
}
?>





