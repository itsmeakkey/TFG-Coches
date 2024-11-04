<?php
require_once "BaseDeDatosConexion.php";
require_once "Password.php";
require_once "VehiculoBD.php";

//require_once '../../../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class UsuarioBD
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function login($correo, $password)
    {
        $consulta = $this->conexion->prepare("SELECT * FROM usuarios WHERE correo = :correo");
        $consulta->bindParam(':correo', $correo);
        $consulta->execute();

        if ($consulta->rowCount() > 0) {
            $fila = $consulta->fetch(PDO::FETCH_ASSOC);
            $hash = $fila['password'];

            if (password_verify($password, $hash)) {
                $_SESSION["correo"] = $correo;
                $_SESSION["usuario"] = $fila['nombre'];
                $_SESSION["dni"] = $fila['dni'];
                $_SESSION["usuario_id"] = $fila['id']; // Almacena el ID del usuario
                $tipo = $fila['tipo'];
                $_SESSION["tipo"] = $fila['tipo'];


                switch ($tipo) {
                    case 1:
                        // Obtener los vehículos antes de cargar la vista
                        $vehiculos = VehiculoBD::listarprincipal();
                        require_once '../Vista/vistaPrincipal.php';
                        break;
                    case 2:
                        require_once '../Vista/vistaAdmin.php';
                        break;
                    default:
                        $_SESSION ['error'] = "Debe verificar su usuario a través del email.";
                        header('location: ../index.php');
                }
            } else {
                $_SESSION ['error'] = "Error: la contraseña introducida no es correcta";
                header('location: ../index.php');
            }
        } else {
            $_SESSION ['error'] = "Error: el correo introducido no es válido";
            header('location: ../index.php');
        }
    }


    public function registrar($nombre, $apellidos, $dni, $correo, $password, $fechaNacimiento, $telefono, $localidad, $provincia, $cp, $tipo)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si el correo ya está registrado
        $stmt = $this->conexion->prepare("SELECT * FROM usuarios WHERE correo = :correo");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "Error: El correo introducido correo ya existe";
            header("Refresh:0");
        } else {
            // Verificar si el DNI ya está registrado
            $stmt = $this->conexion->prepare("SELECT * FROM usuarios WHERE dni = :dni");
            $stmt->bindParam(':dni', $dni);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $_SESSION['error'] = "Error: el DNI ya está registrado";
                header("Refresh:0");
            } else {
                $stmt = $this->conexion->prepare("INSERT INTO usuarios (dni, apellidos, nombre, fechaNacimiento, telefono, correo, localidad, provincia, cp, tipo, password) VALUES (:dni, :apellidos, :nombre, :fechaNacimiento, :telefono, :correo, :localidad, :provincia, :cp, :tipo, :password)");
                $stmt->bindParam(':dni', $dni);
                $stmt->bindParam(':apellidos', $apellidos);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':correo', $correo);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':fechaNacimiento', $fechaNacimiento);
                $stmt->bindParam(':telefono', $telefono);
                $stmt->bindParam(':localidad', $localidad);
                $stmt->bindParam(':provincia', $provincia);
                $stmt->bindParam(':cp', $cp);
                $stmt->bindParam(':tipo', $tipo);

                if ($stmt->execute()) {
                    $_SESSION['error'] = '<span style="color: white;">Usuario registrado correctamente, debe verificarlo a través de su email.</span>';
                    $hash = md5(rand(0, 2000));
                    list(, $dominio) = explode('@', $correo);
                    if ($dominio == 'server.edu') {
                        $mensaje = "Hola, has recibido este mensaje porque has iniciado el registro en nuestra web.\r\n
        Pulsa o copia el siguiente enlace en un navegador para confirmar el registro:\r\n\r\n
        https://server.edu/proyecto_coches/coches/Vista/verifica.php?email=" . $correo . "&token=" . $hash;
                        $mensaje = wordwrap($mensaje, 70);
                        $cabeceras = 'From: noreply@server.edu' . "\r\n";
                        mail($correo, "Nuevo usuario", $mensaje, $cabeceras);
                    } else {
                        if (!UsuarioBD::enviarCorreo($correo, $hash)) {
                            header("Location: ../Vista/vistaRegistro.php");
                        }
                    }
                    header('location: ../index.php');
                } else {
                    $_SESSION['error'] = "Error al registrar el usuario";
                    header("Refresh:0");
                }
            }
        }
        $stmt->close();
    }


    public function activarCuenta($email, $token)
    {
        /*Creamos una consulta para actualizar el tipo que pasa a ser 1 y almacenamos el token */
        $stmt = $this->conexion->prepare("UPDATE usuarios SET tipo = 1, token = :token WHERE correo = :correo");
        $stmt->bindParam(':correo', $email);
        $stmt->bindParam(':token', $token);

        /*La ejecutamos si sale bien devolvemos true y si no devolvemos false*/
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
    }


    public static function enviarCorreo($correo, $hash)
    {
        //Create a new PHPMailer instance
        $mail = new PHPMailer();
        $mail->IsSMTP();
        //Configuracion servidor mail
        $mail->From = "noreply@gmail.com"; //remitente
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls'; //seguridad
        $mail->Host = "smtp.gmail.com"; // servidor smtp
        $mail->Port = 587; //puerto
        $mail->Username = 'david.secunmail@gmail.com'; //nombre usuario de google
        $mail->Password = 'zszn ifzu lfmd lequ'; //contraseña de aplicaciones de google
        $mail->AddAddress($correo); // Usuario que se envia
        $mail->Subject = "Nuevo usuario"; //Sujeto
        /*Mensaje*/
        $mail->Body = "Hola, has recibido este mensaje porque has iniciado el registro en nuestra web.\r\n
        Pulsa o copia el siguiente enlace en un navegador para confirmar el registro:\r\n\r\n
        https://server.edu/proyecto_coches/coches/Vista/verifica.php?email=" . $correo . "&token=" . $hash;
        /*Si el correo no se envia entramos al if*/
        if (!$mail->Send()) {
            /*Verificamos si la sesion esta abierta*/
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            /*Mensaje de error y devolvemos false*/
            $_SESSION['error'] = "Error al enviar el correo electrónico";
            return false;
        }
        return true;
    }


    //LÓGICAS PANEL DE ADMINISTRADOR

    //Llamada a los datos de la tabla
    public static function listar()
    {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
            $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE tipo = 1");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
        // Manejo de errores
            return [];
        }
    }

    //Realiza cambios en la base de datos una vez confirmados los cambios en la fila
    public static function actualizar($id, $dni, $apellidos, $nombre, $fechaNacimiento, $telefono, $correo, $localidad, $provincia, $cp) {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
            $stmt = $conexion->prepare("UPDATE usuarios SET dni = ?, apellidos = ?, nombre = ?, fechaNacimiento = ?, telefono = ?, correo = ?, localidad = ?, provincia = ?, cp = ? WHERE id = ?");
            $stmt->execute([$dni, $apellidos, $nombre, $fechaNacimiento, $telefono, $correo, $localidad, $provincia, $cp, $id]);

            // Si la actualización fue bien
            return ['success' => true];
        } catch (PDOException $e) {
            // Manejo de errores
            return ['success' => false, 'error' => $e->getMessage()]; // Retorna error en caso de fallo
        }
    }


    //Eliminación de la fila de cliente
    public static function eliminar($id) {
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
            $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);
            // Si la eliminación fue bien
            return ['success' => true];
        } catch (PDOException $e) {
            // Manejo de errores
            return ['success' => false, 'error' => $e->getMessage()]; // Retorna error en caso de fallo
        }
    }

    //LÓGICAS VISTAS DE CLIENTE
    public static function obtenerUsuarioPorId($usuarioId) {
        $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
        $sql = "SELECT nombre, apellidos, correo, telefono, localidad, provincia, cp FROM usuarios WHERE id = :usuarioId";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':usuarioId', $usuarioId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function actualizarUsuario($usuarioId, $nombre, $apellidos, $correo, $telefono, $localidad, $provincia, $cp) {
        $conexion = new PDO('mysql:host=localhost;dbname=coches', 'root', 'Ciclo2gs');
        $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, correo = :correo, telefono = :telefono, localidad = :localidad, provincia = :provincia, cp = :cp WHERE id = :usuarioId";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':usuarioId', $usuarioId);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':localidad', $localidad);
        $stmt->bindParam(':provincia', $provincia);
        $stmt->bindParam(':cp', $cp);
        return $stmt->execute();
    }



}

