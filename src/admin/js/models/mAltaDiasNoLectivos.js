/**
 * Clase MAltaDiasNoLectivos
 *
 * Modelo encargado de enviar el formulario de alta de días no lectivos al servidor.
 */
export class MAltaDiasNoLectivos {
    /**
     * Envía los datos del formulario al servidor mediante una petición POST.
     * Si la respuesta es correcta, redirige al listado de días no lectivos.
     * Si ocurre un error, muestra un mensaje por pantalla.
     *
     * @param {FormData} formData - Datos del formulario que se enviarán al servidor.
     */
    async enviarFormulario(formData) {
        try {
            const response = await fetch('index.php?c=DiasNoLectivos&m=insertar', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            console.log(result);
            if(result.error) {
                const errorDiv = document.querySelector('.alert-danger');
                errorDiv.innerText = result.error;
                errorDiv.style.display = 'block';
                return;
            }
            
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }

            // window.location.href = "index.php?c=DiasNoLectivos&m=listar";

        } catch (error) {
            const errorDiv = document.querySelector('.alert-danger');
            errorDiv.innerText = 'Error no se puede insertar ese dia no lectivo';
            errorDiv.style.display = 'block';
        }
    }
}