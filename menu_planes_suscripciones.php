<?php
     // Inicia la sesión para poder usar variables de sesión
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Configuración del encabezado del documento -->
        <!-- Codificación de caracteres -->
        <meta charset="UTF-8">
        <!-- Responsividad en dispositivos móviles -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Título de la pestaña del navegador -->
        <title>Tintero</title>
        <!-- Ícono del sitio (favicon) -->
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
         <!-- Hojas de estilo externas para diseño -->
         <!-- Estilos específicos de esta página -->
        <link rel="stylesheet" type="text/css" href="./css/Menu_planes_suscripciones.css">
        <!-- Estilos del fondo animado -->
        <link rel="stylesheet" type="text/css" href="./css/fondo_estrellas.css">
        <!-- Script JS general -->
        <script src="./javascript/script.js"></script>
    </head>
    <style>
        .footer {
            background-color: #2a1f36;
            color: white;
            padding: 30px 20px;
            font-family: Arial, sans-serif;
        }

        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            max-width: 1000px;
            margin: auto;
        }

        .footer h3, .footer h4 {
            color: #FFD764;
            margin-bottom: 10px;
        }

        .footer p, .footer a {
            color: #ccc;
            font-size: 14px;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .footer-center ul {
            list-style: none;
            padding: 0;
        }

        .footer-center ul li {
            margin: 6px 0;
        }

        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                text-align: center;
            }

            .footer-left, .footer-center, .footer-right {
                margin-bottom: 20px;
            }
        }

    </style>
    <body>
       <!-- Fondo animado con elementos "firefly" (luciérnagas) -->
        <div id="estrellas">
            <!-- Se crean 10 elementos div que simulan estrellas animadas -->
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div>
        </div>

       <!-- Título principal centrado -->
        <h2 style="text-align: center;">Planes de Suscripción</h2>

        <!-- Tabla con los distintos planes disponibles -->
        <table>
            <tr>
                <!-- Encabezados de la tabla -->
                <th>Nombre del Plan</th>
                <th>Precio Mensual</th>
                <th>Precio Anual</th>
                <th>Beneficios Incluidos</th>
                <th>Pagar Mensualmente</th>
                <th>Pagar Anualmente</th>
            </tr>

            <!-- Fila: Plan Básico -->
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

            <!-- Fila: Plan Estándar -->
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

            <!-- Fila: Plan Premium -->
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

            <!-- Fila: Mes de prueba -->
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
        <!-- Botón para volver al menú del usuario suscrito -->
        <a href="menuSuscrito.php"><button id="boton-volver">Volver</button></a>

    </body>
    <footer class="footer">
            <div class="footer-container">
                <div class="footer-left">
                    <h3>Tintero</h3>
                    <p>Historias en cada gota</p>
                    <p>Donde nacen historias en cada gota de inspiración </p>
                    <h3>Redes sociales</h3>
                    <p>Instagram: @tintero_oficial</p>
                    <p>X: @tintero_oficial</p>
                    <p>Tiktok: @tintero_oficial</p>
                    <p>Facebook: @tintero_oficial</p>
                </div>

                <div class="footer-center">
                    <h4>Enlaces</h4>
                    <ul>
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="categorias.php">Categorías</a></li>
                        <li><a href="perfil.php">Mi Perfil</a></li>
                        <li><a href="login.php">Iniciar Sesión</a></li>
                    </ul>
                </div>

                <div class="footer-right">
                    <h4>Contacto</h4>
                    <p>Email: soporte@tintero.com</p>
                    <p>&copy; <?= date("Y") ?> Tintero. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
</html>
