document.addEventListener('DOMContentLoaded', function () {
    //Ver detalles
    const botonesVer = document.querySelectorAll('.ver-detalles');
    const modalDetalles = new bootstrap.Modal(document.getElementById('detallesModal'));

    botonesVer.forEach(boton => {
        boton.addEventListener('click', function (e) {
            e.preventDefault(); 
            modalDetalles.show();
        });
    });

    // Generar remesas
    const btnGenerarRemesa = document.getElementById('generarRemesa');
    const modalGenerarRemesa = new bootstrap.Modal(document.getElementById('generarRemesaModal'));
    const fechaRemesa = document.getElementById('fechaRemesa');
    const btnConfirmarGeneracion = document.getElementById('confirmarGeneracion');

    //Establecer fecha por defecto 
    const hoy = new Date();
    fechaRemesa.value = hoy.toISOString().split('T')[0];

    btnGenerarRemesa?.addEventListener('click', function(e) {
        e.preventDefault();
        modalGenerarRemesa.show();
    });

    btnConfirmarGeneracion?.addEventListener('click', async function() {
        try {
            
            modalGenerarRemesa.hide();
            alert('Remesa generada correctamente');
        } catch (error) {
            alert('Error al generar la remesa');
        }
    });
});
