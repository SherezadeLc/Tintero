<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero</title>
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <link rel="stylesheet" type="text/css" href="./css/Menu_planes_suscripciones.css">
        <link rel="stylesheet" type="text/css" href="./css/fondo_estrellas.css">
        <script src="./javascript/script.js"></script>
    </head>
    <body>
        <!-- Fondo de estrellas -->
        <div id="estrellas">
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div>
        </div>

        <h2 style="text-align: center;">Planes de Suscripción</h2>

        <table>
            <tr>
                <th>Nombre del Plan</th>
                <th>Precio Mensual</th>
                <th>Precio Anual</th>
                <th>Beneficios Incluidos</th>
                <th>Pagar Mensualmente</th>
                <th>Pagar Anualmente</th>
            </tr>

            <tr>
                <td>Plan Basico</td>
                <td>0 €</td>
                <td>0 €</td>
                <td>
                    Acceso a la plataforma y funciones básicas de creación y publicación de historias. Herramientas de edición y formateo de texto básicas. Posibilidad de compartir contenido con otros usuarios. Acceso limitado a plantillas y funciones de diseño.
                </td>
                <td><a class='btn' href='pagar.php?plan=basico&modo=mensual'>Pagar Mensual</a></td>
                <td><a class='btn' href='pagar.php?plan=basico&modo=anual'>Pagar Anual</a></td>
            </tr>

            <tr>
                <td>Plan Estandar</td>
                <td>28.99 €</td>
                <td>30.99 €</td>
                <td>
                    Todo lo incluido en el Plan Básico. Acceso a un conjunto más amplio de herramientas de creación y edición. Posibilidad de personalizar plantillas y diseños. Analíticas básicas sobre el rendimiento de las publicaciones.
                </td>
                <td><a class='btn' href='pagar.php?plan=estandar&modo=mensual'>Pagar Mensual</a></td>
                <td><a class='btn' href='pagar.php?plan=estandar&modo=anual'>Pagar Anual</a></td>
            </tr>

            <tr>
                <td>Plan Premium</td>
                <td>48.99 €</td>
                <td>60.99 €</td>
                <td>
                    Todo lo incluido en el Plan Estándar. Acceso a herramientas avanzadas de creación de contenido visual. Plantillas personalizadas y exclusivas. Funcionalidades adicionales para mejorar la visibilidad y promoción del contenido. Analíticas detalladas sobre el rendimiento y compromiso de las publicaciones. Acceso prioritario a soporte y asistencia.
                </td>
                <td><a class='btn' href='pagar.php?plan=premium&modo=mensual'>Pagar Mensual</a></td>
                <td><a class='btn' href='pagar.php?plan=premium&modo=anual'>Pagar Anual</a></td>
            </tr>

            <tr>
                <td>Mes Prueba</td>
                <td>0 €</td>
                <td>-</td>
                <td>
                    Todo lo incluido en el Plan Estándar. Acceso a herramientas avanzadas de creación de contenido visual. Plantillas personalizadas y exclusivas. Funcionalidades adicionales para mejorar la visibilidad y promoción del contenido. Analíticas detalladas sobre el rendimiento y compromiso de las publicaciones. Acceso prioritario a soporte y asistencia.
                </td>
                <td><a class='btn' href='pagar.php?plan=mes_prueba&modo=mensual'>Activar</a></td>
                <td>-</td>
            </tr>

        </table>
        <a href="menuSuscrito.php"><button id="boton-volver">Volver</button></a>

    </body>
</html>
