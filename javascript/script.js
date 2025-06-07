"use strict";
/*-----------------------------------------------------------------------------*/
/*MENU*/
/*-----------------------------------------------------------------------------*/
document.addEventListener('DOMContentLoaded', function () {
    const carrusel = document.querySelector('.carrusel');
    const btnIzquierda = document.querySelector('.flecha.izquierda');
    const btnDerecha = document.querySelector('.flecha.derecha');

    btnIzquierda.addEventListener('click', () => {
        carrusel.scrollBy({
            left: -220, // Ancho de una tarjeta + margen
            behavior: 'smooth'
        });
    });

    btnDerecha.addEventListener('click', () => {
        carrusel.scrollBy({
            left: 220,
            behavior: 'smooth'
        });
    });

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


