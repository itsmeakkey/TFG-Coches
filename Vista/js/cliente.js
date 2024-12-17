document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll('.navbar ul li a'); // barra navegación
    const contentDiv = document.getElementById('content'); // div

    links.forEach(link => {
        link.addEventListener('click', function (event) {
            const section = this.getAttribute('data-section');

            if (section === 'inicio') {
                location.reload();
            } else if (section === 'misReservas') {
                event.preventDefault();
                cargarReservas();
            } else if (section === 'seguros') {
                event.preventDefault();
                cargarSeguros();
            } else if (section === 'perfil') {
                event.preventDefault();
                cargarPerfil();
            } else if (section === 'comparar') {
                event.preventDefault();
                cargarComparacion();
            }else {
                event.preventDefault();
                // Otras secciones
                fetch(`../Vista/Secciones/Cliente/${section}.php`)
                    .then(response => response.text())
                    .then(data => {
                        contentDiv.innerHTML = data;
                    })
                    .catch(error => console.error('Error al cargar la sección:', error));
            }
        });
    });
});

//Cargar reservas
function cargarReservas() {
    fetch('../Controlador/controladorReservaA.php?obtenerReservas=1') // Usamos GET para obtener reservas
        .then(response => response.json())
        .then(data => {
            const contentDiv = document.getElementById('content');
            if (data.success) {
                let reservasHTML = '<h2>MIS RESERVAS</h2><table><tr><th>Fecha Inicio</th><th>Fecha Fin</th><th>Vehículo</th><th>Acciones</th></tr>';

                data.reservas.forEach(reserva => {
                    reservasHTML += `<tr>
                        <td>${reserva.fechaInicio}</td>
                        <td>${reserva.fechaFin}</td>
                        <td>${reserva.marca} ${reserva.modelo}</td>
                        <td><button class="cancelar-btn" onclick="cancelarReserva(${reserva.id})">Cancelar</button></td>
                    </tr>`;
                });

                reservasHTML += '</table>';
                contentDiv.innerHTML = reservasHTML;
            } else {
                contentDiv.innerHTML = '<p>No hay reservas existentes.</p>';
            }
        })
        .catch(error => console.error('Error al cargar las reservas:', error));
}

//Cargar seguros asociados a una reserva
function cargarSeguros() {
    // Hacemos fetch para obtener los seguros de todas las reservas del usuario
    fetch(`../Controlador/controladorSeguroA.php?accion=listarSegurosPorUsuario`)
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                const contentDiv = document.getElementById('content');
                if (data.success) {
                    let segurosHTML = '<h2>SEGUROS ASOCIADOS A MIS RESERVAS</h2>';

                    let reservaActual = null;
                    data.segurosPorReserva.forEach(seguro => {
                        // Si es una nueva reserva, mostrar encabezado
                        if (reservaActual !== seguro.reserva_id) {
                            reservaActual = seguro.reserva_id;
                            segurosHTML += `<h4>Reserva nº ${seguro.reserva_id} - Vehículo: ${seguro.marca} ${seguro.modelo}</h4>`;
                            segurosHTML += '<div class="seguros-grid">';
                        }

                        //Añado seguro al grid
                        segurosHTML += `
                            <div class="seguro-card">
                                <h3>${seguro.tipo === 'opcional' ? 'Seguro Opcional' : 'Seguro Obligatorio'}</h3>
                                <p><b>Cobertura:</b> ${seguro.cobertura}</p>
                                <p><b>Precio:</b> €${seguro.precio}</p>
                                <p><b>Descripción:</b> ${seguro.descripcion}</p>
                            </div>`;

                        // Cierro el grid de seguros si se termina de listar para una reserva
                        if (data.segurosPorReserva.indexOf(seguro) === data.segurosPorReserva.length - 1 || data.segurosPorReserva[data.segurosPorReserva.indexOf(seguro) + 1].reserva_id !== reservaActual) {
                            segurosHTML += '</div>';
                        }
                    });

                    contentDiv.innerHTML = segurosHTML; //Actualiza el contenido con los seguros
                } else {
                    contentDiv.innerHTML = '<p>No se encontraron seguros asociados a las reservas del usuario.</p>'; // Mensaje si no hay seguros
                }
            } catch (error) {
                console.error("Error al analizar JSON:", error); //Solo para depurar
            }
        })
        .catch(error => console.error('Error al cargar los seguros:', error));
}

