<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero</title>
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <link rel="stylesheet" type="text/css" href="./css/crea_Universos.css">
        <script src="./javascript/script.js"></script>
    </head>
    <body>
        <?php
        $conexion = mysqli_connect("localhost", "root", "", "tintero");
        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }
        ?>
    </body>
</html>
