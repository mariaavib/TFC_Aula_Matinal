/**
 * Clase MModificarDia
 *
 * Modelo responsable de enviar al servidor los datos para modificar un día no lectivo.
 */
export class MModificarDia {ç
    /**
     * Envía los datos del formulario de modificación al servidor mediante una solicitud POST.
     * Redirige al listado de días no lectivos si la operación es exitosa.
     * Si ocurre un error, muestra un mensaje en pantalla.
     *
     * @param {FormData} formData - Datos del formulario a enviar.
     * @returns {Promise<void>}
     */
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
