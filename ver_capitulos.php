<?php
    // Inicia la sesión para mantener datos del usuario
    session_start();

    // Verifica si se ha pasado un ID de libro por la URL y si es un número válido
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        // Detiene la ejecución si no hay ID válido
        die("Libro no especificado.");
    }

    // Convierte el ID recibido a número entero para seguridad
    $id_contenido = intval($_GET['id']);

    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "tintero");
    if (!$conexion) {
        // Muestra error si no se puede conectar
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Consulta para obtener el título del libro usando el ID de contenido
    $sql_libro = "SELECT Titulo FROM libro WHERE ID_Contenido = $id_contenido";
    $res_libro = mysqli_query($conexion, $sql_libro);

    // Verifica si se encontró el libro
    if (mysqli_num_rows($res_libro) == 0) {
        // Detiene si no existe el libro
        die("Libro no encontrado.");
    }

    // Almacena los datos del libro
    $libro = mysqli_fetch_assoc($res_libro);

    // Consulta para obtener los capítulos del libro ordenados por número
    $sql_capitulos = "SELECT id_capitulo, numero_capitulo, titulo_capitulo 
                      FROM capitulos 
                      WHERE ID_Contenido = $id_contenido 
                      ORDER BY numero_capitulo ASC";
    // Ejecuta la consulta
    $res_capitulos = mysqli_query($conexion, $sql_capitulos);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Capítulos de <?= htmlspecialchars($libro['Titulo']) ?> - Tintero</title>
        <style>
            /* Estilos básicos para la interfaz */
            body {
                background-color: #2a1f36;
                color: white;
                font-family: Arial, sans-serif;
                padding: 40px;
            }
            h1 {
                color: #ffd769;
                text-align: center;
            }
            .capitulo {
                padding: 15px;
                border-bottom: 1px solid #444;
                text-align: center;
            }
            .capitulo a {
                text-decoration: none;
                color: #ffffff;
                font-size: 18px;
            }
            .capitulo a:hover {
                color: #ffd769;
            }
        </style>
    </head>
    <body>

        <!-- Título con nombre del libro -->
        <h1>Capítulos de: <?= htmlspecialchars($libro['Titulo']) ?></h1>

        <?php
         // Verifica si hay capítulos disponibles
            if (mysqli_num_rows($res_capitulos) > 0) {
                // Recorre cada capítulo y lo muestra como enlace
                while ($cap = mysqli_fetch_assoc($res_capitulos)) {
                    echo "<div class='capitulo'>";
                    echo "<a href='leer_capitulo.php?id_capitulo=" . $cap['id_capitulo'] . "'>";

                    echo "Capítulo " . $cap['numero_capitulo'] . ": " . htmlspecialchars($cap['titulo_capitulo']);
                    echo "</a>";
                    echo "</div>";
                }
            } else {
                // Mensaje si no hay capítulos publicados
                echo "<p>Este libro aún no tiene capítulos publicados.</p>";
            }

            // Cierra la conexión con la base de datos
            mysqli_close($conexion);
        ?>
        <!-- Botón para regresar al menú principal -->
        <div style="text-align: center; margin-top: 40px;">
            <a href="menuSuscrito.php">
                <button style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
                    Volver al menú
                </button>
            </a>
        </div>
    </body>
</html>
