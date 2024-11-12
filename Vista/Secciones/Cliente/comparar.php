<!-- comparar.php -->
<h2>COMPARACIÓN DE VEHÍCULOS</h2>
<div id="comparar-section">
    <!-- Formulario para Filtros de Vehículos -->
    <form id="filtroVehiculos">
        <label for="marca">Marca:</label>
        <input type="text" name="marca" id="marca" placeholder="Marca del vehículo">

        <label for="modelo">Modelo:</label>
        <input type="text" name="modelo" id="modelo" placeholder="Modelo del vehículo">

        <label for="precioMin">Precio mínimo:</label>
        <input type="number" name="precioMin" id="precioMin" placeholder="Precio mínimo por día">

        <label for="precioMax">Precio máximo:</label>
        <input type="number" name="precioMax" id="precioMax" placeholder="Precio máximo por día">

        <button type="submit">Aplicar Filtros</button>
    </form>

    <!-- Área para Mostrar los Resultados -->
    <div id="resultadosVehiculos">
        <!-- Aquí se mostrarán los vehículos que cumplen con los filtros -->
    </div>

    <!-- Área para Mostrar la Comparación de los Vehículos -->
    <div id="comparacionVehiculos" style="display:none;">
        <!-- Aquí se mostrará la tabla de comparación cuando se seleccionen dos vehículos -->
    </div>
</div>
