document.addEventListener("DOMContentLoaded", function () {
    const formularioAltaAlumno = document.querySelector("form");
    const mensajeError = document.querySelector(".alert");

    formularioAltaAlumno.addEventListener("submit", function (evento) {
        mensajeError.style.display = "none";
        mensajeError.textContent = "";

        const nombreCompleto = formularioAltaAlumno.nombreAlumno.value.trim();
        const telefonoContacto = formularioAltaAlumno.telefono.value.trim();

        if (!nombreCompleto || !telefonoContacto) {
            evento.preventDefault(); 
            mensajeError.textContent = "Todos los campos son obligatorios";
            mensajeError.style.display = "block";
            return;
        }
        
        const telefono = /^[0-9]{9}$/; 
        if (!telefono.test(telefonoContacto)) {
            evento.preventDefault();
            mensajeError.textContent = "Introduce un número de teléfono válido";
            mensajeError.style.display = "block";
            return;
        }
    });
});
