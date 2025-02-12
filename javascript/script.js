"use strict";

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
