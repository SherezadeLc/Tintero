"use strict";
/*-----------------------------------------------------------------------------*/
/*MENU*/
/*-----------------------------------------------------------------------------*/
document.addEventListener('DOMContentLoaded', function () {
    const diapositivas = document.querySelector('.carrusel');
    const imagenes = Array.from(diapositivas.querySelectorAll('img'));
    const totalDiapositivas = imagenes.length;
    let index = 0;

    // Configuración del carrusel
    const imagenesVisibles = 6;
    let anchoImagen = diapositivas.clientWidth / imagenesVisibles;

    // Función para actualizar el ancho de las imágenes si cambia el tamaño de la ventana
    const actualizarAnchoImagen = () => {
        anchoImagen = diapositivas.clientWidth / imagenesVisibles;
        imagenes.forEach((imagen, i) => {
            imagen.style.width = `${anchoImagen}px`;
            imagen.style.left = `${anchoImagen * i}px`;
        });
        actualizarDiapositiva();
    };

    function actualizarDiapositiva() {
        const offset = -index * anchoImagen;
        diapositivas.style.transform = `translateX(${offset}px)`;
    }

    function siguienteDiapositiva() {
        index = (index + 1) % totalDiapositivas;
        actualizarDiapositiva();
    }

    // Inicializa las diapositivas
    actualizarAnchoImagen();

    // Actualiza el ancho de las imágenes si cambia el tamaño de la ventana
    window.addEventListener('resize', actualizarAnchoImagen);

    // Cambiar las imágenes automáticamente cada 5 segundos
    setInterval(siguienteDiapositiva, 5000);
});
/*-----------------------------------------------------------------------------*/
/*REGISTRO*/
/*-----------------------------------------------------------------------------*/
// Validación de correo
function validarCorreo() {
    const emailInput = document.getElementById('email');
    const errorMessage = document.getElementById('error-message');

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(emailInput.value)) {
        errorMessage.style.display = 'block';
        return false;
    } else {
        errorMessage.style.display = 'none';
        return true;
    }
}
