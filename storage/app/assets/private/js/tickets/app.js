import { ModalHandler } from "../utils/ModalHandler.js";
import { CrudHandler } from "../clases/TicketsCrudHandler.js";

document.getElementById('btn-nuevo-ticket').addEventListener('click', () => {

    let form = document.getElementById('actualizar-ticket');

    const contenedorImag = document.getElementById('contenedor-imagenes');
    contenedorImag.innerHTML = `
        <div class="input-group mb-2">
            <input type="file" class="form-control" name="imagenes[]" accept="image/*">
            <button type="button" class="btn btn-outline-secondary btn-eliminar-imagen" disabled>
                <i class="fas fa-minus"></i>
            </button>
        </div>
    `;

    if (form) {
        form.id = 'form-nuevo-ticket';
    } else {
        form = document.getElementById('form-nuevo-ticket');
    }

    let btn = document.getElementById('btn-actualizar-ticket');
    if (btn) {
        btn.id = 'btn-guardar-nuevo-ticket';
    }
    form.reset();

    document.getElementById('modal-title').innerText = 'Nuevo Ticket';

    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

    ModalHandler.show('modal-nuevo-ticket');
});


document.getElementById('btn-agregar-imagen').addEventListener('click', () => {
    const contenedor = document.getElementById('contenedor-imagenes');
    const nuevoInput = document.createElement('div');
    nuevoInput.className = 'input-group mb-2';
    nuevoInput.innerHTML = `
        <input type="file" class="form-control" name="imagenes[]" accept="image/*">
        <button type="button" class="btn btn-outline-danger btn-eliminar-imagen">
            <i class="fas fa-minus"></i>
        </button>
    `;
    contenedor.appendChild(nuevoInput);

    actualizarBotonesEliminar();
});

document.addEventListener('click', (e) => {
    if (e.target && e.target.closest('.btn-eliminar-imagen')) {
        const btn = e.target.closest('.btn-eliminar-imagen');
        const inputGroup = btn.closest('.input-group');
        const contenedor = document.getElementById('contenedor-imagenes');

        if (contenedor.children.length > 1) {
            inputGroup.remove();
            actualizarBotonesEliminar();
        }
    }
});

function actualizarBotonesEliminar() {
    const contenedor = document.getElementById('contenedor-imagenes');
    const botones = contenedor.querySelectorAll('.btn-eliminar-imagen');

    if (botones.length === 1) {
        botones[0].disabled = true;
        botones[0].classList.replace('btn-outline-danger', 'btn-outline-secondary');
    } else {
        botones.forEach(btn => {
            btn.disabled = false;
            btn.classList.replace('btn-outline-secondary', 'btn-outline-danger');
        });
    }
}

const nuevoTicket = new CrudHandler();


document.addEventListener('click', (e) => {
    if (e.target && e.target.id === 'btn-guardar-nuevo-ticket') {
        e.preventDefault();
        nuevoTicket.guardar('form-nuevo-ticket', 'btn-guardar-nuevo-ticket');
    }
});

document.getElementById('btn-buscar-tickets').addEventListener('click', () => {
    const modulo = document.getElementById('filtro-modulo').value;
    const prioridad = document.getElementById('filtro-prioridad').value;
    const estado = document.getElementById('filtro-estado').value;
    const busqueda = document.getElementById('busqueda').value;

    const params = new URLSearchParams();

    if (modulo) params.append('modulo_id', modulo);
    if (prioridad) params.append('prioridad', prioridad);
    if (estado) params.append('estado', estado);
    if (busqueda) params.append('busqueda', busqueda);

    window.location.href = `${window.location.pathname}?${params.toString()}`;
});

document.addEventListener('DOMContentLoaded', () => {

    const btnEditar = document.querySelectorAll('.btn-editar-ticket');
    const btnEliminar = document.querySelectorAll('.btn-eliminar-ticket');
    const btnVer = document.querySelectorAll('.btn-ver-ticket');
    const btnAvance = document.querySelectorAll('.btn-registrar-avance');
    const btnListadoAvance = document.querySelectorAll('.btn-listado-avances')

    btnEditar.forEach(boton => {
        boton.addEventListener('click', (e) => {
            e.preventDefault();
            const id = e.currentTarget.dataset.id;
            nuevoTicket.getEdicion(id);
        });
    });

    btnEliminar.forEach(boton => {
        boton.addEventListener('click', (e) => {
            e.preventDefault();
            const id = e.currentTarget.dataset.id;
            nuevoTicket.eliminar(id);
        });
    });

    btnVer.forEach(boton => {
        boton.addEventListener('click', (e) => {
            e.preventDefault();
            const id = e.currentTarget.dataset.id;
            nuevoTicket.ver(id);
            ModalHandler.show('modal-ver-ticket');
        });
    });

    btnListadoAvance.forEach(boton => {
        boton.addEventListener('click', (e) => {
            e.preventDefault();
            const id = e.currentTarget.dataset.id;
            nuevoTicket.listarAvances(id);
            ModalHandler.show('modal-listado-avances');
        });
    });

    btnAvance.forEach(boton => {
        boton.addEventListener('click', (e) => {
            e.preventDefault();
            const id = e.currentTarget.dataset.id;
            ModalHandler.show('modal-registrar-avance');

            const btnGuardar = document.getElementById('btn-guardar-nuevo-avance');
            if (btnGuardar) {
                btnGuardar.dataset.id = id;
            }

            const form = document.getElementById('form-registrar-avance');
            if (form) form.reset();
        });
    });

});

document.addEventListener('click', (e) => {
    if (e.target && e.target.id === 'btn-actualizar-ticket') {
        e.preventDefault();
        const id = e.target.dataset.id;

        if (id) {
            nuevoTicket.actualizar(id);
        } else {
            console.error("No se encontró ID del ticket para actualizar");
        }
    }
});

document.addEventListener('click', (e) => {
    if (e.target && e.target.id === 'btn-guardar-nuevo-avance') {
        e.preventDefault();
        const id = e.target.dataset.id;

        if (id) {
            nuevoTicket.registrarAvance(id);
        } else {
            console.error("No se encontró ID del ticket para actualizar");
        }
    }
});


