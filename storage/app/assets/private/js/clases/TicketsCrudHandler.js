import { cargador } from "../utils/cargador.js";
import { ModalHandler } from "../utils/ModalHandler.js";

export class CrudHandler {

    constructor() {
        this.form = null;
        this.btn = null;
    }

    async guardar(formId, btnId) {
        this.form = document.getElementById(formId);
        this.btn = document.getElementById(btnId);

        const formData = new FormData(this.form);

        try {

            cargador.setLoading(this.btn, true);

            const response = await fetch('/tickets', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (!response.ok) {

                if (response.status === 422) {
                    this.mostrarErrores(data.error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Datos incorrectos',
                        text: 'Por favor, revisa los campos en rojo',
                        confirmButtonColor: '#3085d6'
                    });
                } else {
                    Swal.fire("Error: " + (data.message || "Error desconocido"));
                }
                return;
            }

            Swal.fire('Ticket generado con exito');
            this.form.reset();
            setTimeout(() => {
                location.reload();
            }, 2000);

        } catch (error) {
            console.error(error);
        } finally {
            cargador.setLoading(this.btn, false);
        }
    }

    async ver(id) {

        cargador.setLoading(this.btn, true);

        try {

            const response = await fetch(`tickets/ver/${id}`, {
                method: 'GET',
            });

            if (response.ok) {
                const data = await response.json();
                document.getElementById('ver-titulo-ticket').innerText = data.titulo;
                document.getElementById('ver-modulo-ticket').innerText = data.modulo ? data.modulo.nombre : 'N/A';
                document.getElementById('ver-prioridad-ticket').innerText = data.prioridad.charAt(0).toUpperCase() + data.prioridad.slice(1);
                document.getElementById('ver-estado-ticket').innerText = data.estado.charAt(0).toUpperCase() + data.estado.slice(1).replace('_', ' ');
                document.getElementById('ver-descripcion-ticket').innerText = data.descripcion;

                const imagenesContainer = document.getElementById('ver-imagenes-ticket');
                imagenesContainer.innerHTML = '';
                if (data.imagenes && data.imagenes.length > 0) {
                    const listGroup = document.createElement('div');
                    listGroup.className = 'list-group list-group-flush';

                    data.imagenes.forEach(img => {
                        const link = document.createElement('a');
                        link.href = `/storage/${img.path}`;
                        link.target = '_blank';
                        link.className = 'list-group-item list-group-item-action d-flex align-items-center px-0 text-primary';
                        link.innerHTML = `<i class="fas fa-image me-2 text-secondary"></i> ${img.nombre}`;
                        listGroup.appendChild(link);
                    });
                    imagenesContainer.appendChild(listGroup);
                } else {
                    imagenesContainer.innerHTML = '<span class="text-muted small fst-italic">Sin imágenes adjuntas</span>';
                }

            } else {
                Swal.fire("Error al cargar el id seleccionado. Consulte al administrador.");
            }

        } catch (error) {
            console.error(error);
        } finally {
            cargador.setLoading(this.btn, false);
        }
    }

