export class ModalHandler {

    constructor(triggerId, modalId, title) {
        this.triggerElement = triggerId ? document.getElementById(triggerId) : null;
        this.modalElement = document.getElementById(modalId);
        this.modalInstance = null; // Guardar la instancia de Bootstrap
        this.titleElement = document.getElementById('modal-title').innerText = title;

        if (this.triggerElement) {
            this.init();
        }
    }

    init() {
        this.triggerElement.addEventListener('click', (e) => {
            e.preventDefault();
            this.show();
        });
    }

    show() {
        if (this.modalElement) {
            this.modalInstance = bootstrap.Modal.getOrCreateInstance(this.modalElement);
            this.modalInstance.show();
        } else {
            console.error('Modal element not found');
        }
    }

    static show(modalId, title = null) {
        const modalElement = document.getElementById(modalId);
        if (modalElement) {
            if (title) {
                const titleElement = modalElement.querySelector('.modal-title');
                if (titleElement) {
                    titleElement.innerText = title;
                }
            }
            const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
            modalInstance.show();
        } else {
            console.error(`Error en modal ${modalId}. No encontrado`);
        }
    }
}