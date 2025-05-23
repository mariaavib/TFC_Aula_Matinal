export class MModificarDia {
    async enviarFormulario(formData) {
        try {
            const response = await fetch('index.php?c=DiasNoLectivos&m=editar', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }

            window.location.href = "index.php?c=DiasNoLectivos&m=listar";

        } catch (error) {
            const errorDiv = document.querySelector('.errorMensaje');
            errorDiv.innerText = 'Error al procesar la solicitud';
            errorDiv.style.display = 'block';
        }
    }
}
