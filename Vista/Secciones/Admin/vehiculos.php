<h2>Gestionar Vehículos</h2>
<p>Aquí puedes añadir, actualizar o eliminar vehículos.</p><br>

<button class="crear" id="nuevoVehiculoButton">Nuevo vehículo</button>
<div id="nuevaReparacionModal" style="display: none;">
    <h2>Agregar Nuevo Vehículo</h2>
    <form id="formNuevoVehiculo">
        <input type="text" id="marca" placeholder="Marca" required>

        <input type="text" id="modelo" placeholder="Modelo" required>

        <input type="text" id="matricula" placeholder="Matrícula" required>

        <input type="number" id="plazas" placeholder="Plazas" required>

        <select id="combustible" required>
            <option value="" disabled selected>Combustible</option>
            <option value="Gasolina">Gasolina</option>
            <option value="Diésel">Diésel</option>
            <option value="Eléctrico">Eléctrico</option>
            <option value="Híbrido">Híbrido</option>
        </select>

        <input type="number" id="precioDia" placeholder="Precio por Día" required>

        <input type="date" id="fechaMatriculacion" placeholder="Fecha de Matriculación" required>

        <input type="text" id="estado" value="Disponible" placeholder="Estado" readonly>

        <input type="file" id="imagen" accept="image/png, image/jpeg" required><br>

        <button type="button" id="confirmarNuevoVehiculo">Confirmar</button>
        <button type="button" id="cancelarNuevoVehiculo" class="cancelarNuevoVehiculo">Cancelar</button>
    </form>
</div>


<!-- Tabla donde se muestran los vehículos existentes -->
<table>
    <thead>
    <tr>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Matricula</th>
        <th>Plazas</th>
        <th>Combustible</th>
        <th>Precio por día</th>
        <th>Estado</th>
        <th>Imagen</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody id="vehiculos-list">
    </tbody>
</table>


