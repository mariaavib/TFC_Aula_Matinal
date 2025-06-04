/**
 * Funcion para validar los campos del formulario de alta de alumnos.
 */
import { AlumnoModelo } from "../models/mAltaAlumnos.js";
import { vAltaAlumnos } from "../views/vAltaAlumnos.js";

export class cAltaAlumnos {
    constructor(formulario) {
        this.formulario = formulario;
        this.vista = new vAltaAlumnos();

        this.formulario.addEventListener("submit", (evento) => this.validarFormulario(evento));
    }

    validarFormulario(evento) {
        this.vista.ocultarError();

        const datos = {
            nombreAlumno: this.formulario.nombreAlumno.value.trim(),
            apellidosAlumno: this.formulario.apellidosAlumno.value.trim(),
            nombrePadre: this.formulario.nombrePadre.value.trim(),
            apellidosPadre: this.formulario.apellidosPadre.value.trim(),
            telefono: this.formulario.telefono.value.trim(),
            idClase: this.formulario.idClase.value.trim()
        };

        const errores = AlumnoModelo.validar(datos);
        if (errores.length > 0) {
            evento.preventDefault();
            this.vista.mostrarError(errores);
        }
    }
}
