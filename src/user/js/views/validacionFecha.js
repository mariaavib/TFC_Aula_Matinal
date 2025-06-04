/**
 * Validaciones de fecha para que se seleccione una fecha correcta
 */
document.addEventListener('DOMContentLoaded', function() {
    const formFecha = document.getElementById('formFecha');
    const inputFecha = document.getElementById('fecha');
    const mensajeError = document.getElementById('mensajeError');

    formFecha.addEventListener('submit', async function(e) {
        e.preventDefault();
    
        const fecha = new Date(inputFecha.value);
        const diaSemana = fecha.getDay();

        const hoy = new Date();
        hoy.setHours(0, 0, 0, 0);  

        // Validar fin de semana (0 = domingo, 6 = sábado)
        if (diaSemana === 0 || diaSemana === 6) {
            mostrarError('No se puede seleccionar un fin de semana.');
            return;
        }

        if (fecha > hoy) {
            mostrarError('No se puede seleccionar una fecha posterior al día actual.');
            return;
        }
    
        try {
            const response = await fetch(`index.php?c=ControlAsistencia&m=verificarDiaNoLectivo&fecha=${inputFecha.value}`);
            const data = await response.json();
    
            if (data.esNoLectivo) {
                mostrarError(data.mensaje || 'La fecha seleccionada es un día no lectivo.');
                return;
            }
    
            formFecha.submit();
    
        } catch (error) {
            mostrarError('Error al verificar la fecha. Por favor, inténtelo de nuevo.');
        }
    });

    function mostrarError(mensaje) {
        mensajeError.textContent = mensaje;
        mensajeError.style.display = 'block';

    }
});
