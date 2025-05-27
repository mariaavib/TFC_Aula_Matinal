/**
 * Clase CModificarDia
 * 
 * Controlador encargado de gestionar la modificación de un día no lectivo.
 * Se comunica con el modelo MModificarDia y valida los datos del formulario antes de enviarlos.
 * 
 */
import { MModificarDia } from '../models/mModificarDia.js';

export class CModificarDia {
    modelo;

    constructor() {
        this.modelo = new MModificarDia();
    }

    /**
     * Valida los campos del formulario.
     *
     * @param {string} fecha - Fecha del día no lectivo.
     * @param {string} motivo - Motivo del día no lectivo.
     * @returns {string[]} Lista de errores encontrados.
     */
    validarCampos(fecha, motivo) {
        let errores = [];
    
        if (!fecha) {
            errores.push("El campo fecha es obligatorio.");
        }
        if (!motivo || motivo.trim() === "") {
            errores.push("El campo motivo es obligatorio.");
        } else if (motivo.length < 3) {
            errores.push("El campo motivo debe tener al menos 3 caracteres.");
        } else if (motivo.length > 100) {
            errores.push("El campo motivo no puede tener más de 100 caracteres.");
        }
    
        return errores;
    }
    /**
     * Procesa el formulario, valida los datos y, si son correctos, envía la información al modelo.
     *
     * @param {FormData} formulario - Objeto FormData con los datos del formulario.
     */

    procesar(formulario) {
        const fecha = formulario.get('fecha');
        const motivo = formulario.get('motivo');
        const errores = this.validarCampos(fecha, motivo);

        const errorDiv = document.querySelector('.errorMensaje');
        if (errores.length > 0) {
            errorDiv.innerText = errores.join(' ');
            errorDiv.style.display = 'block';
        } else {
            errorDiv.style.display = 'none';
            this.modelo.enviarFormulario(formulario);
        }
    }
}
