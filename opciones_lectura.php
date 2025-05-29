<?php
session_start();

if (!isset($_GET['id'])) {
    echo "No se especificó el libro.";
    exit();
}

$id_contenido = intval($_GET['id']);

// Conectar a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tintero");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener datos del libro
$sql = "SELECT Titulo, Descripcion, portada FROM libro WHERE ID_Contenido = $id_contenido";
$resultado = mysqli_query($conexion, $sql);
$libro = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Opciones de Lectura</title>
    <style>
        body {
            background-color: #2a1f36;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        .tarjeta {
            background-color: #3a2d4d;
            padding: 30px;
            border-radius: 10px;
            display: inline-block;
        }
        .tarjeta img {
            width: 200px;
            height: auto;
            border-radius: 10px;
        }
        .botones {
            margin-top: 20px;
        }
        .btn {
            padding: 10px 15px;
            margin: 5px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="tarjeta">
    <h2><?= htmlspecialchars($libro['Titulo']) ?></h2>
    <img src="./img_portada/<?= htmlspecialchars($libro['portada']) ?>" alt="Portada"><br><br>
    <p><?= nl2br(htmlspecialchars($libro['Descripcion'])) ?></p>

    <div class="botones">
        <a class="btn" href="leer_libro.php?id=<?= $id_contenido ?>">Leer historia</a>
        <a class="btn" href="ver_capitulos.php?id=<?= $id_contenido ?>">Ver capítulos</a>
        <a class="btn" href="mis_favoritos.php?id_contenido=<?= $id_contenido ?>">Añadir a favoritos ❤️</a>
        <a class="btn" href="menuSuscrito.php">Volver</a>
    </div>
</div>

</body>
</html>
