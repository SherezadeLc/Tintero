 <?php
 // Inicia o continúa la sesión para poder destruirla
    session_start();
 ?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Configuración de codificación y vista responsiva -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <!-- Título de la pestaña del navegador -->
        <title>Tintero</title>
        <!-- Icono en la pestaña del navegador -->
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <!-- Estilos personalizados para la página de logout -->
        <link rel="stylesheet" type="text/css" href="./css/Logout.css">
        <!-- Script JavaScript adicional (si aplica) -->
        <script src="./javascript/script.js"></script>
        <!-- Estilos del fondo animado (brillos/estrellas) -->
        <link rel="stylesheet" type="text/css" href="./css/fondo_estrellas.css">
    </head>
    <body class="loaded">
         <!-- Fondo animado de estrellas -->
        <div id="estrellas">
            <!-- Cada "firefly" es un punto animado del fondo -->
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div>
        </div>
          <!-- Contenedor principal de la sección de logout -->
        <div class="contenedor_logout">
            <?php
           
            // Mensaje principal en pantalla
            print '<h1>Estás en Logout</h1>';
            // Verifica si hay un usuario con sesión activa
            if (isset($_SESSION["nombre_usuario"])) 
                {
                 // Despide al usuario mostrando su nombre
                print 'Hasta pronto, ' . $_SESSION["nombre_usuario"] . '<br>';
            } else {
                // Si no hay sesión activa, muestra mensaje genérico
                print 'No hay usuario activo.<br>';
            }
            // Destruye toda la sesión (cierra sesión)
            session_destroy();
            // Confirma que la sesión ha sido cerrada
            print 'Se ha cerrado la sesión.';
            ?>
            <!-- Botón para volver al login -->
            <form action="login.php" method="POST">
                <input type="submit" value="Volver">
            </form>
        </div>
    </body>
</html>

