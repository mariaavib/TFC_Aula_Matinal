document.addEventListener('DOMContentLoaded', function () {
    const botonesVer = document.querySelectorAll('.ver-detalles');
    const modalDetalles = new bootstrap.Modal(document.getElementById('detallesModal'));

    botonesVer.forEach(boton => {
        boton.addEventListener('click', function (e) {
            e.preventDefault(); 
            modalDetalles.show();
        });
    });
});