//Función para cargar el perfil
function cargarPerfil() {
    fetch('../Controlador/controladorClienteA.php?accion=obtenerPerfil')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const perfilHTML = `
                    <h2>MI PERFIL</h2>
                    <div id="perfil" style="background-color: #f9f9f9">                    
                        <p><b>Nombre:</b> ${data.usuario.nombre}</p>
                        <p><b>Apellidos:</b> ${data.usuario.apellidos}</p>
                        <p><b>Correo:</b> ${data.usuario.correo}</p>
                        <p><b>Teléfono:</b> ${data.usuario.telefono}</p>
                        <p><b>Localidad:</b> ${data.usuario.localidad}</p>
                        <p><b>Provincia:</b> ${data.usuario.provincia}</p>
                        <p><b>CP:</b> ${data.usuario.cp}</p>
                        <button id="editarPerfil" onclick="mostrarFormularioEditar()">Editar</button>
                    </div>
                    <div id="formularioEditar" style="display:none;">
                    <form id="formEditarPerfil">
                        <!-- Campo oculto para la acción -->
                        <input type="hidden" name="accion" value="actualizarPerfil">
                
                        <div class="input-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="${data.usuario.nombre}">
                        </div>
                
                        <div class="input-group">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos" value="${data.usuario.apellidos}">
                        </div>
                
                        <div class="input-group">
                        <label for="correo">Correo:</label>
                        <input type="email" id="correo" name="correo" value="${data.usuario.correo}">
                        </div>
                        
                        <div class="input-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" value="${data.usuario.telefono}">
                        </div>
                        
                        <div class="input-group">
                        <label for="localidad">Localidad:</label>
                        <input type="text" id="localidad" name="localidad" value="${data.usuario.localidad}">
                        </div>
                
                        <div class="input-group">
                        <label for="provincia">Provincia:</label>
                        <input type="text" id="provincia" name="provincia" value="${data.usuario.provincia}">
                        </div>
                
                        <div class="input-group">
                        <label for="cp">CP:</label>
                        <input type="text" id="cp" name="cp" value="${data.usuario.cp}">
                        </div>
                
                        <div class="form-buttons">
                            <button type="submit">Guardar</button>
                            <button type="button" onclick="cancelarEdicion()">Cancelar</button>
                        </div>
                    </form>
                </div>

                `;
                document.getElementById('content').innerHTML = perfilHTML;
            } else {
                alert('Error al cargar el perfil.');
            }
        })
        .catch(error => console.error('Error al cargar el perfil:', error));
}



function mostrarFormularioEditar() {
    document.getElementById('perfil').style.display = 'none';
    document.getElementById('formularioEditar').style.display = 'block';
    document.getElementById('formEditarPerfil').addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch('../Controlador/controladorClienteA.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Perfil actualizado con éxito.');
                    cargarPerfil(); //carga el perfil actualizado
                } else {
                    alert('Error al actualizar el perfil.');
                }
            })
            .catch(error => console.error('Error al actualizar el perfil:', error));
    });
}

function cancelarEdicion() {
    document.getElementById('perfil').style.display = 'block';
    document.getElementById('formularioEditar').style.display = 'none';
}

//Cancelar reservas
function cancelarReserva(reservaId) {
    if (confirm("¿Estás seguro de que deseas cancelar esta reserva?")) {
        fetch('../Controlador/controladorReservaA.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `cancelarReserva=1&reserva_id=${reservaId}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Reserva cancelada con éxito.");
                    cargarReservas(); //Actualiza la lista de reservas
                } else {
                    alert("Error al cancelar la reserva.");
                }
            })
            .catch(error => console.error('Error al cancelar la reserva:', error));
    }
}

//Maneja la carga de vehículos al establecer las fechas
document.getElementById('reservaForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita el envío del formulario por defecto

    //Obtengo las fechas seleccionadas
    const fechaDesde = document.getElementById('fechaDesde').value;
    const fechaHasta = document.getElementById('fechaHasta').value;

    //Las valido
    if (new Date(fechaDesde) > new Date(fechaHasta)) {
        alert("La fecha de inicio no puede ser mayor que la fecha de fin.");
        return; //Detiene la ejecución si la validación falla
    }

    const formData = new FormData(this);

    fetch('../Controlador/controladorVehiculoA.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {

            return response.text();
        })
        .then(text => {
            try {
                const data = JSON.parse(text);

                if (data.success) {
                    document.getElementById('content').innerHTML = data.html;
                } else {
                    console.error(data.error);
                }
            } catch (error) {
                console.error("Error al analizar JSON:", error);
            }
        })
        .catch(error => console.error('Error de red:', error));
});


