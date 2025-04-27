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

if (isset($_POST['guardar_capitulo'])) {
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo_capitulo']);
    $contenido = mysqli_real_escape_string($conexion, $_POST['contenido_capitulo']);
    $id_usuario = $_SESSION['id_usuario'];
    $fecha_publicacion = date("Y-m-d");

    $sql = "INSERT INTO capitulos (titulo, contenido, id_usuario, fecha_publicacion)
            VALUES ('$titulo', '$contenido', '$id_usuario', '$fecha_publicacion')";

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
    <title>Tintero</title>
    <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
    <style>
        body {
            background-color: #121212; /* Fondo oscuro */
            color: white; /* Texto en blanco */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255,255,255,0.2);
            width: 90%;
            max-width: 600px;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background-color: #2c2c2c;
            color: white;
            resize: none;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        label {
            font-size: 16px;
        }
    </style>
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
