import { CModificarDia } from '../controllers/cModificarDia.js';
const controlador = new CModificarDia();

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        controlador.procesar(formData);
    });
});
