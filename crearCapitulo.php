<?php
session_start();

// Solo permitir acceso si el usuario está logueado
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tintero");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener el ID del libro desde GET o sesión
if (isset($_GET['id'])) {
    $id_contenido = intval($_GET['id']);
    $_SESSION['ID_Contenido'] = $id_contenido;
} elseif (isset($_SESSION['ID_Contenido'])) {
    $id_contenido = $_SESSION['ID_Contenido'];
} else {
    die("Error: No se especificó el libro al que pertenece el capítulo.");
}

// Procesar el formulario si se envió
if (isset($_GET['guardar_capitulo'])) {
    $titulo = $_GET['titulo_capitulo'];
    $contenido = $_GET['contenido_capitulo'];
    $numero_capitulo = $_GET['numero_capitulo'];
    $fecha_publicacion = date("Y-m-d");

    // Insertar capítulo
    $sql = "INSERT INTO capitulos (titulo_capitulo, contenido, numero_capitulo, contenido, ID_Contenido)
            VALUES ('$titulo', '$contenido', '$numero_capitulo', '$id_contenido')";

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
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script>
        window.onload = function () {
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
            <label for="numero_capitulo">Número del capítulo:</label><br>
            <input type="number" id="numero_capitulo" name="numero_capitulo" required>
        </div>
        <div>
            <label for="contenido_capitulo">Contenido del capítulo:</label><br>
            <textarea id="contenido_capitulo" name="contenido_capitulo" rows="15" required></textarea>
        </div>
        <input type="submit" name="guardar_capitulo" value="Guardar Capítulo">
        <a href="menuSuscrito.php"><button type="button" id="boton_cancelar">Cancelar</button></a>
    </form>

</body>
</html>
