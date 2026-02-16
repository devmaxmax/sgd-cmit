import { ModalHandler } from "../utils/ModalHandler.js";
import { CrudHandler } from "../clases/ProyectosCrudHandler.js";

//modal
document.getElementById('btn-nuevo-proyecto').addEventListener('click', () => {

    let form = document.getElementById('actualizar-proyecto');
    if (form) {
        form.id = 'form-nuevo-proyecto';
    } else {
        form = document.getElementById('form-nuevo-proyecto');
    }

    let btn = document.getElementById('btn-actualizar-proyecto');
    if (btn) {
        btn.id = 'btn-guardar-nuevo-proyecto';
    }

    form.reset();
    document.getElementById('modal-title').innerText = 'Nuevo Proyecto';

    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

    ModalHandler.show('modal-nuevo-proyecto');
});

//Guardar Proyecto
const nuevoProyecto = new CrudHandler();

document.addEventListener('click', (e) => {
    if (e.target && e.target.id === 'btn-guardar-nuevo-proyecto') {
        e.preventDefault();
        nuevoProyecto.guardar('form-nuevo-proyecto', 'btn-guardar-nuevo-proyecto', '/proyectos');
    }
});


document.addEventListener('DOMContentLoaded', () => {

    const btnEditar = document.querySelectorAll('.btn-editar-proyecto');
    const btnEliminar = document.querySelectorAll('.btn-eliminar-proyecto');

    btnEditar.forEach(boton => {
        boton.addEventListener('click', (e) => {
            e.preventDefault();
            const id = e.currentTarget.dataset.id;
            nuevoProyecto.getEdicion(id);
        });
    });

    btnEliminar.forEach(boton => {
        boton.addEventListener('click', (e) => {
            e.preventDefault();
            const id = e.currentTarget.dataset.id;
            nuevoProyecto.eliminar(id);
        });
    });


});



document.addEventListener('click', (e) => {
    if (e.target && e.target.id === 'btn-actualizar-proyecto') {
        e.preventDefault();
        const id = e.target.dataset.id;

        if (id) {
            nuevoProyecto.actualizar(id);
        } else {
            console.error("No se encontró ID del proyecto para actualizar");
        }
    }
});