    async getEdicion(id) {
        ModalHandler.show('modal-nuevo-ticket', 'Editar Ticket');

        const btnGuardar = document.getElementById('btn-guardar-nuevo-ticket');

        try {
            cargador.setLoading(btnGuardar, true);

            const response = await fetch(`/tickets/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();

                this.form = document.getElementById('form-nuevo-ticket');
                if (this.form) {
                    this.form.id = 'actualizar-ticket';
                } else {

                    this.form = document.getElementById('actualizar-ticket');
                }

                if (btnGuardar) {
                    btnGuardar.id = 'btn-actualizar-ticket';
                    btnGuardar.dataset.id = id
                }

                this.llenarFormulario(data);

                // Renderizar imágenes existentes
                const container = document.getElementById('contenedor-imagenes-existentes');
                container.innerHTML = '';
                if (data.imagenes && data.imagenes.length > 0) {
                    const label = document.createElement('label');
                    label.className = 'form-label small text-muted';
                    label.innerText = 'Imágenes actuales:';
                    container.appendChild(label);

                    data.imagenes.forEach(img => {
                        const div = document.createElement('div');
                        div.className = 'input-group mb-2';
                        div.innerHTML = `
                            <div class="form-control d-flex align-items-center justify-content-between">
                                <span class="text-truncate">
                                    <i class="fas fa-image me-2 text-primary"></i>
                                    <a href="/storage/${img.path}" target="_blank" class="text-decoration-none text-dark">${img.nombre}</a>
                                </span>
                            </div>
                            <button type="button" class="btn btn-outline-danger btn-eliminar-imagen-existente" data-id="${img.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        `;
                        container.appendChild(div);
                    });

                    // Agregar listeners para eliminar
                    container.querySelectorAll('.btn-eliminar-imagen-existente').forEach(btn => {
                        btn.addEventListener('click', async (e) => {
                            e.preventDefault();
                            const botonEliminar = e.currentTarget;
                            const idImagen = botonEliminar.dataset.id;

                            const result = await Swal.fire({
                                title: '¿Eliminar imagen?',
                                text: "Esta acción no se puede deshacer",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Sí, eliminar',
                                cancelButtonText: 'Cancelar'
                            });

                            if (result.isConfirmed) {
                                try {
                                    const response = await fetch(`/tickets/imagen/${idImagen}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                            'Accept': 'application/json'
                                        }
                                    });

                                    if (response.ok) {
                                        botonEliminar.closest('.input-group').remove();
                                        Swal.fire('Eliminado', 'La imagen ha sido eliminada.', 'success');
                                        if (container.querySelectorAll('.input-group').length === 0) {
                                            container.innerHTML = '';
                                        }
                                    } else {
                                        Swal.fire('Error', 'No se pudo eliminar la imagen', 'error');
                                    }
                                } catch (error) {
                                    console.error(error);
                                    Swal.fire('Error', 'Ocurrió un error al eliminar', 'error');
                                }
                            }
                        });
                    });
                }

            } else {
                console.error("Error fetch:", response.status, response.statusText);
                const text = await response.text();
                console.error("Response body:", text);
                throw new Error(`Error al obtener datos: ${response.status}`);
            }

        } catch (error) {
            console.error("Hubo un problema: ", error);
            Swal.fire('Error', 'No se pudieron cargar los datos del ticket', 'error');

        } finally {
            const btnFinal = document.getElementById('btn-guardar-nuevo-ticket') || document.getElementById('btn-actualizar-ticket');
            if (btnFinal) cargador.setLoading(btnFinal, false);
        }
    }

    async eliminar(id) {
        if (!id) return;

        try {

            const resultado = await Swal.fire({
                title: "Eliminar ticket",
                text: "¿Esta seguro que desea eliminar el ticket?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminalo',
                cancelButtonText: 'Cancelar'
            });

            if (resultado.isConfirmed) {
                const response = await fetch(`/tickets/eliminar/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    Swal.fire('Se ha eliminado con exito el ticket');
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }

            }

        } catch (error) {
            console.error(error);
        }
    }


    async actualizar(id) {
        this.form = document.getElementById('actualizar-ticket');
        this.btn = document.getElementById('btn-actualizar-ticket');

        if (!this.form || !this.btn) {
            console.error("Formulario o botón de actualización no encontrados");
            return;
        }

        const formData = new FormData(this.form);
        formData.append('_method', 'PUT');

        try {

            cargador.setLoading(this.btn, true);

            const response = await fetch(`/tickets/actualizar/${id}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (!response.ok) {
                if (response.status === 422) {
                    this.mostrarErrores(data.errors);
                    Swal.fire({
                        icon: 'error',
                        title: 'Datos incorrectos',
                        text: 'Por favor, revisa los campos en rojo',
                        confirmButtonColor: '#3085d6'
                    });
                } else {
                    Swal.fire("Error: " + (data.message || "Error desconocido"));
                }
                return;
            }

            Swal.fire('Ticket actualizado con éxito');
            this.form.reset();
            setTimeout(() => {
                location.reload();
            }, 2000);


        } catch (error) {
            console.error(error);
            Swal.fire('Error', 'No se pudo actualizar el ticket', 'error');
        } finally {
            if (this.btn) cargador.setLoading(this.btn, false);
        }

    }

    async registrarAvance(id) {
        if (!id) return;

        this.form = document.getElementById('form-registrar-avance');
        this.btn = document.getElementById('btn-guardar-nuevo-avance');

        if (!this.form || !this.btn) {
            console.error("Formulario o botón de actualización no encontrados");
            return;
        }

        const formData = new FormData(this.form);

        try {
            cargador.setLoading(this.btn, true);

            const response = await fetch(`/avances/${id}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (!response.ok) {
                if (response.status === 422) {
                    this.mostrarErrores(data.errors);
                    Swal.fire({
                        icon: 'error',
                        title: 'Datos incorrectos',
                        text: 'Por favor, revisa los campos en rojo',
                        confirmButtonColor: '#3085d6'
                    });
                } else {
                    Swal.fire("Error: " + (data.message || "Error desconocido"));
                }
                return;
            }

            Swal.fire('Avance registado con éxito');
            this.form.reset();
            setTimeout(() => {
                location.reload();
            }, 2000);

        } catch (error) {
            console.error(error);
            Swal.fire("Error: " + error);
        } finally {
            if (this.btn) cargador.setLoading(this.btn, false);
        }
    }

    async listarAvances(id) {
        const container = document.getElementById('listado-avances');
        container.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>';

        try {
            const response = await fetch(`/tickets/${id}/avances`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const avances = await response.json();
                container.innerHTML = '';

                if (avances.length === 0) {
                    container.innerHTML = '<div class="alert alert-info text-center">No hay avances registrados para este ticket.</div>';
                    return;
                }

                avances.forEach(avance => {
                    const date = new Date(avance.created_at);
                    const formattedDate = date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                    const div = document.createElement('div');
                    div.className = 'card mb-3 border-light shadow-sm';
                    div.innerHTML = `
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted d-flex justify-content-between">
                                <span><i class="far fa-clock me-1"></i> ${formattedDate}</span>
                            </h6>
                            <p class="card-text text-dark" style="white-space: pre-wrap;">${avance.observacion}</p>
                        </div>
                        <hr>
                    `;
                    container.appendChild(div);
                });
            } else {
                container.innerHTML = '<div class="alert alert-danger">Error al cargar los avances.</div>';
            }
        } catch (error) {
            console.error(error);
            container.innerHTML = '<div class="alert alert-danger">Error de conexión.</div>';
        }
    }

    mostrarErrores(errors) {
        this.limpiarErrores();

        Object.keys(errors).forEach(key => {
            const input = this.form.querySelector(`[name = "${key}"]`);
            if (input) {
                input.classList.add('is-invalid');
                const errorDiv = document.createElement('div');
                errorDiv.className = "invalid-feedback font-weight-bold";
                errorDiv.innerText = errors[key][0];
                input.after(errorDiv);
            }
        });
    }

    limpiarErrores() {
        this.form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        this.form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    }

    llenarFormulario(data) {
        Object.keys(data).forEach(key => {
            const input = this.form.querySelector(`[name="${key}"]`);

            if (input) {
                input.value = data[key];
            }
        });
    }

    limpiarCampos() {
        const campos = [
            'titulo-ticket',
            'modulo-ticket',
            'prioridad-ticket',
            'estado-ticket',
            'descripcion-ticket',
            'imagenes-ticket'
        ];

        campos.forEach(id => {
            document.getElementById(id).textContent = '';
        });
    }
}