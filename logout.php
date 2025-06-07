<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero</title>
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <link rel="stylesheet" type="text/css" href="./css/Logout.css">
        <script src="./javascript/script.js"></script>
        <!--CSS para los brillos del fondo-->
        <link rel="stylesheet" type="text/css" href="./css/fondo_estrellas.css">
    </head>
    <body class="loaded">
        <div class="contenedor_logout">
            <?php
            session_start();
            print '<h1>Estás en Logout</h1>';
            if (isset($_SESSION["nombre_usuario"])) {
                print 'Hasta pronto, ' . $_SESSION["nombre_usuario"] . '<br>';
            } else {
                print 'No hay usuario activo.<br>';
            }
            session_destroy();
            print 'Se ha cerrado la sesión.';
            ?>
            <form action="login.php" method="POST">
                <input type="submit" value="Volver">
            </form>
        </div>
<!--<script>
    window.addEventListener('load', () => {
        document.body.classList.add('loaded');
    });
</script>-->
    </body>
</html>

