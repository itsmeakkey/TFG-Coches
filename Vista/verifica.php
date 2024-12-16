<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Email</title>
    <style>
        body {
            font-family: Poppins;
            background-color: #2a76d2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
            background-color: #ffffff;
            border: 1px solid #d1d9e6;
            border-radius: 15px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.6);
            padding: 30px 40px;
            width: 100%;
            max-width: 400px;
        }
        h1 {
            color: #2a4365;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            color: #2f855a;
            background-color: #dcf8e3;
            border: 1px solid #c6f6d5;
        }
        .error {
            color: #c53030;
            background-color: #fff5f5;
            border: 1px solid #fed7d7;
        }
        img {
            border-radius: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <center><img src="../Extras/logo_copy.png"></center><br>

    <h1>Verificación de Email</h1>
    <?php
    require_once "../Modelo/BaseDeDatosConexion.php";
    require_once "../Modelo/Password.php";
    require_once "../Modelo/UsuarioBD.php";

    if (!isset($_SESSION)) {
        session_start();
    }

    $conexion = BaseDeDatosConexion::getConexion('coches');

    if (isset($_GET['email']) && isset($_GET['token'])) {
        $email = $_GET['email'];
        $token = $_GET['token'];

        $personaBD = new UsuarioBD($conexion);

        if ($personaBD->activarCuenta($email, $token)) {
            echo '<div class="message success">Usuario verificado correctamente, ya puede iniciar sesión en la <a href="https://server.edu/TFG-Coches/"> página principal</a>.</div>';
        } else {
            echo '<div class="message error">Hubo un error al activar la cuenta.</div>';
        }
    } else {
        echo '<div class="message error">Email no encontrado.</div>';
    }
    ?>
</div>
</body>
