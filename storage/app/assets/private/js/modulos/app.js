import { CrudHandler } from "../clases/ModulosCrudHandler.js";
import { ModalHandler } from "../utils/ModalHandler.js";

//modal
document.getElementById('btn-nuevo-modulo').addEventListener('click', () => {

    // Revertir ID del formulario si fue cambiado
    let form = document.getElementById('actualizar-modulo');
    if (form) {
        form.id = 'form-nuevo-modulo';
    } else {
        form = document.getElementById('form-nuevo-modulo');
    }


    let btn = document.getElementById('btn-actualizar-modulo');
    if (btn) {
        btn.id = 'btn-guardar-nuevo-modulo';
    }

    form.reset();
    document.getElementById('modal-title').innerText = 'Nuevo Modulo';

    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

    ModalHandler.show('modal-nuevo-modulo');
});

//Guardar Modulo
const nuevoModulo = new CrudHandler();

document.addEventListener('click', (e) => {
    if (e.target && e.target.id === 'btn-guardar-nuevo-modulo') {
        e.preventDefault();
        nuevoModulo.guardar('form-nuevo-modulo', 'btn-guardar-nuevo-modulo');
    }
});

document.addEventListener('DOMContentLoaded', () => {

    const btnEditar = document.querySelectorAll('.btn-editar-modulo');
    const btnEliminar = document.querySelectorAll('.btn-eliminar-modulo');


    btnEditar.forEach(boton => {
        boton.addEventListener('click', (e) => {
            e.preventDefault();
            const id = e.currentTarget.dataset.id;
            nuevoModulo.getEdicion(id);
        });
    });

    btnEliminar.forEach(boton => {
        boton.addEventListener('click', (e) => {
            e.preventDefault();
            const id = e.currentTarget.dataset.id;
            nuevoModulo.eliminar(id);
        });
    });
});

document.addEventListener('click', (e) => {
    if (e.target && e.target.id === 'btn-actualizar-modulo') {
        e.preventDefault();
        const id = e.target.dataset.id;

        if (id) {
            nuevoModulo.actualizar(id);
        } else {
            console.error("No se encontró ID del modulo para actualizar");
        }
    }
});

//Filtro 
const btnBuscar = document.getElementById('btn-buscar-modulos');
if (btnBuscar) {
    btnBuscar.addEventListener('click', () => {
        const proyectoId = document.getElementById('filtro-proyecto').value;
        const estado = document.getElementById('filtro-estado').value;
        const filas = document.querySelectorAll('#tabla-modulos tr');

        filas.forEach(fila => {
            const rowProyectoId = fila.getAttribute('data-proyecto-id');
            const rowEstado = fila.getAttribute('data-estado');

            let mostrar = true;

            if (proyectoId && rowProyectoId !== proyectoId) {
                mostrar = false;
            }

            if (estado && rowEstado !== estado) {
                mostrar = false;
            }

            fila.style.display = mostrar ? '' : 'none';
        });
    });
}