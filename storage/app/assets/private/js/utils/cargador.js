export const cargador = {
    setLoading: (btn, isLoading) => {

        if (!btn) return;

        if (!isLoading) {
            btn.disabled = false;
            btn.innerHTML = btn.dataset.originalText || 'Guardar';
            return;
        }

        btn.dataset.originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `
            <span class="spinner-border spinner-border-sm" role="status"></span>
            Cargando...
        `;
    }
}