<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero</title>
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <link rel="stylesheet" type="text/css" href="./css/Registro_Login.css">
        <script src="./javascript/script.js"></script>
        <style>
            body {
                background-color: #2a1f36;
                color: white;
                font-family: Arial, sans-serif;
                text-align: center;
                padding-top: 50px;
            }
            .resumen {
                background-color: #3a2d4d;
                padding: 20px;
                border-radius: 10px;
                display: inline-block;
            }
            .btn {
                padding: 10px 20px;
                background-color: #28a745;
                border: none;
                color: white;
                border-radius: 5px;
                margin-top: 20px;
                text-decoration: none;
            }
            .btn:hover {
                background-color: #218838;
            }
        </style>
        <?php
        session_start();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre_plan = $_POST["nombre_plan"] ?? 'Desconocido';
            $modo = $_POST["modo"] ?? 'Desconocido';
            $precio = $_POST["precio"] ?? '0.00';

            echo "<h2 style='text-align: center; color: green;'>¡Pago simulado realizado con éxito!</h2>";
            echo "<p style='text-align: center;'>Has adquirido el Plan: <strong>$nombre_plan</strong> con modalidad <strong>" . ucfirst($modo) . "</strong> por <strong>$precio €</strong>.</p>";
        } else {
            echo "<p style='text-align: center; color: red;'>Acceso no válido.</p>";
        }
        ?>
    </body>
</html>