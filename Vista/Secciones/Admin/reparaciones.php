<h2>Gestionar Reparaciones</h2>
<p>Aquí puedes ver y gestionar las reparaciones de los vehículos</p><br>
<button class="crear" id="nuevaReparacionButton">Nueva Reparación</button>
<div id="nuevaReparacionModal" style="display: none;">
    <h2>Agregar Nueva Reparación</h2>
    <form id="formNuevaReparacion">
        <select id="vehiculo" required>
            <option value="" disabled selected>Seleccione un vehículo</option>
        </select>

        <input type="date" id="fechaReparacion" required>
        <textarea id="descripcionReparacion" placeholder="Descripción" rows="4" required></textarea>
        <input type="number" id="costoReparacion" placeholder="Costo (€)" required>

        <button type="button" id="confirmarNuevaReparacion">Confirmar</button>
        <button type="button" id="cancelarNuevaReparacion" class="cancelarNuevaReparacion">Cancelar</button>
    </form>
</div>

<table id="tablaReparaciones">
    <thead>
    <tr>
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
