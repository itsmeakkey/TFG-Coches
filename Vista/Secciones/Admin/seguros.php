<!-- ../Vista/Secciones/Admin/seguros.php -->
<h2>Gestionar Seguros</h2>
<p>Aquí puedes añadir, actualizar o eliminar seguros.</p><br>

<!-- Modal para agregar nuevo seguro -->
<button class="crear" id="nuevoSeguroButton">Nuevo seguro</button>
<div id="nuevoSeguroModal" style="display: none;">
    <h2>Agregar Nuevo Seguro</h2>
    <form id="formNuevoSeguro">
        <select id="tipo" required>
            <option value="" disabled selected>Seleccione tipo</option>
            <option value="obligatorio">Obligatorio</option>
            <option value="opcional">Opcional</option>
        </select>

        <input type="text" id="cobertura" placeholder="Cobertura" required>

        <input type="number" step="0.01" id="precio" placeholder="Precio" required>

        <textarea id="descripcion" placeholder="Descripción" rows="4"></textarea>

        <button type="button" id="confirmarNuevoSeguro">Confirmar</button>
        <button type="button" id="cancelarNuevoSeguro" class="cancelarNuevoSeguro">Cancelar</button>
    </form>
</div>

<!-- Tabla para listar los seguros -->
<table>
    <thead>
    <tr>
        <th>Tipo</th>
        <th>Cobertura</th>
        <th>Precio</th>
        <th>Descripción</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody id="seguros-list">
    <!-- Aquí se cargarán los seguros -->
    </tbody>
</table>
