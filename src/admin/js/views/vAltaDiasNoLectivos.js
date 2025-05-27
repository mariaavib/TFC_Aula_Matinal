import { CAltaDiasNoLectivos } from '../controllers/cAltaDiasNoLectivos.js';
/**
 * Instancia del controlador encargado de validar y procesar la modificación de un día no lectivo.
 */
const controlador = new CAltaDiasNoLectivos();
/**
 * Espera a que el contenido del DOM esté completamente cargado.
 * Luego asocia el evento 'submit' del formulario para validar los datos antes de enviarlos al servidor.
 */

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    /**
     * Se activa cuando se envía el formulario.
     * Se detiene el envío normal para poder validar los datos primero.
     * Luego, se recoge la información del formulario y se la pasa al controlador
     * para que la procese (valide y envíe al servidor).
     *
     * @param {SubmitEvent} e - El evento que ocurre al intentar enviar el formulario.
     */

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        controlador.procesar(formData);
    });
});