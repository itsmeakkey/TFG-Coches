<!-- comparar.php -->
<h2>COMPARACIÓN DE VEHÍCULOS</h2>
<div id="comparar-section">
    <!-- Formulario para Filtros de Vehículos -->
    <form id="filtroVehiculos">
        <label for="marca">Marca:</label>
        <select id="marca" name="marca">
            <option value="">Todas las marcas</option>
            <!-- Opciones dinámicas -->
        </select>

        <label for="modelo">Modelo:</label>
        <select id="modelo" name="modelo">
            <option value="">Todos los modelos</option>
            <!-- Opciones dinámicas -->
        </select>

        <label for="combustible">Combustible:</label>
        <select id="combustible" name="combustible">
            <option value="">Todos los combustibles</option>
            <!-- Opciones dinámicas -->
        </select>

        <label for="precioMin">Precio mínimo:</label>
        <input type="number" id="precioMin" name="precioMin" placeholder="Precio día mínimo">

        <label for="precioMax">Precio máximo:</label>
        <input type="number" id="precioMax" name="precioMax" placeholder="Precio día máximo">




        <button type="submit">Aplicar Filtros</button>
    </form>


    <!-- Área de resultados -->
    <div id="resultadosVehiculos">

    </div>

    <!-- Área de comparación -->
    <div id="comparacionVehiculos" style="display:none;">
    </div>
</div>
