export class MModificarDia {
    async enviarFormulario(formData) {
        try {
            const response = await fetch('../../index.php?c=DiasNoLectivos&m=editar', {
                method: 'POST',
                body: formData
            });

            const resultado = await response.text();

            if (resultado === 'correcto') {
                window.location.href = "../../index.php?c=DiasNoLectivos&m=listar";
            } else {
                const errorDiv = document.querySelector('.errorMensaje');
                errorDiv.innerText = resultado;
                errorDiv.style.display = 'block';
            }

        } catch (error) {
            console.error('Error al enviar el formulario:', error);
            const errorDiv = document.querySelector('.errorMensaje');
            errorDiv.innerText = 'Error de conexión con el servidor.';
            errorDiv.style.display = 'block';
        }
    }
}
