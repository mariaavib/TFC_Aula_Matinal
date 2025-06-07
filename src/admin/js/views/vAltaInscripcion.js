document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        let errores = [];

        // Obtener valores del formulario
        const nombrePadre = form.elements['nombrePadre']?.value.trim() || '';
        const apellidosPadre = form.elements['apellidosPadre']?.value.trim() || '';
        const dni = form.elements['DNI']?.value.trim() || '';
        const telefono = form.elements['telefono']?.value.trim() || '';
        const correo = form.elements['correo']?.value.trim() || '';
        const iban = form.elements['IBAN']?.value.trim() || '';
        const titularCuenta = form.elements['titularCuenta']?.value.trim() || '';
        const fechaMandato = form.elements['fechaMandato']?.value.trim() || '';
        const nombreAlumno = form.elements['nombreAlumno']?.value.trim() || '';
        const apellidosAlumno = form.elements['apellidosAlumno']?.value.trim() || '';
        const idClase = form.elements['idClase']?.value.trim() || '';

        // Funciones de validación (idénticas a PHP)
        function validarRequerido(valor, nombre) {
            if (!valor || (nombre === 'Clase' && valor === 'SELECCIONE UNA CLASE')) {
                errores.push(`El campo '${nombre}' es obligatorio.`);
                return false;
            }
            return true;
        }

        function validarSoloLetras(valor, nombre) {
            if (!/^[\p{L}\s\-]+$/u.test(valor)) {
                errores.push(`El campo '${nombre}' solo puede contener letras y espacios.`);
                return false;
            }
            return true;
        }

        function validarDNI(valor) {
            const dniNieRegex = /^([0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]|[XYZ][0-9]{7}[TRWAGMYFPDXBNJZSQVHLCKE])$/i;
            const pasaporteRegex = /^(?=.*[A-Z])[A-Z0-9]{6,20}$/i;
            if (!dniNieRegex.test(valor) && !pasaporteRegex.test(valor)) {
                errores.push("El DNI/NIE/Pasaporte no es válido.");
                return false;
            }
            return true;
        }
        function validarIBAN(valor) {
            const ibanLimpio = valor.replace(/\s/g, '');
            if (!/^[A-Z]{2}\d{2}[A-Z0-9]{1,30}$/i.test(ibanLimpio) || ibanLimpio.length > 34) {
                errores.push("El IBAN no es válido (debe empezar con 2 letras, 2 dígitos de control,  máximo 34 caracteres).");
                return false;
            }
            return true;
        }
        function validarTelefono(valor) {
            if (!/^\+?[1-9][0-9]{7,14}$/.test(valor) || valor.length > 24) {
                errores.push("El teléfono no es válido (puede contener '+' al inicio, de 1 a 3 dígitos del código del país, 5 a 12 dígitos de número nacional, SIN espacios).");
                return false;
            }
            return true;
        }
        function validarCorreo(valor) {
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(valor)) {
                errores.push("El correo electrónico no es válido.");
                return false;
            }
            return true;
        }

        // Validaciones JS igual que en PHP
                // ...después de validarRequerido(nombrePadre, 'Nombre del tutor');
        if (validarRequerido(nombrePadre, 'Nombre del tutor')) validarSoloLetras(nombrePadre, 'Nombre del tutor');
        if (validarRequerido(apellidosPadre, 'Apellidos del tutor')) validarSoloLetras(apellidosPadre, 'Apellidos del tutor');
        if (validarRequerido(dni, 'DNI')) validarDNI(dni);
        if (validarRequerido(telefono, 'Teléfono')) validarTelefono(telefono);
        if (validarRequerido(correo, 'Correo')) validarCorreo(correo);
        if (validarRequerido(iban, 'IBAN')) validarIBAN(iban);
        validarRequerido(titularCuenta, 'Titular de la cuenta');
        validarRequerido(fechaMandato, 'Fecha de mandato');
        if (validarRequerido(nombreAlumno, 'Nombre del alumno')) validarSoloLetras(nombreAlumno, 'Nombre del alumno');
        if (validarRequerido(apellidosAlumno, 'Apellidos del alumno')) validarSoloLetras(apellidosAlumno, 'Apellidos del alumno');
        validarRequerido(idClase, 'Clase');

        // Mostrar errores en el mismo formato que PHP
        let errorDiv = document.getElementById('errores-js');
        if (errorDiv) errorDiv.remove();

        if (errores.length > 0) {
            e.preventDefault();
            errorDiv = document.createElement('div');
            errorDiv.id = 'errores-js';
            errorDiv.className = 'alert alert-danger alert-dismissible fade show mx-auto';
            errorDiv.style.maxWidth = '650px';
            errorDiv.role = 'alert';
            errorDiv.innerHTML = `
                <strong>Por favor, corrija los siguientes errores:</strong>
                <ul>${errores.map(e => `<li>${e}</li>`).join('')}</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            form.parentNode.insertBefore(errorDiv, form);
            errorDiv.querySelector('.btn-close').onclick = function() {
                errorDiv.remove();
            };
            return; // No enviar si hay errores
        }
        // Si no hay errores, el formulario se envía normalmente y PHP hace el resto
    });
});