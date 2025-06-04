document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[action*="insertarTarifas"]');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Limpiar mensajes anteriores
        const oldAlerts = document.querySelectorAll('.alert');
        oldAlerts.forEach(alert => alert.remove());

        const precioDia = form.precioDia.value.trim();
        const precioMes = form.precioMes.value.trim();
        const numDias = form.numDias.value.trim();

        let errores = [];

        // Mismas validaciones que en el controlador PHP
        if (!precioDia) {
            errores.push("El campo 'Precio por día' no puede estar vacío.");
        } else if (isNaN(precioDia) || Number(precioDia) < 0) {
            errores.push("El campo 'Precio por día' debe ser un número positivo.");
        }

        if (!precioMes) {
            errores.push("El campo 'Precio por mes' no puede estar vacío.");
        } else if (isNaN(precioMes) || Number(precioMes) < 0) {
            errores.push("El campo 'Precio por mes' debe ser un número positivo.");
        }

        if (!numDias) {
            errores.push("El campo 'Número de días' no puede estar vacío.");
        } else if (isNaN(numDias) || Number(numDias) < 1 || Number(numDias) > 31) {
            errores.push("El campo 'Número de días' debe ser un número entre 1 y 31.");
        }

        if (errores.length > 0) {
            mostrarErrores(errores);
            return;
        }

        // Si pasa las validaciones, enviar con fetch
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(html => {
            // Reemplazar el contenido del formulario por la respuesta del servidor
            document.body.innerHTML = html;
        })
        .catch(error => {
            mostrarErrores(["Error al enviar el formulario. Inténtalo de nuevo."]);
        });
    });

    function mostrarErrores(errores) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger mx-auto';
        alertDiv.style.maxWidth = '650px';
        alertDiv.role = 'alert';

        alertDiv.innerHTML = `
            <strong>Por favor, corrija los siguientes errores:</strong>
            <ul>
                ${errores.map(e => `<li>${e}</li>`).join('')}
            </ul>
        `;

        // Insertar el mensaje antes del formulario
        form.parentNode.insertBefore(alertDiv, form);
    }
});