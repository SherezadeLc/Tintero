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
/*Función para validar el correo electrónico*/
function validarCorreo() {
    const emailInput = document.getElementById('email');
    const errorMessage = document.getElementById('error-message');
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Expresión regular para validar el correo

    if (!emailPattern.test(emailInput.value)) {
        errorMessage.style.display = 'block'; // Mostrar mensaje de error
        return false; // Evitar el envío del formulario
    } else {
        errorMessage.style.display = 'none'; // Ocultar mensaje de error
        return true; // Permitir el envío del formulario
    }
}

// Evento para manejar el envío del formulario
document.querySelector('form').addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar el envío inmediato
    if (validarCorreo()) { // Validar el correo antes de enviar
        const contenedor = document.querySelector('.contenedor-registro');
        contenedor.style.transform = 'translateY(-50px)'; // Desplazar hacia arriba
        contenedor.style.opacity = '0'; // Desvanecer el contenedor

        // Simular un retraso antes de enviar el formulario
        setTimeout(() => {
            this.submit(); // Enviar el formulario después de la animación
        }, 500);
    }
});

// Evento para cargar la clase 'loaded' en el body
window.addEventListener('load', function () {
    document.body.classList.add('loaded'); // Agregar clase para el efecto de desvanecimiento
});
