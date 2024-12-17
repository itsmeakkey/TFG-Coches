<h2>Gestionar Reservas</h2>
<p>Aquí puedes ver y gestionar las reservas.</p><br>
<form action="../Controlador/generarPdfReservas.php" method="post" target="_blank">
    <button type="submit" class="btn-generar-pdf">Generar PDF de Reservas</button>
</form>
<!-- Tabla para listar las reservas -->
<table>
    <thead>
    <tr>
        <th>Nº Reserva</th>
        <th>Cliente</th>
        <th>Vehículo reservado</th>
        <th>Fecha Inicio</th>
        <th>Fecha Fin</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody id="reservas-list">
    </tbody>
</table>
