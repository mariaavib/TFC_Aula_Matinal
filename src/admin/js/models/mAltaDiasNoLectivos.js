export class MAltaDiasNoLectivos {
    async enviarFormulario(formData) {
        try {
            const response = await fetch('index.php?c=DiasNoLectivos&m=insertar', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }

            window.location.href = "index.php?c=DiasNoLectivos&m=listar";

        } catch (error) {
            const errorDiv = document.querySelector('.alert-danger');
            errorDiv.innerText = 'Error al procesar la solicitud';
            errorDiv.style.display = 'block';
        }
    }
}