<!-- comparar.php -->
<h2>COMPARACIÓN DE VEHÍCULOS</h2>
<div id="comparar-section">
    <!-- Formulario para Filtros de Vehículos -->
    <form id="filtroVehiculos">
        <label for="marca">Marca:</label>
        <select name="marca" id="marca">
            <option value="">Todas</option>

        </select>

        <label for="modelo">Modelo:</label>
        <select name="modelo" id="modelo">
            <option value="">Todos</option>
        </select>

        <label for="combustible">Combustible:</label>
        <select name="combustible" id="combustible">
            <option value="">Todos</option>
        </select>

        <label for="precioMin">Precio mínimo:</label>
        <input type="number" name="precioMin" id="precioMin" placeholder="Precio mínimo por día">

        <label for="precioMax">Precio máximo:</label>
        <input type="number" name="precioMax" id="precioMax" placeholder="Precio máximo por día">



        <button type="submit">Aplicar Filtros</button>
    </form>


    <!-- Área de resultados -->
    <div id="resultadosVehiculos">

    </div>

    <!-- Área de comparación -->
    <div id="comparacionVehiculos" style="display:none;">
    </div>
</div>
