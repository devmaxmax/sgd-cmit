import { cargador } from '../utils/cargador.js';
import { ModalHandler } from '../utils/ModalHandler.js';

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

            const response = await fetch('/modulos', {
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

            Swal.fire('Modulo guardado con exito');
            this.form.reset();
            setTimeout(() => {
                location.reload();
            }, 2000);

        } catch (error) {
            console.error("Hubo un problema: ", error);
        } finally {
            cargador.setLoading(this.btn, false);
        }
    }

    async getEdicion(id) {
        ModalHandler.show('modal-nuevo-modulo', 'Editar Modulo');

        const btnGuardar = document.getElementById('btn-guardar-nuevo-modulo');

        try {
            cargador.setLoading(btnGuardar, true);

            const response = await fetch(`/modulos/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                }
            });


            if (response.ok) {
                const data = await response.json();

                this.form = document.getElementById('form-nuevo-modulo');
                if (this.form) {
                    this.form.id = 'actualizar-modulo';
                } else {
                    this.form = document.getElementById('actualizar-modulo');
                }

                //cambiar el id del boton
                if (btnGuardar) {
                    btnGuardar.id = 'btn-actualizar-modulo';
                    btnGuardar.dataset.id = id;

                    this.btn = btnGuardar;
                }

                this.llenarFormulario(data);
            } else {
                console.error("Error fetch:", response.status, response.statusText);
                const text = await response.text();
                console.error("Response body:", text);
                throw new Error(`Error al obtener datos: ${response.status}`);
            }
        } catch (error) {
            console.error("Hubo un problema: ", error);
            Swal.fire('Error', 'No se pudieron cargar los datos del modulo', 'error');
        } finally {

            const btnFinal = document.getElementById('btn-guardar-nuevo-modulo') || document.getElementById('btn-actualizar-modulo');
            if (btnFinal) cargador.setLoading(btnFinal, false);
        }
    }

    async eliminar(id) {

        if (!id) return;

        try {

            const resultado = await Swal.fire({
                title: "Eliminar modulo",
                text: "¿Esta seguro que desea eliminar el modulo?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminalo',
                cancelButtonText: 'Cancelar'
            });

            if (resultado.isConfirmed) {

                const response = await fetch(`/modulos/eliminar/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    Swal.fire('Se ha eliminado con exito el modulo');
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
        this.form = document.getElementById('actualizar-modulo');
        this.btn = document.getElementById('btn-actualizar-modulo');

        if (!this.form || !this.btn) {
            console.error("Formulario o botón de actualización no encontrados");
            return;
        }

        const formData = new FormData(this.form);
        formData.append('_method', 'PUT');

        try {
            cargador.setLoading(this.btn, true);

            const response = await fetch(`/modulos/actualizar/${id}`, {
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

            Swal.fire('Modulo actualizado con éxito');
            this.form.reset();
            setTimeout(() => {
                location.reload();
            }, 2000);

        } catch (error) {
            console.error("Hubo un problema: ", error);
            Swal.fire('Error', 'No se pudo actualizar el modulo', 'error');
        } finally {
            if (this.btn) cargador.setLoading(this.btn, false);
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

}