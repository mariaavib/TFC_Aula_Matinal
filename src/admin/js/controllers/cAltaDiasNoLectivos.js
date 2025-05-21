import { MAltaDiasNoLectivos } from '../models/mAltaDiasNoLectivos.js';
export class CAltaDiasNoLectivos {
    modelo;

    constructor() {
        this.modelo = new MAltaDiasNoLectivos();
    }

    validarCampos(fecha, motivo) {
        let errores = [];
    
        if(!fecha){
            errores.push("El campo fecha es obligatorio.");
        }
        if (!motivo || motivo.trim() === "") {
            errores.push("El motivo es obligatorio.");
        } else if (motivo.length < 3) {
            errores.push("El motivo debe tener mas de 3 caracteres.");
        } else if (motivo.length > 100) {
            errores.push("El motivo no puede tener más de 100 caracteres.");
        }
        return errores;
    }

    procesar(formulario) {
        const fecha = formulario.get('fecha');
        const motivo = formulario.get('motivo');
        const errores = this.validarCampos(fecha, motivo);

        const error = document.querySelector('.alert-danger');
        if (errores.length > 0) {
            error.innerHTML = errores.join('<br>');
            error.style.display = 'block';
        } else {
            error.style.display = 'none';
            this.modelo.enviarFormulario(formulario);
        }
    }
}