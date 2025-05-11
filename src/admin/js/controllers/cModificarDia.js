import { MModificarDia } from '../models/mModificarDia.js';

export class CModificarDia {
    modelo;

    constructor() {
        this.modelo = new MModificarDia();
    }

    validarCampos(fecha, motivo) {
        let errores = [];
    
        if (!fecha) {
            errores.push("El campo fecha es obligatorio.");
        }
        if (!motivo || motivo.trim() === "") {
            errores.push("El motivo es obligatorio.");
        } else if (motivo.length < 3) {
            errores.push("El motivo debe tener al menos 3 caracteres.");
        } else if (motivo.length > 100) {
            errores.push("El motivo no puede tener más de 100 caracteres.");
        }
    
        return errores;
    }

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
