import { CModificarDia } from '../controllers/cModificarDia.js';
/**
 * Instancia del controlador responsable de validar y procesar el formulario
 * de alta de días no lectivos.
 */
const controlador = new CModificarDia();
/**
 * Espera a que toda la página esté lista (HTML cargado).
 * Una vez lista, busca el formulario y se prepara para gestionar su envío.
 */
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    /**
     * Se ejecuta cuando el usuario intenta enviar el formulario.
     * Se detienne el envío normal, recoge los datos del formulario,
     * y los pasa al controlador para validar y enviarlos correctamente.
     *
     * @param {SubmitEvent} e - El evento que ocurre al enviar el formulario.
     */
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        controlador.procesar(formData);
    });
});
