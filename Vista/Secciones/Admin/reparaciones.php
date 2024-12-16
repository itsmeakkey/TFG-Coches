<!-- ../Vista/Secciones/Admin/reparaciones.php -->
<h2>Gestionar Reparaciones</h2>
<p>Aquí puedes ver y gestionar las reparaciones de los vehículos</p><br>

<!-- Botón para abrir el modal de nueva reparación -->
<button class="crear" id="nuevaReparacionButton">Nueva Reparación</button>

<!-- Modal para agregar una nueva reparación -->
<div id="nuevaReparacionModal" style="display: none;">
    <h2>Agregar Nueva Reparación</h2>
    <form id="formNuevaReparacion">
        <!-- Selección de vehículo -->
        <select id="vehiculo" required>
            <option value="" disabled selected>Seleccione un vehículo</option>
            <!-- Aquí se cargarán dinámicamente los vehículos -->
        </select>

        <!-- Fecha de la reparación -->
        <input type="date" id="fechaReparacion" required>

        <!-- Descripción de la reparación -->
        <textarea id="descripcionReparacion" placeholder="Descripción" rows="4" required></textarea>

        <!-- Costo de la reparación -->
        <input type="number" step="0.01" id="costoReparacion" placeholder="Costo (€)" required>

        <!-- Botones de acción -->
        <button type="button" id="confirmarNuevaReparacion">Confirmar</button>
        <button type="button" id="cancelarNuevaReparacion" class="cancelarNuevaReparacion">Cancelar</button>
    </form>
</div>

<!-- Tabla para mostrar reparaciones existentes -->
<table id="tablaReparaciones">
    <thead>
    <tr>
        <th>ID</th>
        <th>Vehículo</th>
        <th>Fecha</th>
        <th>Descripción</th>
        <th>Coste (€)</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody id="reparaciones-list">

    </tbody>
</table>
