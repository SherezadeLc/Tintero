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
    <link rel="stylesheet" type="text/css" href="./css/Registro_Login.css">
    <script src="./javascript/script.js"></script>
    <style>
        body {
            background-color: #2a1f36;
            color: white;
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 90%;
            margin: auto;
            margin-top: 50px;
            background-color: #3a2d4d;
        }
        th, td {
            border: 1px solid #555;
            padding: 12px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #0077cc;
            color: white;
            font-size: 16px;
        }
        .btn {
            padding: 10px 18px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            display: inline-block;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

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
    <form action="menuSuscrito.php" method="POST">
                <input type="submit" value="Volver">
    </form>

</body>
</html>
