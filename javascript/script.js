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

//esto es para comprobar el correo electronico que introduce a la hora de hacer el registro
//el DOMContentLoaded comprueba que se a cargado toda la infomacion del html
document.addEventListener("DOMContentLoaded", function () {
    let emailInput = document.getElementById("email");
    let errorMensaje = document.getElementById("error-mensaje");

    emailInput.addEventListener("input", function () {
        let email = emailInput.value;
        let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (emailPattern.test(email)) {
            emailInput.classList.remove("error");
            emailInput.classList.add("success");
            errorMensaje.style.display = "none";
        } else {
            emailInput.classList.remove("success");
            emailInput.classList.add("error");
            errorMensaje.style.display = "inline";
        }
    });

});


//funcion para validar antes de enviar el form
function validarCorreo() {
    let emailInput = document.getElementById("email");
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!emailPattern.test(emailInput.value)) {
        alert("Por favor, introduce un correo válido.");
        return false; // Detiene el envío
    }
    return true; // Envía el formulario si es válido
}
/*-----------------------------------------------------------------------------*/
/*REGISTRO*/
/*-----------------------------------------------------------------------------*/
// Espera a que se cargue todo el contenido de la página
document.addEventListener('DOMContentLoaded', function () {
    // Selecciona todas las capas que tienen la clase 'capa-parallax'
    var capasParallax = document.querySelectorAll('.capa-parallax');

    // Función que se encarga de aplicar el efecto parallax
    function aplicarParallax() {
        // Obtiene la posición actual del scroll vertical
        var posicionScroll = window.pageYOffset;

        // Recorre cada una de las capas parallax
        for (var i = 0; i < capasParallax.length; i++) {
            // Obtiene la velocidad de la capa (si no tiene, se usa 1 por defecto)
            var velocidad = capasParallax[i].dataset.velocidad || 1;

            // Aplica el efecto de translación vertical a cada capa
            capasParallax[i].style.transform = 'translateY(' + (posicionScroll * velocidad) + 'px)';
        }
    }

    // Agrega un evento de 'scroll' a la ventana, que llama a la función 'aplicarParallax' cada vez que se hace scroll
    window.addEventListener('scroll', aplicarParallax);
});
