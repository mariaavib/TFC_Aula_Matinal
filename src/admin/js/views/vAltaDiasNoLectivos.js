import { CAltaDiasNoLectivos } from '../controllers/cAltaDiasNoLectivos.js';
const controlador = new CAltaDiasNoLectivos();

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        controlador.procesar(formData);
    });
});