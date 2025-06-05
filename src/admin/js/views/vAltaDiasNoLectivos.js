/**
 * Validación de formulario de alta de días no lectivos
 */
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const errorDiv = document.querySelector('.alert-danger');
    const mensajeError = errorDiv.querySelector('#mensaje-error');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const fecha = formData.get('fecha');
        const motivo = formData.get('motivo');
        let errores = [];

        if (!fecha) {
            errores.push("El campo fecha es obligatorio.");
        }
        if (!motivo || motivo.trim() === "") {
            errores.push("El campo motivo es obligatorio.");
        } else if (motivo.length < 3) {
            errores.push("El campo motivo debe tener más de 3 caracteres.");
        } else if (motivo.length > 100) {
            errores.push("El campo motivo no puede tener más de 100 caracteres.");
        }

        if (errores.length > 0) {
            mensajeError.innerHTML = errores.join('<br>');
            errorDiv.style.display = 'block';
            return;
        }

        try {
            const response = await fetch('index.php?c=DiasNoLectivos&m=insertar', {
                method: 'POST',
                body: formData
            });

            const text = await response.text();  
            console.log('Respuesta cruda:', text);

            let result;
            try {
                result = JSON.parse(text);
            } catch (e) {
                throw new Error('Respuesta no es JSON válida');
            }

            if (result.error) {
                mensajeError.innerText = result.error;
                errorDiv.style.display = 'block';
                return;
            }

            if (result.status === 'ok') {
                const mensaje = encodeURIComponent(result.message || 'Día no lectivo insertado correctamente.');
                window.location.href = `index.php?c=DiasNoLectivos&m=listar&status=ok&message=${mensaje}`;
            } else {
                mensajeError.innerText = result.message || 'Ocurrió un error desconocido.';
                errorDiv.style.display = 'block';
            }
        } catch (error) {
            console.error('Error en fetch:', error);
            mensajeError.innerText = 'Error de conexión o respuesta no válida del servidor.';
            errorDiv.style.display = 'block';
        }
    });
});
