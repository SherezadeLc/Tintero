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
document.addEventListener('DOMContentLoaded', function () {
    // Obtener el formulario y el mensaje de error
    const form = document.querySelector('form');
    const errorMessage = document.getElementById('error-message');

    // Función para validar el correo electrónico
    function validarCorreo() {
        const email = document.getElementById('email').value;
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!regex.test(email)) {
            errorMessage.style.display = 'block';
            return false;
        } else {
            errorMessage.style.display = 'none';
            return true;
        }
    }

    // Animación de entrada para el formulario
    form.style.opacity = 0;
    form.style.transform = 'translateY(50px)';
    form.style.transition = 'all 0.5s ease';

    setTimeout(() => {
        form.style.opacity = 1;
        form.style.transform = 'translateY(0)';
    }, 100);

    // Animación de botón al hacer hover
    const buttons = document.querySelectorAll('input[type="submit"], .login-button');
    buttons.forEach(button => {
        button.addEventListener('mouseover', () => {
            button.style.transform = 'scale(1.1)';
        });
        button.addEventListener('mouseout', () => {
            button.style.transform = 'scale(1)';
        });
    });
});
