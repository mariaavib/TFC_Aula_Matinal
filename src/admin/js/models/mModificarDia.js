export class MModificarDia {
    async enviarFormulario(formData) {
        try {
            const response = await fetch('index.php?c=DiasNoLectivos&m=editar', {
                method: 'POST',
                body: formData
            });

            if (response.redirected) {
                window.location.href = response.url;
                return;
            }

            const contentType = response.headers.get("content-type");
            if (contentType && contentType.indexOf("application/json") !== -1) {
                const resultado = await response.json();
                if (resultado.error) {
                    const errorDiv = document.querySelector('.errorMensaje');
                    errorDiv.innerText = resultado.error;
                    errorDiv.style.display = 'block';
                } else {
                    window.location.href = "index.php?c=DiasNoLectivos&m=listar";
                }
            } else {
                window.location.href = "index.php?c=DiasNoLectivos&m=listar";
            }

        } catch (error) {
            console.error('Error al enviar el formulario:', error);
            const errorDiv = document.querySelector('.errorMensaje');
            errorDiv.innerText = 'Error de conexión con el servidor.';
            errorDiv.style.display = 'block';
        }
    }
}
