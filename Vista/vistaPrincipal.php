<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cliente</title>
    <link rel="stylesheet" href="../Vista/css/cssPrincipal.css">
    <script src="../Vista/js/cliente.js" defer></script>
</head>
<body>

<header>
    <a href="#" onclick="event.preventDefault(); location.reload();"> <!--Recarga la página-->
        <img class="logo" src="../Extras/logo_copy.png" alt="Logo">
    </a>

    <div class="header-right">
        <form method='post' action='../Controlador/controladorUsuario.php'>
            <p class='Bienvenida'>Bienvenido/a, <?php echo $_SESSION["usuario"]; ?></p>
            <input class="salir" type='submit' value='Cerrar sesión' name='salir'>
        </form>
    </div>
</header>

<!-- Barra de navegación para clientes -->
<nav class="navbar">
    <ul>
        <li><a href="#" data-section="inicio">Inicio</a></li>
        <li><a href="#" data-section="misReservas">Mis Reservas</a></li>
        <li><a href="#" data-section="seguros">Seguros</a></li>
        <li><a href="#" data-section="perfil">Perfil</a></li>
        <li><a href="#" data-section="comparar">Comparar</a></li>
    </ul>
</nav>
<!-- Contenedor dinámico donde se cargarán las secciones por ajax-->
<div class="main-content" id="content">
    <h2>¡COMIENZA A ALQUILAR!</h2>
    <form class="reserva-form" id="reservaForm" method="post">
        <input type="hidden" name="buscarAlquiler" value="1">
        <label for="fechaDesde">Desde:</label>
        <input type="date" id="fechaDesde" name="fechaDesde" required>

        <label for="fechaHasta">Hasta:</label>
        <input type="date" id="fechaHasta" name="fechaHasta" required>

        <button type="submit">Buscar</button>
    </form>

    <h3>NUESTROS COCHES</h3>
    <div class="car-grid">
        <!-- Listo los vehículos existentes en la BD -->
        <!-- Es normal que no encuentre la variable porque la vista es llamdada desde una función -->
        <?php foreach ($vehiculos as $vehiculo): ?>
            <div class="car-card">
                <div class="car-info">
                    <img src="<?php echo $vehiculo['imagen']; ?>" alt="Coche <?php echo $vehiculo['marca'] . ' ' . $vehiculo['modelo']; ?>" class="car-image">
                    <h3><?php echo $vehiculo['marca'] . ' ' . $vehiculo['modelo']; ?></h3>
                    <p><b>Precio por día:</b> €<?php echo $vehiculo['precioDia']; ?></p>
                    <p><b>Plazas: </b><?php echo $vehiculo['plazas']; ?></p>
                    <p><b>Combustible: </b> <?php echo $vehiculo['combustible']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>
<!-- Modal de Selección de Seguros en el alquiler de un vehículo -->
<div id="modalSeguros" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="cerrarModalSeguros()">&times;</span>
        <h3>Selecciona los seguros para tu alquiler</h3>
        <form id="formSeguros">
            <input type="hidden" id="vehiculoId">
            <input type="hidden" id="fechaInicio">
            <input type="hidden" id="fechaFin">

            <!-- Seguros obligatorios y opcionales -->
            <div id="segurosObligatorios" class="seguros-section">
                <h4>Seguros Obligatorios:</h4>
            </div>
            <div id="segurosOpcionales" class="seguros-section">
                <h4>Seguros Opcionales:</h4>
            </div>

            <!-- Método de pago y monto total -->
            <div>
                <label for="metodoPago">Método de Pago:</label>
                <select id="metodoPago" required>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="paypal">PayPal</option>
                    <option value="transferencia">Transferencia Bancaria</option>
                </select>
            </div>
            <p><b>Monto Total:</b> €<span id="montoTotal"></span></p>

            <button type="button" onclick="confirmarReservaConSeguros()" class="confirm-btn">Confirmar Alquiler</button>
        </form>
    </div>
</div>





</div>
<!-- Footer -->
<footer>
    <p>&copy; 2024 Rent a Car | Diseñado por David Ruiz Aranda</p>
</footer>

</body>
</html>
