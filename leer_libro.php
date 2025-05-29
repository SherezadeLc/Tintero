<?php
session_start();

// Verificación de sesión
if (!isset($_SESSION["id_usuario"]) || !isset($_SESSION["Nombre_plan"])) {
    die("Acceso denegado. Debes estar logueado.");
}

$plan = $_SESSION["Nombre_plan"];
$id_usuario = $_SESSION['id_usuario'];

// Verifica que el ID del libro esté presente
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de libro no válido.");
}

$id_contenido = intval($_GET['id']);

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tintero");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener información del libro
$sql = "SELECT Titulo, Descripcion, portada FROM libro WHERE ID_Contenido = $id_contenido";
$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) == 0) {
    die("Libro no encontrado.");
}

$libro = mysqli_fetch_assoc($resultado);

// Validar permiso según el plan
$permitido = false;
if ($plan === 'Plan Premium' || $plan === 'Plan Estandar' || $plan === 'Mes prueba') {
    $permitido = true;
} elseif ($plan === 'Plan_Basico' && $libro['visible_basico'] == 1) {
    $permitido = true;
}

if (!$permitido) {
    echo "<p style='color:red; text-align:center;'>Tu plan actual no permite acceder a este libro completo.</p>";
    echo "<p style='text-align:center;'><a href='menu_planes_suscripciones.php'>Mejorar suscripción</a></p>";
    exit();
}

// Obtener capítulos
$sql_capitulos = "SELECT numero_capitulo, titulo_capitulo, contenido FROM capitulos WHERE ID_Contenido = $id_contenido ORDER BY numero_capitulo ASC";
$capitulos = mysqli_query($conexion, $sql_capitulos);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title><?= htmlspecialchars($libro['Titulo']) ?> - Tintero</title>
        <style>
            body {
                background-color: #2a1f36;
                color: white;
                font-family: Arial, sans-serif;
                padding: 40px;
            }
            .portada {
                width: 200px;
                height: 300px;
                object-fit: cover;
                border-radius: 8px;
            }
            .capitulo {
                margin-bottom: 40px;
            }
            h1, h2 {
                color: #ffd769;
            }
            .descripcion {
                font-style: italic;
                color: #ccc;
            }
        </style>
    </head>
    <body>

        <h1><?= htmlspecialchars($libro['Titulo']) ?></h1>
        <img src="./img_portada/<?= htmlspecialchars($libro['portada']) ?>" class="portada" alt="Portada del libro">
        <p class="descripcion"><?= nl2br(htmlspecialchars($libro['Descripcion'])) ?></p>
        <hr>

        <?php
        if (mysqli_num_rows($capitulos) > 0) {
            while ($capitulo = mysqli_fetch_assoc($capitulos)) {
                echo "<div class='capitulo'>";
                echo "<h2>Capítulo " . $capitulo['numero_capitulo'] . ": " . htmlspecialchars($capitulo['titulo_capitulo']) . "</h2>";
                echo "<p>" . nl2br(htmlspecialchars($capitulo['contenido'])) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Este libro aún no tiene capítulos.</p>";
        }

        mysqli_close($conexion);
        ?>

    </body>
</html>