// Función para confirmar la reserva con la selección de seguros
function mostrarModalSeguros(vehiculoId, fechaInicio, fechaFin) {
    //Asigno los datos al modal
    document.getElementById('vehiculoId').value = vehiculoId;
    document.getElementById('fechaInicio').value = fechaInicio;
    document.getElementById('fechaFin').value = fechaFin;

    //Limpio el contenido previo
    document.getElementById('segurosObligatorios').innerHTML = '<h4>Seguros Obligatorios:</h4>';
    document.getElementById('segurosOpcionales').innerHTML = '<h4>Seguros Opcionales:</h4>';

    //Para almacenar el precio del vehículo y los seguros
    let precioDia = 0;
    let totalSeguros = 0;

    const obtenerPrecioVehiculo = fetch(`../Controlador/controladorVehiculoA.php?accion=obtenerPrecio&vehiculo_id=${vehiculoId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                precioDia = parseFloat(data.precioDia);
            } else {
                throw new Error('Error al obtener el precio del vehículo.');
            }
        });

    const obtenerSeguros = fetch('../Controlador/controladorSeguro.php?accion=listar')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const segurosObligatoriosDiv = document.getElementById('segurosObligatorios');
                const segurosOpcionalesDiv = document.getElementById('segurosOpcionales');

                data.seguros.forEach(seguro => {
                    const label = document.createElement('label');
                    label.innerHTML = `
                        <input type="checkbox" name="seguros" value="${seguro.id}" data-precio="${seguro.precio}" ${seguro.tipo === 'obligatorio' ? 'checked disabled' : ''} onchange="calcularMontoTotal(${precioDia}, '${fechaInicio}', '${fechaFin}', ${totalSeguros})">
                        ${seguro.cobertura} (€${seguro.precio})<br>
                    `;

                    if (seguro.tipo === 'obligatorio') {
                        totalSeguros += parseFloat(seguro.precio);
                        segurosObligatoriosDiv.appendChild(label);
                    } else {
                        segurosOpcionalesDiv.appendChild(label);
                    }
                });
            } else {
                throw new Error('No se encontraron seguros.');
            }
        });

    //Ejecuta ambas solicitudes en paralelo y muestra el modal después
    Promise.all([obtenerPrecioVehiculo, obtenerSeguros])
        .then(() => {
            //Calculo del monto total inicial
            calcularMontoTotal(precioDia, fechaInicio, fechaFin, totalSeguros);

            //Muestra el modal solo después de cargar los seguros y el precio
            document.getElementById('modalSeguros').style.display = 'block';
        })
        .catch(error => console.error(error.message));
}

// Función para calcular el monto total del alquiler
function calcularMontoTotal(precioDia, fechaInicio, fechaFin, totalSeguros) {
    //Calculo los días de alquiler quitando la fecha final
    const diasAlquiler = (new Date(fechaFin) - new Date(fechaInicio)) / (1000 * 60 * 60 * 24);

    if (diasAlquiler <= 0) {
        alert("La fecha de inicio debe ser anterior a la fecha de fin.");
        return;
    }

    //Sumo el precio de cada seguro opcional seleccionado al total
    document.querySelectorAll('#segurosOpcionales input[type="checkbox"]:checked').forEach(checkbox => {
        const precioSeguro = parseFloat(checkbox.getAttribute('data-precio'));
        if (!isNaN(precioSeguro)) {
            totalSeguros += precioSeguro;
        }
    });

    //Calculo el monto total sumando seguros y el precio del vehículo por los días
    let montoTotal = diasAlquiler * precioDia + totalSeguros;
    document.getElementById('montoTotal').textContent = montoTotal.toFixed(2);
    return montoTotal;
}

function cerrarModalSeguros() {
    //Oculta el modal
    document.getElementById('modalSeguros').style.display = 'none';
}

function confirmarReservaConSeguros() {
    const vehiculoId = document.getElementById('vehiculoId').value;
    const fechaInicio = document.getElementById('fechaInicio').value;
    const fechaFin = document.getElementById('fechaFin').value;
    const metodoPago = document.getElementById('metodoPago').value;
    const montoTotal = document.getElementById('montoTotal').textContent;

    const seguros = Array.from(document.querySelectorAll('#formSeguros input[name="seguros"]:checked')).map(input => input.value);

    const formData = new FormData();
    formData.append('vehiculo_id', vehiculoId);
    formData.append('fechaInicio', fechaInicio);
    formData.append('fechaFin', fechaFin);
    formData.append('metodoPago', metodoPago);
    formData.append('montoTotal', montoTotal);

    seguros.forEach(seguro => {
        formData.append('seguros[]', seguro);
    });

    fetch('../Controlador/controladorReservaA.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(text => {
            console.log("Respuesta en crudo:", text);
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    alert(data.message || 'Reserva confirmada con éxito.');
                    cerrarModalSeguros();
                    document.getElementById(`car-${vehiculoId}`).remove();
                } else {
                    alert(data.error || 'Error al confirmar la reserva.');
                }
            } catch (error) {
                console.error("Error al analizar JSON:", error);
            }
        })
        .catch(error => console.error('Error en la red:', error));
}

/* COMPARAR */
// Función para cargar marcas iniciales
function cargarMarcas() {
    fetch('../Controlador/controladorVehiculoA.php?accion=obtenerMarcas')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const marcaSelect = document.getElementById('marca');
                data.marcas.forEach(marca => {
                    const option = document.createElement('option');
                    option.value = marca;
                    option.textContent = marca;
                    marcaSelect.appendChild(option);
                });

                //Evento para cargar modelos al cambiar la marca
                marcaSelect.addEventListener('change', actualizarOpcionesModeloYCombustible);
            } else {
                console.error('Error al obtener marcas:', data.error);
            }
        })
        .catch(error => console.error('Error al cargar marcas:', error));
}

// Función para cargar modelos y combustibles según la marca seleccionada
function actualizarOpcionesModeloYCombustible() {
    const marcaSeleccionada = document.getElementById('marca').value;

    fetch(`../Controlador/controladorVehiculoA.php?accion=obtenerModelosYCombustibles&marca=${marcaSeleccionada}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modeloSelect = document.getElementById('modelo');
                const combustibleSelect = document.getElementById('combustible');

                //Limpia opciones previas
                modeloSelect.innerHTML = '<option value="">Todos los modelos</option>';
                combustibleSelect.innerHTML = '<option value="">Todos los combustibles</option>';

                data.modelos.forEach(modelo => {
                    const option = document.createElement('option');
                    option.value = modelo;
                    option.textContent = modelo;
                    modeloSelect.appendChild(option);
                });

                data.combustibles.forEach(combustible => {
                    const option = document.createElement('option');
                    option.value = combustible;
                    option.textContent = combustible;
                    combustibleSelect.appendChild(option);
                });
            } else {
                console.error('Error al obtener modelos y combustibles:', data.error);
            }
        })
        .catch(error => console.error('Error al cargar modelos y combustibles:', error));
}

