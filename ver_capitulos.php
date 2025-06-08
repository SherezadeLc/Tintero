<?php
session_start();

// Verifica si se ha pasado un ID de libro
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Libro no especificado.");
}

$id_contenido = intval($_GET['id']);

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tintero");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener título del libro
$sql_libro = "SELECT Titulo FROM libro WHERE ID_Contenido = $id_contenido";
$res_libro = mysqli_query($conexion, $sql_libro);

if (mysqli_num_rows($res_libro) == 0) {
    die("Libro no encontrado.");
}

$libro = mysqli_fetch_assoc($res_libro);

// Obtener capítulos
$sql_capitulos = "SELECT id_capitulo, numero_capitulo, titulo_capitulo 
                  FROM capitulos 
                  WHERE ID_Contenido = $id_contenido 
                  ORDER BY numero_capitulo ASC";
$res_capitulos = mysqli_query($conexion, $sql_capitulos);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Capítulos de <?= htmlspecialchars($libro['Titulo']) ?> - Tintero</title>
        <style>
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

        <h1>Capítulos de: <?= htmlspecialchars($libro['Titulo']) ?></h1>

        <?php
        if (mysqli_num_rows($res_capitulos) > 0) {
            while ($cap = mysqli_fetch_assoc($res_capitulos)) {
                echo "<div class='capitulo'>";
                echo "<a href='leer_capitulo.php?id_capitulo=" . $cap['id_capitulo'] . "'>";

                echo "Capítulo " . $cap['numero_capitulo'] . ": " . htmlspecialchars($cap['titulo_capitulo']);
                echo "</a>";
                echo "</div>";
            }
        } else {
            echo "<p>Este libro aún no tiene capítulos publicados.</p>";
        }

        mysqli_close($conexion);
        ?>
        <!-- Botón para volver -->
        <div style="text-align: center; margin-top: 40px;">
            <a href="menuSuscrito.php">
                <button style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
                    Volver al menú
                </button>
            </a>
        </div>
    </body>
</html>
