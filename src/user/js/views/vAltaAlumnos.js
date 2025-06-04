/**
 * Valida el formulario de alta de alumno.
 * 
 * Verifica que los campos obligatorios no estén vacíos y que el número de teléfono tenga 9 dígitos.
 * Si hay algún error, muestra un mensaje de error y evita que se envíe el formulario.
 */
export class vAltaAlumnos {
    constructor() {
        this.mensajeError = document.querySelector(".alert");
    }

    mostrarError(mensajes) {
        if (Array.isArray(mensajes)) {
            this.mensajeError.innerHTML = `
                <ul class="mb-0">
                    ${mensajes.map(msg => `<li>${msg}</li>`).join('')}
                </ul>
            `;
        } else {
            this.mensajeError.textContent = mensajes;
        }
        this.mensajeError.classList.remove("d-none");
    }
    

    ocultarError() {
        this.mensajeError.innerHTML = "";
        this.mensajeError.classList.add("d-none");  
    }
    
}
import { cAltaAlumnos } from "../controllers/cAltaAlumnos.js";
document.addEventListener("DOMContentLoaded", () => {
    // console.log("Script cargado correctamente");
    const formulario = document.querySelector("form");
    if (formulario) {
        // console.log("Formulario encontrado");
        new cAltaAlumnos(formulario);
    }
});

