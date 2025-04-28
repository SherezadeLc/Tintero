<?php
session_start();

// Si quieres proteger la página para que sólo accedan usuarios logueados, descomenta:
/*
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}
*/

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tintero");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verificar que hemos recibido el ID correcto
if (!isset($_GET['ID_Contenido'])) {
    die("Error: No se especificó el libro al que pertenece el capítulo.");
}

$id_universo = intval($_GET['ID_Contenido']); // ← Ahora bien capturado

if (isset($_POST['guardar_capitulo'])) {
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo_capitulo']);
    $contenido = mysqli_real_escape_string($conexion, $_POST['contenido_capitulo']); // Aquí era contenido_capitulo
    $id_usuario = $_SESSION['id_usuario']; // Corregido: no ID_Autor, sino id_usuario
    $fecha_publicacion = date("Y-m-d");

    // Verifica los nombres de columnas REALES de tu tabla capitulos
    $sql = "INSERT INTO capitulos (titulo_capitulo, contenido, ID_Contenido)
            VALUES ('$titulo', '$contenido', '$id_universo')";

    if (mysqli_query($conexion, $sql)) {
        echo "<p style='color:lightgreen; text-align:center;'>Capítulo guardado correctamente.</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>Error al guardar el capítulo: " . mysqli_error($conexion) . "</p>";
    }
}

mysqli_close($conexion);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tintero - Crear Capítulo</title>
    <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
    <link rel="stylesheet" type="text/css" href="./css/Crear_Capitulo.css">
    
    <!-- Cargar CKEditor desde el CDN -->
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    
    <script>
        // Inicializar CKEditor
        window.onload = function() {
            CKEDITOR.replace('contenido_capitulo', {
                height: 300,
                uiColor: '#34214d'
            });
        };
    </script>
</head>
<body>

    <h1>Crear un nuevo capítulo</h1>

    <form method="POST" action="">
        <div>
            <label for="titulo_capitulo">Título del capítulo:</label><br>
            <input type="text" id="titulo_capitulo" name="titulo_capitulo" required>
        </div>

        <div>
            <label for="contenido_capitulo">Contenido del capítulo:</label><br>
            <textarea id="contenido_capitulo" name="contenido_capitulo" rows="15" required></textarea>
        </div>

        <input type="submit" name="guardar_capitulo" value="Guardar Capítulo">
    </form>

</body>
</html>
