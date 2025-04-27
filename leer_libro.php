<?php
session_start();

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tintero");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verificar que enviaron un ID de capítulo
if (!isset($_GET['id'])) {
    echo "Capítulo no encontrado.";
    exit();
}

$id_capitulo = intval($_GET['id']);

// Obtener el capítulo
$sql = "SELECT titulo, contenido, fecha_publicacion FROM capitulos WHERE id = $id_capitulo";
$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) == 0) {
    echo "Capítulo no encontrado.";
    exit();
}

$capitulo = mysqli_fetch_assoc($resultado);

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero</title>
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <link rel="stylesheet" type="text/css" href="./css/Registro_Login.css">
        <script src="./javascript/script.js"></script>
    
    <style>
        body {
            background-color: #121212;
            color: white;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
            min-height: 100vh;
            margin: 0;
        }

        .capitulo {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 10px;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 0 10px rgba(255,255,255,0.1);
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            text-align: center;
        }

        .contenido {
            font-size: 1.1em;
            line-height: 1.7;
            text-align: justify;
            white-space: pre-wrap; /* Para respetar saltos de línea */
        }

        .fecha {
            margin-top: 20px;
            font-size: 0.9em;
            color: gray;
            text-align: right;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            margin-top: 20px;
            display: block;
            text-align: center;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="capitulo">
        <h1><?php echo htmlspecialchars($capitulo['titulo']); ?></h1>

        <div class="contenido">
            <?php echo nl2br(htmlspecialchars($capitulo['contenido'])); ?>
        </div>

        <div class="fecha">
            Publicado el <?php echo htmlspecialchars($capitulo['fecha_publicacion']); ?>
        </div>
    </div>

    <a href="lista_capitulos.php">← Volver a la lista de capítulos</a>

</body>
</html>
