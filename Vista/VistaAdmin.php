<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../Vista/css/cssAdmin.css">
    <!-- Enlace al archivo JS, defer carga script de forma paralela tras renderizar -->
    <script src="../Vista/js/admin.js" defer></script>
</head>
<body>

<header>
    <h1>Panel de Administración</h1>
    <div class="header-right">
        <form method='post' action='../Controlador/controladorUsuario.php'>
            <p class='Bienvenida'>Bienvenido/a <?php echo $_SESSION["usuario"]; ?></p>
            <input class="salir" type='submit' value='Cerrar sesión' name='salir'>
        </form>
    </div>
</header>

<!-- Barra de navegación -->
<nav class="navbar">
    <ul>
        <li><a href="#" data-section="clientes">Gestionar Clientes</a></li>
        <li><a href="#" data-section="vehiculos">Gestionar Vehículos</a></li>
        <li><a href="#" data-section="reparaciones">Gestionar Reparaciones</a></li>
        <li><a href="#" data-section="seguros">Gestionar Seguros</a></li>
        <li><a href="#" data-section="reservas">Gestionar Reservas</a></li>
        <li><a href="#" data-section="pagos">Gestionar Pagos</a></li>
    </ul>
</nav>

<!-- Contenedor dinámico donde se cargarán las secciones por ajax-->
<div class="main-content" id="content">
    <h2>Bienvenido al Panel de Administración</h2>
    <p>Seleccione una sección del menú para gestionar los datos correspondientes.</p>
    <img src="../Extras/panel_admin/logo_final.png">
</div>
<!-- Footer -->
<footer>
    <p>&copy; 2024 Rent a Car | Diseñado por David Ruiz Aranda</p>
</footer>

</body>
</html>


