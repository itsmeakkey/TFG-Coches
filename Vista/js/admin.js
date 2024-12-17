document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll('.navbar ul li a'); // barra nav
    const contentDiv = document.getElementById('content'); // div

    links.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const section = this.getAttribute('data-section');

            // Realizar la petición AJAX para cargar la sección
            fetch(`../Vista/Secciones/Admin/${section}.php`)
                .then(response => response.text())
                .then(data => {
                    contentDiv.innerHTML = data;

                    if (section === 'clientes') {
                        cargarClientes();
                    } else if (section === 'vehiculos') {
                        cargarVehiculos();
                    } else if (section === 'seguros') {
                        cargarSeguros();
                    } else if (section === 'reservas') {
                        cargarReservas();
                    } else if (section === 'pagos') {
                        cargarPagos();
                    } else if (section === 'reparaciones') {
                        cargarReparaciones();
                    }
                })
                .catch(error => console.error('Error al cargar la sección:', error));
        });
    });

// SECCIÓN CLIENTES
// Función para cargar los clientes
    function cargarClientes() {
        fetch('../Controlador/controladorCliente.php?accion=listar')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la red');
                }
                return response.json();
            })
            .then(usuarios => {
                const tbody = document.getElementById('clientes-list');
                tbody.innerHTML = '';

                // Verificar si hay usuarios
                if (usuarios.length === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td colspan="11" style="text-align: center;">No hay usuarios verificados.</td>`;
                    tbody.appendChild(row);
                } else {
                    // Si hay usuarios, crear las filas
                    usuarios.forEach(usuario => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td><input type="text" value="${usuario.dni}" data-campo="dni"></td>
                    <td><input type="text" value="${usuario.apellidos}" data-campo="apellidos"></td>
                    <td><input type="text" value="${usuario.nombre}" data-campo="nombre"></td>
                    <td><input type="date" value="${usuario.fechaNacimiento}" data-campo="fechaNacimiento"></td>
                    <td><input type="text" value="${usuario.telefono}" data-campo="telefono"></td>
                    <td><input type="email" value="${usuario.correo}" data-campo="correo"></td>
                    <td><input type="text" value="${usuario.localidad}" data-campo="localidad"></td>
                    <td><input type="text" value="${usuario.provincia}" data-campo="provincia"></td>
                    <td><input type="text" value="${usuario.cp}" data-campo="cp"></td>
                    <td>
                        <button onclick="guardarCambios('${usuario.id}', this)">Actualizar</button>
                        <button class="eliminar" onclick="eliminarCliente(${usuario.id}, this)">Eliminar</button>
                            
                    </td>
                `;
                        tbody.appendChild(row);
                    });
                }
            })
            .catch(error => console.error('Error al cargar los clientes:', error));
    }

