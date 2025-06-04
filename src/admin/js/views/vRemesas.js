/**
 * Vista para el control de las remesas como el modal y el buscador
 */
const modalElement = document.getElementById('modalBorrarRemesa');
    const btnConfirmar = document.getElementById('btnConfirmarBorrado');

    modalElement.addEventListener('show.bs.modal', function (event) {
        const triggerButton = event.relatedTarget;
        const idRemesa = triggerButton.getAttribute('data-id');
        btnConfirmar.href = `index.php?c=Remesas&m=eliminarRemesa&id=${idRemesa}`;
    });
document.addEventListener('DOMContentLoaded', () => {
    const buscador = document.getElementById('buscadorRemesas');
    const filas = document.querySelectorAll('tbody tr');

    buscador.addEventListener('input', () => {
        const texto = buscador.value.toLowerCase().trim();

        filas.forEach(fila => {
            const periodo = fila.children[0]?.textContent.toLowerCase() || '';
            const fecha = fila.children[1]?.textContent.toLowerCase() || '';

            if (periodo.includes(texto) || fecha.includes(texto)) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });
});