//Llama a cargarMarcas al cargar la sección de comparación
function cargarComparacion() {
    fetch('../Vista/Secciones/Cliente/comparar.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('content').innerHTML = data;
        })
        .then(() => {
            cargarMarcas();
            document.getElementById('filtroVehiculos').addEventListener('submit', filtrarVehiculos);
        })
        .catch(error => console.error('Error al cargar la sección de comparación:', error));
}

//Manejo del formulario de filtros
function filtrarVehiculos(event) {
    event.preventDefault();
    console.log("Filtrando vehículos...");

    const formData = new FormData(document.getElementById('filtroVehiculos'));
    formData.append('accion', 'filtrarVehiculos');
    fetch('../Controlador/controladorVehiculoA.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(text => {
            console.log("Respuesta en crudo:", text);

            try {
                const data = JSON.parse(text);

                if (data.success) {
                    const resultadosDiv = document.getElementById('resultadosVehiculos');
                    resultadosDiv.innerHTML = '';
                    data.vehiculos.forEach(vehiculo => {
                        const vehiculoDiv = document.createElement('div');
                        vehiculoDiv.className = 'vehiculo';
                        vehiculoDiv.id = `car-${vehiculo.id}`; // Añade el ID del contenedor
                        vehiculoDiv.innerHTML = `
                        <h3>${vehiculo.marca} ${vehiculo.modelo}</h3>
                        <p>Combustible: ${vehiculo.combustible}</p>
                        <p>Precio por día: ${vehiculo.precioDia}€</p>
                        <img class="car-image" src="${vehiculo.imagen}" /><br><br>
                        <button class="seleccionar-btn" onclick="seleccionarVehiculo(${vehiculo.id})">Seleccionar</button>
                    `;
                        resultadosDiv.appendChild(vehiculoDiv);
                    });
                } else {
                    console.error('Error en la respuesta:', data.error);
                }
            } catch (error) {
                console.error("Error al analizar JSON:", error);
            }
        })
        .catch(error => console.error('Error al filtrar los vehículos:', error));
}

