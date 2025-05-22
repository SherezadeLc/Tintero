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




/*-----------------------------------------------------------------------------*/
/* CATEGORÍA */
/*-----------------------------------------------------------------------------*/
/*
// Hacemos que la función sea accesible desde el HTML
window.abrirModal = function () {
    const modal = document.getElementById('modal');
    modal.style.display = 'flex';

    const formData = new FormData();
    formData.append('accion', 'cargar_categorias');

    fetch('categorias.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('contenedorCategorias').innerHTML = html;

        // Ahora que el formulario ya existe en el DOM, agregamos el listener
        const form = document.getElementById('formCategorias');
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const seleccionadas = Array.from(
                    document.querySelectorAll('input[name="categorias[]"]:checked')
                ).map(cb => cb.value);

                if (seleccionadas.length === 0) {
                    alert("Selecciona al menos una categoría.");
                    return;
                }

                const datos = new FormData();
                datos.append('accion', 'buscar_libros');
                seleccionadas.forEach(cat => datos.append('categorias[]', cat));

                fetch('categorias.php', {
                    method: 'POST',
                    body: datos
                })
                .then(res => res.text())
                .then(html => {
                    document.getElementById('resultado').innerHTML = html;
                    modal.style.display = 'none';
                })
                .catch(err => console.error("Error buscando libros:", err));
            });
        }
    })
    .catch(err => console.error("Error cargando categorías:", err));
};

// Cierra el modal si se hace clic fuera del contenido
document.addEventListener('click', function (e) {
    const modal = document.getElementById('modal');
    if (modal && e.target === modal) {
        modal.style.display = 'none';
    }
});
*/
