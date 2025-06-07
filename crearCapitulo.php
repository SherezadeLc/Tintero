<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

$conexion = mysqli_connect("localhost", "root", "", "tintero");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id_contenido = intval($_GET['id']);
    $_SESSION['ID_Contenido'] = $id_contenido;
} elseif (isset($_SESSION['ID_Contenido'])) {
    $id_contenido = $_SESSION['ID_Contenido'];
} else {
    die("Error: No se especificó el libro al que pertenece el capítulo.");
}

$mensaje = "";

if (isset($_POST['guardar_capitulo'])) {
    $titulo = $_POST['titulo_capitulo'];
    $contenido = $_POST['contenido_capitulo'];
    $numero_capitulo = $_POST['numero_capitulo'];
    $fecha_publicacion = date("Y-m-d");

    $sql = "INSERT INTO capitulos (titulo_capitulo, contenido, numero_capitulo, ID_Contenido)
            VALUES ('$titulo', '$contenido', '$numero_capitulo', '$id_contenido')";

    if (mysqli_query($conexion, $sql)) {
        $mensaje = "<p style='color:lightgreen; text-align:center;'>✅ Capítulo guardado correctamente.</p>";
    } else {
        $mensaje = "<p style='color:red; text-align:center;'>❌ Error al guardar el capítulo: " . mysqli_error($conexion) . "</p>";
    }
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tintero</title>
    <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="./css/Crear_Capitulo.css">
    <!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

<!-- jQuery (requerido por Summernote) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

<script>
  $(document).ready(function() {
    $('#contenido_capitulo').summernote({
      placeholder: 'Escribe el contenido de tu capítulo aquí...',
      tabsize: 2,
      height: 300
    });
  });
</script>

</head>
<body>

    <h1>Crear un nuevo capítulo</h1>

    <?= $mensaje ?>

    <form method="POST" action="">
        <div>
            <label for="titulo_capitulo">Título del capítulo:</label><br>
            <input type="text" id="titulo_capitulo" name="titulo_capitulo" required>
        </div>
        <br>
        <div>
            <label for="numero_capitulo">Número del capítulo:</label><br>
            <input type="number" id="numero_capitulo" name="numero_capitulo" required>
        </div>
        <br>
        <div>
            <label for="contenido_capitulo">Contenido del capítulo:</label><br>
            <textarea id="contenido_capitulo" name="contenido_capitulo" rows="15" required></textarea>
        </div>
        <br>
        <input type="submit" name="guardar_capitulo" value="Guardar Capítulo">
        <a href="menuSuscrito.php"><button type="button" id="boton_cancelar">Cancelar</button></a>
    </form>

</body>
</html>