//Array para almacenar los vehículos seleccionados
let vehiculosSeleccionados = [];

function seleccionarVehiculo(id) {
    const boton = document.querySelector(`#car-${id} .seleccionar-btn`);

    if (vehiculosSeleccionados.includes(id)) {
        //Deseleccionar el vehículo
        vehiculosSeleccionados = vehiculosSeleccionados.filter(vehiculoId => vehiculoId !== id);
        boton.textContent = "Seleccionar";
        boton.classList.remove("seleccionado"); // Remover el estilo de selección
    } else if (vehiculosSeleccionados.length < 2) {
        //Seleccionar el vehículo
        vehiculosSeleccionados.push(id);
        boton.textContent = "Seleccionado";
        boton.classList.add("seleccionado");
    }
    actualizarEstadoSeleccion();

    //Si ya hay dos vehículos seleccionados, se comparan
    if (vehiculosSeleccionados.length === 2) {
        compararVehiculos();
    } else {
        document.getElementById('comparacionVehiculos').style.display = 'none';
    }
}

//Función para actualizar el mensaje de estado de selección
function actualizarEstadoSeleccion() {
    const mensajeSeleccion = document.getElementById("mensajeSeleccion") || document.createElement("p");
    mensajeSeleccion.id = "mensajeSeleccion";
    //mensajeSeleccion.textContent = `Vehículos seleccionados: ${vehiculosSeleccionados.length}/2`;
    document.getElementById("resultadosVehiculos").appendChild(mensajeSeleccion);
}

//Función para comparar los vehículos seleccionados
function compararVehiculos() {
    const [id1, id2] = vehiculosSeleccionados;

    fetch(`../Controlador/controladorVehiculoA.php?accion=comparar&id1=${id1}&id2=${id2}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                //Oculta los vehículos
                document.getElementById('resultadosVehiculos').style.display = 'none';

                //tabla de comparación
                const comparacionDiv = document.getElementById('comparacionVehiculos');
                comparacionDiv.style.display = 'block';
                comparacionDiv.innerHTML = `<hr><br>
                    <table>
                        <tr>
                            <th>Característica</th>
                            <th>${data.vehiculo1.marca} ${data.vehiculo1.modelo}</th>
                            <th>${data.vehiculo2.marca} ${data.vehiculo2.modelo}</th>
                        </tr>
                        <tr>
                            <td><b>Precio por día</b></td>
                            <td>€${data.vehiculo1.precioDia}</td>
                            <td>€${data.vehiculo2.precioDia}</td>
                        </tr>
                        <tr>
                            <td><b>Matrícula</b></td>
                            <td>${data.vehiculo1.matricula}</td>
                            <td>${data.vehiculo2.matricula}</td>
                        </tr>
                        <tr>
                            <td><b>Plazas</b></td>
                            <td>${data.vehiculo1.plazas}</td>
                            <td>${data.vehiculo2.plazas}</td>
                        </tr>
                        <tr>
                            <td><b>Combustible</b></td>
                            <td>${data.vehiculo1.combustible}</td>
                            <td>${data.vehiculo2.combustible}</td>
                        </tr>
                        <tr>
                            <td><b>Estado</b></td>
                            <td>${data.vehiculo1.estado}</td>
                            <td>${data.vehiculo2.estado}</td>
                        </tr>
                    </table>
                    <button class="boton-volver" onclick="volverASeleccionar()">↩</button>
                `;
            } else {
                console.error('Error en la comparación:', data.error);
            }
        })
        .catch(error => console.error('Error al comparar los vehículos:', error));
}

//volver a la vista de selección
function volverASeleccionar() {
    //Muestro los vehículos y oculto la tabla de comparación
    document.getElementById('resultadosVehiculos').style.display = 'flex';
    document.getElementById('comparacionVehiculos').style.display = 'none';

    //Reinicio la selección de vehículos
    vehiculosSeleccionados = [];
    document.querySelectorAll('.seleccionar-btn').forEach(boton => {
        boton.textContent = "Seleccionar";
        boton.classList.remove("seleccionado");
    });
}





