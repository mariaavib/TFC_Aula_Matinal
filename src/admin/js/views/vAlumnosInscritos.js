function configurarBuscadorAlumnos() {
    const inputBuscador = document.getElementById('buscadorAlumnos');
    const filas = document.querySelectorAll('table tbody tr');

    inputBuscador.addEventListener('input', function () {
        const filtro = this.value.toLowerCase();

        filas.forEach(fila => {
            const nombre = fila.querySelector('td')?.textContent.toLowerCase();
            if (nombre.includes(filtro)) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM cargado, configurando eventos...');
    configurarBuscadorAlumnos();
}); 