document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[action*="insertarFechaCurso"]');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Limpiar alertas anteriores
        document.querySelectorAll('.alert').forEach(alert => alert.remove());

        const fechaIni = form.fecha_ini.value.trim();
        const fechaFin = form.fecha_fin.value.trim();
        let errores = [];

        // Validaciones igual que en PHP
        if (!fechaIni) {
            errores.push("La 'Fecha de Inicio' no puede estar vacía.");
        }
        if (!fechaFin) {
            errores.push("La 'Fecha de Fin' no puede estar vacía.");
        }

        // Solo comparar si ambas fechas están presentes
        if (fechaIni && fechaFin) {
            const dateIni = new Date(fechaIni);
            const dateFin = new Date(fechaFin);

            if (isNaN(dateIni.getTime()) || isNaN(dateFin.getTime())) {
                errores.push("Formato de fecha inválido.");
            } else if (dateIni > dateFin) {
                errores.push("La 'Fecha de Inicio' no puede ser posterior a la 'Fecha de Fin'.");
            }
        }

        if (errores.length > 0) {
            mostrarErrores(errores);
            return;
        }

        // Si pasa validaciones, enviar con fetch
        const formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(html => {
            document.body.innerHTML = html;
        })
        .catch(() => {
            mostrarErrores(["Error al enviar el formulario. Inténtalo de nuevo."]);
        });
    });

    function mostrarErrores(errores) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show mx-auto';
        alertDiv.style.maxWidth = '650px';
        alertDiv.role = 'alert';

        alertDiv.innerHTML = `
            <strong>Por favor, corrija los siguientes errores:</strong>
            <ul>
                ${errores.map(e => `<li>${e}</li>`).join('')}
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        `;

        // Insertar antes del formulario
        form.parentNode.insertBefore(alertDiv, form);
    }
});