//SECCIÓN VEHÍCULOS
    // Función para cargar los vehículos
    function cargarVehiculos() {
        fetch('../Controlador/controladorVehiculo.php?accion=listar')
            .then(response => response.json())
            .then(vehiculos => {
                const tbody = document.getElementById('vehiculos-list');
                tbody.innerHTML = '';

                vehiculos.forEach(vehiculo => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                <td><input type="text" value="${vehiculo.marca}" data-campo="marca"></td>
                <td><input type="text" value="${vehiculo.modelo}" data-campo="modelo"></td>
                <td><input type="text" value="${vehiculo.matricula}" data-campo="matricula"></td>
                <td><input type="number" value="${vehiculo.plazas}" data-campo="plazas"></td>
                <td><input type="text" value="${vehiculo.combustible}" data-campo="combustible"></td>
                <td><input type="number" value="${vehiculo.precioDia}" data-campo="precioDia"></td>
                <td><input type="text" value="${vehiculo.estado}" data-campo="estado"></td>
                <td><img src="${vehiculo.imagen}" alt="Imagen del vehículo" style="width: 100px; height: auto;"></td>
                <td>
                    <button onclick="guardarCambiosVehiculo(${vehiculo.id}, this)">Actualizar</button>
                    <button class="eliminar" onclick="eliminarVehiculo(${vehiculo.id}, this)">Eliminar</button>
                </td>
            `;
                    tbody.appendChild(row);
                });

                // Event listener para mostrar el modal al hacer clic en "Nuevo vehículo"
                document.getElementById('nuevoVehiculoButton').addEventListener('click', function () {
                    document.getElementById('nuevaReparacionModal').style.display = 'block'; // Muestra el modal
                });

                // Confirmar la creación del nuevo vehículo
                document.getElementById('confirmarNuevoVehiculo').addEventListener('click', function () {
                    const marca = document.getElementById('marca').value;
                    const modelo = document.getElementById('modelo').value;
                    const matricula = document.getElementById('matricula').value;
                    const plazas = document.getElementById('plazas').value;
                    const combustible = document.getElementById('combustible').value;
                    const precioDia = document.getElementById('precioDia').value;
                    const fechaMatriculacion = document.getElementById('fechaMatriculacion').value;
                    const estado = document.getElementById('estado').value;

                    // Obtener la imagen seleccionada
                    const imagen = document.getElementById('imagen').files[0];

                    // Creamos un FormData para enviar tanto los datos del vehículo como la imagen
                    const formData = new FormData();
                    formData.append('accion', 'agregar');
                    formData.append('marca', marca);
                    formData.append('modelo', modelo);
                    formData.append('matricula', matricula);
                    formData.append('plazas', plazas);
                    formData.append('combustible', combustible);
                    formData.append('precioDia', precioDia);
                    formData.append('fechaMatriculacion', fechaMatriculacion);
                    formData.append('estado', estado);
                    formData.append('imagen', imagen); // Aquí se añade la imagen al FormData

                    // Realiza la petición AJAX para agregar el nuevo vehículo con la imagen
                    fetch('../Controlador/controladorVehiculo.php', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(resultado => {
                            if (resultado.success) {
                                alert('Vehículo agregado con éxito');
                                agregarFilaVehiculo(resultado.vehiculo); // Solo agregamos la nueva fila
                                limpiarFormulario(); // Limpiar el formulario después de agregar
                                document.getElementById('nuevaReparacionModal').style.display = 'none'; // Cierra el modal
                            } else {
                                alert('Error al agregar el vehículo: ' + (resultado.error || 'Error desconocido'));
                            }
                        })
                        .catch(error => console.error('Error al agregar el vehículo:', error));
                });


                // Cancelar la creación del nuevo vehículo
                document.getElementById('cancelarNuevoVehiculo').addEventListener('click', function () {
                    document.getElementById('nuevaReparacionModal').style.display = 'none'; // Cierra el modal
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // Función para limpiar el formulario después de agregar un vehículo
    function limpiarFormulario() {
        document.getElementById('formNuevoVehiculo').reset(); // Resetea todos los campos del formulario
    }

    // Función para agregar la nueva fila del vehículo sin recargar toda la tabla
    function agregarFilaVehiculo(vehiculo) {
        const tbody = document.getElementById('vehiculos-list');
        const row = document.createElement('tr');
        row.innerHTML = `
        <td><input type="text" value="${vehiculo.marca}" data-campo="marca"></td>
        <td><input type="text" value="${vehiculo.modelo}" data-campo="modelo"></td>
        <td><input type="text" value="${vehiculo.matricula}" data-campo="matricula"></td>
        <td><input type="number" value="${vehiculo.plazas}" data-campo="plazas"></td>
        <td><input type="text" value="${vehiculo.combustible}" data-campo="combustible"></td>
        <td><input type="number" value="${vehiculo.precioDia}" data-campo="precioDia"></td>
        <td><input type="text" value="${vehiculo.estado}" data-campo="estado"></td>
        <td><img src="${vehiculo.imagen}" alt="Imagen del vehículo" style="width: 100px; height: auto;"></td>
        <td>
            <button onclick="guardarCambiosVehiculo(${vehiculo.id}, this)">Actualizar</button>
            <button class="eliminar" onclick="eliminarVehiculo(${vehiculo.id}, this)">Eliminar</button>
        </td>
    `;
        tbody.appendChild(row);
    }

    //SECCIÓN REPARACIONES
    function cargarReparaciones() {
        fetch('../Controlador/controladorReparacion.php?accion=listar')

            .then(response => response.json())
            .then(data => {
                console.log('Respuesta JSON en crudo:', data); // Imprime la respuesta JSON directamente en crudo
                const tbody = document.getElementById('reparaciones-list');
                tbody.innerHTML = '';

                if (data.success && data.reparaciones.length > 0) {
                    data.reparaciones.forEach(reparacion => {
                        agregarFilaReparacion(reparacion);
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">No hay reparaciones disponibles.</td></tr>';
                }

                // Event listener para abrir el modal
                document.getElementById('nuevaReparacionButton').addEventListener('click', function () {
                    cargarVehiculosSelect();
                    document.getElementById('nuevaReparacionModal').style.display = 'block';
                });

                // Confirmar nueva reparación
                document.getElementById('confirmarNuevaReparacion').addEventListener('click', function () {
                    const vehiculoId = document.getElementById('vehiculo').value;
                    const fechaReparacion = document.getElementById('fechaReparacion').value;
                    const descripcion = document.getElementById('descripcionReparacion').value;
                    const costo = document.getElementById('costoReparacion').value;

                    if (!vehiculoId || !fechaReparacion || !descripcion || !costo) {
                        alert('Por favor, complete todos los campos.');
                        return;
                    }

                    // Crear FormData para enviar los datos
                    const formData = new FormData();
                    formData.append('accion', 'agregar');
                    formData.append('vehiculo_id', vehiculoId);
                    formData.append('fecha', fechaReparacion);
                    formData.append('descripcion', descripcion);
                    formData.append('costo', costo);

                    fetch('../Controlador/controladorReparacion.php', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(resultado => {
                            console.log ('En crudo: ', resultado);
                            if (resultado.success) {
                                alert('Reparación agregada con éxito.');
                                agregarFilaReparacion(resultado.reparacion);
                                limpiarFormularioReparacion();
                                document.getElementById('nuevaReparacionModal').style.display = 'none';
                            } else {
                                alert('Error al agregar reparación: ' + (resultado.error || 'Error desconocido'));
                            }
                        })
                        .catch(error => console.error('Error al agregar reparación:', error));
                });

                // Cancelar la creación de una nueva reparación
                document.getElementById('cancelarNuevaReparacion').addEventListener('click', function () {
                    document.getElementById('nuevaReparacionModal').style.display = 'none';
                });
            })
            .catch(error => console.error('Error al cargar las reparaciones:', error));
    }

// Función para agregar una nueva fila de reparación sin recargar la tabla
    function agregarFilaReparacion(reparacion) {
        const tbody = document.getElementById('reparaciones-list');
        const row = document.createElement('tr');
        row.innerHTML = `
        <td><span class="readonly-field">${reparacion.marcaVehiculo} ${reparacion.modeloVehiculo}<span/></td>
        <td><input type="date" value="${reparacion.fecha}" data-campo="fecha"></td>
        <td><input type="text" value="${reparacion.descripcion}" data-campo="descripcion"></td>
        <td><input type="number" value="${reparacion.costo}" data-campo="costo"></td>

        <td>
            <button onclick="actualizarReparacion(${reparacion.id}, this)">Actualizar</button>
            <button class="eliminar" onclick="eliminarReparacion(${reparacion.id}, this)">Eliminar</button>
        </td>
    `;
        tbody.appendChild(row);
    }

// Función para limpiar el formulario después de agregar una reparación
    function limpiarFormularioReparacion() {
        document.getElementById('formNuevaReparacion').reset();
    }

// Cargar vehículos en el select
    function cargarVehiculosSelect() {
        fetch('../Controlador/controladorVehiculo.php?accion=listar')
            .then(response => response.json())
            .then(vehiculos => {
                const selectVehiculo = document.getElementById('vehiculo');
                selectVehiculo.innerHTML = '<option value="" disabled selected>Seleccione un vehículo</option>'; // Default

                vehiculos.forEach(vehiculo => {
                    const option = document.createElement('option');
                    option.value = vehiculo.id;
                    option.textContent = `${vehiculo.marca} ${vehiculo.modelo} (${vehiculo.matricula})`;
                    selectVehiculo.appendChild(option);
                });
            })
            .catch(error => console.error('Error al cargar vehículos:', error));
    }


    //SECCIÓN SEGUROS
    function cargarSeguros() {
        fetch('../Controlador/controladorSeguro.php?accion=listar')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la red');
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    throw new Error(data.error || 'Error al cargar los seguros');
                }
                const seguros = data.seguros;
                const tbody = document.getElementById('seguros-list');
                tbody.innerHTML = ''; // Limpiar contenido anterior

                if (seguros.length === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td colspan="5" style="text-align: center;">No hay seguros disponibles.</td>`;
                    tbody.appendChild(row);
                } else {
                    seguros.forEach(seguro => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>
                            <select data-campo="tipo">
                                <option value="obligatorio" ${seguro.tipo === 'obligatorio' ? 'selected' : ''}>Obligatorio</option>
                                <option value="opcional" ${seguro.tipo === 'opcional' ? 'selected' : ''}>Opcional</option>
                            </select>
                        </td>
                        <td><input type="text" value="${seguro.cobertura}" data-campo="cobertura"></td>
                        <td><input type="number" value="${seguro.precio}" data-campo="precio"></td>
                        <td><input type="text" value="${seguro.descripcion}" data-campo="descripcion"></td>
                        <td>
                            <button onclick="guardarCambiosSeguro(${seguro.id}, this)">Actualizar</button>
                            <button class="eliminar" onclick="eliminarSeguro(${seguro.id}, this)">Eliminar</button>
                        </td>
                    `;
                        tbody.appendChild(row);
                    });
                }

                // Evento para mostrar el modal de creación de un nuevo seguro
                document.getElementById('nuevoSeguroButton').addEventListener('click', () => {
                    document.getElementById('nuevoSeguroModal').style.display = 'block';
                });

                // Confirmar la creación del nuevo seguro
                document.getElementById('confirmarNuevoSeguro').addEventListener('click', () => {
                    const tipo = document.getElementById('tipo').value;
                    const cobertura = document.getElementById('cobertura').value;
                    const precio = document.getElementById('precio').value;
                    const descripcion = document.getElementById('descripcion').value;

                    // Petición para agregar el nuevo seguro
                    fetch('../Controlador/controladorSeguro.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            accion: 'agregar',
                            tipo: tipo,
                            cobertura: cobertura,
                            precio: precio,
                            descripcion: descripcion
                        })
                    })
                        .then(response => response.json())
                        .then(resultado => {
                            if (resultado.success) {
                                alert('Seguro agregado con éxito');
                                agregarFilaSeguro(resultado.seguro);
                                limpiarFormularioSeguro(); // Limpiar formulario tras agregar
                                document.getElementById('nuevoSeguroModal').style.display = 'none';
                            } else {
                                alert('Error al agregar el seguro: ' + (resultado.error || 'Error desconocido'));
                            }
                        })
                        .catch(error => console.error('Error al agregar el seguro:', error));
                });

                // Cancelar la creación del nuevo seguro
                document.getElementById('cancelarNuevoSeguro').addEventListener('click', () => {
                    document.getElementById('nuevoSeguroModal').style.display = 'none';
                });
            })
            .catch(error => console.error('Error al cargar los seguros:', error));
    }


// Función para agregar la nueva fila del seguro sin recargar toda la tabla
    function agregarFilaSeguro(seguro) {
        const tbody = document.getElementById('seguros-list');
        const row = document.createElement('tr');
        row.innerHTML = `
        <td>
            <select data-campo="tipo">
                <option value="obligatorio" ${seguro.tipo === 'obligatorio' ? 'selected' : ''}>Obligatorio</option>
                <option value="opcional" ${seguro.tipo === 'opcional' ? 'selected' : ''}>Opcional</option>
            </select>
        </td>
        <td><input type="text" value="${seguro.cobertura}" data-campo="cobertura"></td>
        <td><input type="number" value="${seguro.precio}" data-campo="precio"></td>
        <td><input type="text" value="${seguro.descripcion}" data-campo="descripcion"></td>
        <td>
            <button onclick="guardarCambiosSeguro(${seguro.id}, this)">Actualizar</button>
            <button class="eliminar" onclick="eliminarSeguro(${seguro.id}, this)">Eliminar</button>
        </td>
    `;
        tbody.appendChild(row);
    }

// Función para limpiar el formulario después de agregar un seguro
    function limpiarFormularioSeguro() {
        document.getElementById('formNuevoSeguro').reset(); // Resetea todos los campos del formulario
    }

    //SECCIÓN RESERVAS
    // Función para cargar las reservas
    function cargarReservas() {
        fetch('../Controlador/controladorReserva.php?accion=listar')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la red');
                }
                return response.json();
            })
            .then(reservas => {
                const tbody = document.getElementById('reservas-list');
                tbody.innerHTML = '';

                if (reservas.length === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td colspan="5" style="text-align: center;">No hay reservas disponibles.</td>`;
                    tbody.appendChild(row);
                } else {
                    reservas.forEach(reserva => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td><span class="readonly-field">${reserva.id}</span></td>
                        <td><span class="readonly-field">${reserva.nombreUsuario} ${reserva.apellidosUsuario}</span></td>
                        <td><span class="readonly-field">${reserva.marcaVehiculo} ${reserva.modeloVehiculo}</span></td>       
                        <td><input type="date" value="${new Date(reserva.fechaInicio).toISOString().split('T')[0]}" data-campo="fechaInicio"></td>
                        <td><input type="date" value="${new Date(reserva.fechaFin).toISOString().split('T')[0]}" data-campo="fechaFin"></td>
                        <td>
                            <button onclick="guardarCambiosReserva(${reserva.id}, this)">Actualizar</button>
                            <button class="eliminar" onclick="eliminarReserva(${reserva.id}, this)">Eliminar</button>
                        </td>
                    `;
                        tbody.appendChild(row);
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    }

    //SECCIÓN PAGOS
    // Función para cargar los pagos
    function cargarPagos() {
        fetch('../Controlador/controladorPago.php?accion=listar')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la red');
                }
                return response.json();
            })
            .then(pagos => {
                const tbody = document.getElementById('pagos-list');
                tbody.innerHTML = '';

                // Verificar si hay pagos
                if (pagos.length === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td colspan="6" style="text-align: center;">No hay pagos registrados.</td>`;
                    tbody.appendChild(row);
                } else {
                    pagos.forEach(pago => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td><span class="readonly-field">${pago.id}</span></td>
                        <td><input type="text" value="${pago.descripcion}" data-campo="descripcion"></td>
                        <td><input type="number" value="${pago.monto_total}" data-campo="monto_total"></td>
                        <td><input type="text" value="${pago.metodo_pago}" data-campo="metodo_pago"></td>
                        <td><span class="readonly-field">${pago.reserva_id}</span></td>
                        <td>
                            <button onclick="guardarCambiosPago(${pago.id}, this)">Actualizar</button>
                            <button class="eliminar" onclick="eliminarPago(${pago.id})">Eliminar</button>
                        </td>
                    `;
                        tbody.appendChild(row);
                    });
                }
            })
            .catch(error => console.error('Error al cargar los pagos:', error));
    }
    });


// FUERA DE DOM CONTENT LOADED PARA TENER ACCESO

// CLIENTES
// Confirmar cambios clientes
function guardarCambios(id, button) {
    const row = button.closest('tr'); // Encuentra la fila correspondiente
    const inputs = row.querySelectorAll('input[data-campo]'); // Encuentra los inputs de la fila
    const datos = {};

    // Recoger datos de los inputs
    inputs.forEach(input => {
        datos[input.getAttribute('data-campo')] = input.value; // Guardamos los valores de cada input
    });

    if (confirm('¿Estás seguro de que quieres guardar los cambios?')) {
        // Realizar la petición AJAX para actualizar
        fetch('../Controlador/controladorCliente.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                accion: 'actualizar',
                id: id, // ID del cliente a actualizar
                dni: datos.dni,
                apellidos: datos.apellidos,
                nombre: datos.nombre,
                fechaNacimiento: datos.fechaNacimiento,
                telefono: datos.telefono,
                correo: datos.correo,
                localidad: datos.localidad,
                provincia: datos.provincia,
                cp: datos.cp
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la red');
                }
                return response.json(); // Cambia a JSON para obtener el resultado
            })
            .then(resultado => {
                if (resultado.success) {
                    alert('Cambios guardados con éxito');
                    // Actualiza los inputs en el DOM con los nuevos valores
                    inputs.forEach(input => {
                        input.setAttribute('value', input.value); // Actualiza el valor del atributo
                    });
                } else {
                    alert('Error al guardar cambios: ' + (resultado.error || 'Error desconocido'));
                }
            })
            .catch(error => console.error('Error al guardar cambios:', error));
    } else {
        // Si se cancela, no hay nada que hacer
        console.log('Cambios cancelados');
    }
}

// Función para eliminar un cliente
function eliminarCliente(id, button) {
    if (confirm('¿Estás seguro de que quieres eliminar este cliente?')) {
        fetch('../Controlador/controladorCliente.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                accion: 'eliminar',
                id: id
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la red');
                }
                return response.json(); // Cambia a JSON para analizar la respuesta
            })
            .then(resultado => {
                console.log('Respuesta del servidor:', resultado); // Muestra la respuesta en la consola
                if (resultado.success) {
                    alert('Cliente eliminado con éxito');
                    const row = button.closest('tr'); // Encuentra la fila correspondiente
                    row.remove(); // Elimina la fila del DOM
                } else {
                    alert('Error al eliminar el cliente: ' + (resultado.error || 'Error desconocido'));
                }
            })
            .catch(error => console.error('Error al eliminar el cliente:', error));
    }
}

// VEHÍCULOS
// Confirmar cambios (actualizar) vehículo
function guardarCambiosVehiculo(id, button) {
    const row = button.closest('tr');
    const inputs = row.querySelectorAll('input[data-campo]');
    const datos = {};

    // Recoger datos de los inputs
    inputs.forEach(input => {
        datos[input.getAttribute('data-campo')] = input.value;
    });

    if (confirm('¿Estás seguro de que quieres guardar los cambios?')) {
        fetch('../Controlador/controladorVehiculo.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                accion: 'actualizar',
                id: id,
                marca: datos.marca,
                modelo: datos.modelo,
                matricula: datos.matricula,
                plazas: datos.plazas,
                combustible: datos.combustible,
                precioDia: datos.precioDia,
                estado: datos.estado,
                imagen: datos.imagen
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la red');
                }
                return response.json();
            })
            .then(resultado => {
                if (resultado.success) {
                    alert('Cambios guardados con éxito');
                    // Actualiza los inputs en el DOM con los nuevos valores
                    inputs.forEach(input => {
                        input.setAttribute('value', input.value); // Actualiza el valor del atributo
                    });
                } else {
                    alert('Error al guardar cambios: ' + (resultado.error || 'Error desconocido'));
                }
            })
            .catch(error => console.error('Error al guardar cambios:', error));
    } else {
        console.log('Cambios cancelados');
    }
}


// Función para eliminar un vehículo
function eliminarVehiculo(id, button) {
    if (confirm('¿Estás seguro de que quieres eliminar este vehículo?')) {
        fetch('../Controlador/controladorVehiculo.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                accion: 'eliminar',
                id: id
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la red');
                }
                return response.json();
            })
            .then(resultado => {
                if (resultado.success) {
                    alert('Vehículo eliminado con éxito');
                    const row = button.closest('tr'); // Encuentra la fila correspondiente
                    row.remove(); // Elimina la fila del DOM
                } else {
                    alert('Error al eliminar vehículo: ' + (resultado.error || 'Error desconocido'));
                }
            })
            .catch(error => console.error('Error al eliminar vehículo:', error));
    }
}

// SEGUROS
// Función para guardar los cambios de un seguro
function guardarCambiosSeguro(id, button) {
    const row = button.closest('tr');
    const tipo = row.querySelector('select[data-campo="tipo"]').value;
    const cobertura = row.querySelector('input[data-campo="cobertura"]').value;
    const precio = row.querySelector('input[data-campo="precio"]').value;
    const descripcion = row.querySelector('input[data-campo="descripcion"]').value;

    // Confirmación antes de proceder con la actualización
    if (confirm('¿Estás seguro de que deseas guardar los cambios en este seguro?')) {
        // Petición para actualizar el seguro
        fetch('../Controlador/controladorSeguro.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                accion: 'actualizar',
                id: id,
                tipo: tipo,
                cobertura: cobertura,
                precio: precio,
                descripcion: descripcion
            })
        })
            .then(response => response.json())
            .then(resultado => {
                if (resultado.success) {
                    alert('Seguro actualizado con éxito');

                    // Actualizar la fila correspondiente en el DOM
                    row.querySelector('select[data-campo="tipo"]').value = tipo;
                    row.querySelector('input[data-campo="cobertura"]').value = cobertura;
                    row.querySelector('input[data-campo="precio"]').value = precio;
                    row.querySelector('input[data-campo="descripcion"]').value = descripcion;
                } else {
                    alert('Error al actualizar el seguro: ' + resultado.error);
                }
            })
            .catch(error => console.error('Error al actualizar el seguro:', error));
    }
}

// Función para eliminar una reparación
function eliminarReparacion(id, button) {
    if (!id) {
        console.error('ID no definido');
        return;
    }

    if (confirm('¿Estás seguro de eliminar esta reparación?')) {
        fetch('../Controlador/controladorReparacion.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                accion: 'eliminar',
                id: id
            })
        })
            .then(response => response.json())
            .then(resultado => {
                if (resultado.success) {
                    alert('Reparación eliminada con éxito');
                    const row = button.closest('tr');
                    if (row) row.remove();
                } else {
                    alert('Error al eliminar reparación: ' + (resultado.error || 'Error desconocido'));
                }
            })
            .catch(error => console.error('Error al eliminar reparación:', error));
    }
}

// Función para actualizar una reparación existente
function actualizarReparacion(id, button) {
    const row = button.closest('tr');
    const descripcion = row.querySelector('input[data-campo="descripcion"]').value;
    const costo = row.querySelector('input[data-campo="costo"]').value;
    const fecha = row.querySelector('input[data-campo="fecha"]').value;

    if (confirm('¿Estás seguro de que deseas actualizar esta fila?')) {
        fetch('../Controlador/controladorReparacion.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                accion: 'actualizar',
                id: id,
                descripcion: descripcion,
                costo: costo,
                fecha: fecha
            })
        })
            .then(response => response.json())
            .then(resultado => {
                console.log('Resultado parseado:', resultado);
                if (resultado.success) {
                    alert('Reparación actualizada correctamente.');
                    cargarReparaciones();
                } else {
                    alert('Error al actualizar reparación: ' + (resultado.error || 'Error desconocido'));
                }
            })
            .catch(error => console.error('Error al actualizar reparación:', error));
    }
}
// Función para eliminar un seguro
function eliminarSeguro(id, button) {
    if (confirm('¿Estás seguro de que deseas eliminar este seguro?')) {
        fetch('../Controlador/controladorSeguro.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                accion: 'eliminar',
                id: id
            })
        })
            .then(response => response.json())
            .then(resultado => {
                if (resultado.success) {
                    alert('Seguro eliminado con éxito');

                    // Eliminar la fila correspondiente del DOM
                    const row = button.closest('tr');
                    row.remove();
                } else {
                    alert('Error al eliminar el seguro: ' + resultado.error);
                }
            })
            .catch(error => console.error('Error al eliminar el seguro:', error));
    }
}

// RESERVAS
//Función para eliminar reserva
function eliminarReserva(id, button) {
    // Confirma si el usuario desea eliminar la reserva
    if (confirm('¿Estás seguro de que deseas eliminar esta reserva?')) {
        // Realiza la petición al servidor para eliminar la reserva
        fetch('../Controlador/controladorReserva.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                accion: 'eliminar',
                id: id
            })
        })
            .then(response => response.json())
            .then(resultado => {
                if (resultado.success) {
                    alert('Reserva eliminada con éxito');

                    // Elimina la fila correspondiente del DOM
                    const row = button.closest('tr');
                    row.remove();
                } else {
                    alert('Error al eliminar la reserva: ' + resultado.error);
                }
            })
            .catch(error => console.error('Error al eliminar la reserva:', error));
    }
}

//Función para actualizar una reserva
function guardarCambiosReserva(id, button) {
    // Pide confirmación al usuario
    if (!confirm('¿Estás seguro de que deseas actualizar esta reserva?')) {
        return; // Si el usuario cancela, salir de la función
    }

    // Obtiene los valores de los campos editables de la fila correspondiente
    const row = button.closest('tr');
    const fechaInicio = row.querySelector('input[data-campo="fechaInicio"]').value;
    const fechaFin = row.querySelector('input[data-campo="fechaFin"]').value;
    const estado = row.querySelector('select[data-campo="estado"]').value;

    // Realiza la petición al servidor para actualizar la reserva
    fetch('../Controlador/controladorReserva.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            accion: 'actualizar',
            id: id,
            fechaInicio: fechaInicio,
            fechaFin: fechaFin,
            estado: estado
        })
    })
        .then(response => response.json())
        .then(resultado => {
            if (resultado.success) {
                alert('Reserva actualizada con éxito');

                // Actualiza la fila correspondiente en el DOM
                row.querySelector('input[data-campo="fechaInicio"]').value = fechaInicio;
                row.querySelector('input[data-campo="fechaFin"]').value = fechaFin;
                row.querySelector('select[data-campo="estado"]').value = estado;
            } else {
                alert('Error al actualizar la reserva: ' + resultado.error);
            }
        })
        .catch(error => console.error('Error al actualizar la reserva:', error));
}

//PAGOS
//Eliminar pago
function eliminarPago(id, button) {
    if (!id) {
        console.error('ID no definido');
        return;
    }

    if (confirm('¿Estás seguro de eliminar este pago?')) {
        fetch('../Controlador/controladorPago.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                accion: 'eliminar',
                id: id
            })
        })
            .then(response => response.json())
            .then(resultado => {
                console.log('Resultado parseado:', resultado);
                if (resultado.success) {
                    alert('Pago eliminado con éxito');
                    const row = button.closest('tr');
                    if (row) row.remove();
                } else {
                    alert('Error al eliminar pago: ' + (resultado.error || 'Error desconocido'));
                }
            })
            .catch(error => console.error('Error al eliminar pago:', error));
    }
}
//Actualizar un pago
function guardarCambiosPago(id, button) {
    const row = button.closest('tr');
    const descripcion = row.querySelector('input[data-campo="descripcion"]').value;
    const monto_total = row.querySelector('input[data-campo="monto_total"]').value;
    const metodo_pago = row.querySelector('input[data-campo="metodo_pago"]').value;
    if (confirm('¿Estás seguro de que deseas actualizar este pago?')) {
        fetch('../Controlador/controladorPago.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                accion: 'actualizar',
                id: id,
                descripcion: descripcion,
                monto_total: monto_total,
                metodo_pago: metodo_pago,
            })
        })
            .then(response => response.text()) // Obtenemos la respuesta como texto crudo
            .then(text => {
                console.log('Respuesta cruda del servidor:', text); // Muestra la respuesta cruda
                try {
                    return JSON.parse(text); // Intentamos parsear a JSON
                } catch (e) {
                    console.error('Error al parsear JSON:', e);
                    throw new Error('La respuesta del servidor no es JSON válido.');
                }
            })
            .then(resultado => {
                if (resultado.success) {
                    alert('Pago actualizado correctamente.');
                } else {
                    alert('Error al actualizar pago: ' + (resultado.error || 'Error desconocido'));
                }
            })
            .catch(error => console.error('Error al actualizar pago:', error));
    }
}








