<?php
    // Inicia la sesión para acceder a las variables de sesión
    session_start();
    
    // Se accede a variables de sesión para conocer el plan y el ID del usuario
    $_SESSION["Nombre_Plan"];
    $_SESSION['id_usuario'];
     // Plan actual del usuario (ej: Básico, Estándar, Premium)
    $plan = $_SESSION["Nombre_Plan"];
    // ID del usuario autenticado
    $id_usuario = $_SESSION['id_usuario'];

    // Verifica que se haya enviado el ID del capítulo por GET
    if (!isset($_GET['id_capitulo'])) {
        // Detiene el script si no se proporciona el ID del capítulo
        die("Capítulo no especificado.");
    }

    // ID del capítulo recibido por la URL
    $id_capitulo = $_GET['id_capitulo'];

    // Conexión a la base de datos MySQL
    $conexion = mysqli_connect("localhost", "root", "", "tintero");
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Consulta para obtener los datos del capítulo junto al título del libro al que pertenece
    $sql = "SELECT c.*, l.Titulo AS titulo_libro
                FROM capitulos c
                JOIN libro l ON c.ID_Contenido = l.ID_Contenido
                WHERE c.id_capitulo = $id_capitulo";

    $resultado = mysqli_query($conexion, $sql);
    // Extrae la fila del resultado
    $capitulo = mysqli_fetch_assoc($resultado);

    // Si no se encuentra el capítulo, se muestra error
    if (!$capitulo) {
        die("Capítulo no encontrado.");
    }

    // Si el plan del usuario es Plan_Basico, se restringe el acceso
    if ($plan === 'Plan_Basico') {
        die("<h2 style='color:red; text-align:center;'>Este capítulo no está disponible para tu plan de suscripción.</h2>");
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Leer Capítulo</title>
        <link rel="stylesheet" href="./css/Registro_Login.css">
        <style>
            /* Estilo general del cuerpo */
            body {
                background-color: #2a1f36;
                color: white;
                font-family: Arial, sans-serif;
                padding: 20px;
            }
            /* Contenedor principal del contenido */
            .contenedor {
                max-width: 800px;
                margin: auto;
                background: #3a2d4d;
                padding: 30px;
                border-radius: 10px;
            }
            /* Estilo para títulos */
            h1, h2 {
                text-align: center;
                color: #FFD764;
            }
            /* Contenido del capítulo */
            .contenido {
                margin-top: 20px;
                white-space: pre-wrap;/* Conserva saltos de línea */
                line-height: 1.6;
            }
            /* Botón de volver */
            .btn {
                display: block;
                margin: 30px auto 0;
                padding: 10px 20px;
                background-color: #28a745;
                color: white;
                border: none;
                border-radius: 5px;
                text-decoration: none;
            }
            .btn:hover {
                background-color: #218838;
            }
        </style>
    </head>
    <body>

        <div class="contenedor">
            <!-- Muestra el título del libro y el número y título del capítulo -->
            <h1><?= htmlspecialchars($capitulo['titulo_libro']) ?></h1>
            <h2>Capítulo <?= $capitulo['numero_capitulo'] ?>: <?= htmlspecialchars($capitulo['titulo_capitulo']) ?></h2>

            <!-- Contenido textual del capítulo -->
            <div class="contenido">
                <?= $capitulo['contenido'] ?>
            </div>

            <!-- Botón para volver a la página anterior -->
            <button id="boton_cancelar" type="button" class="btn">Volver a capítulos</button>
        </div>
         <!-- Script JS que permite volver atrás usando el historial del navegador -->
        <script>
            document.getElementById("boton_cancelar").addEventListener("click", function () {
                history.back();
            });
        </script>
    </body>
</html>