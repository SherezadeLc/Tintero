<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

// Verificación de sesión
if (!isset($_SESSION["id_usuario"]) || !isset($_SESSION["Nombre_Plan"])) {
    die("Acceso denegado. Debes estar logueado.");
}

$conexion = mysqli_connect("localhost", "root", "", "tintero");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$id_contenido = intval($_GET['id'] ?? 0);
$mensaje = "";

// Procesar botón de reporte
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reportar'])) {
    $query = "UPDATE libro SET reportado = 1 WHERE ID_Contenido = $id_contenido";
    if (mysqli_query($conexion, $query)) {
        $mensaje = "📌 El contenido ha sido reportado correctamente.";
    } else {
        $mensaje = "❌ Error al reportar el contenido.";
    }
}

// Obtener datos del libro
$sql = "SELECT Titulo, Descripcion, portada FROM libro WHERE ID_Contenido = $id_contenido";
$resultado = mysqli_query($conexion, $sql);
$libro = mysqli_fetch_assoc($resultado);

if (!$libro) {
    die("Libro no encontrado.");
}
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
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #218838;
        }
        .btn-reportar {
            background-color: #dc3545;
        }
        .btn-reportar:hover {
            background-color: #c82333;
        }
        .mensaje {
            margin-top: 15px;
            font-weight: bold;
            color: #ffd369;
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
        <a class="btn" href="agregar_favoritos.php?id_contenido=<?= $id_contenido ?>">Agregar a favoritos ❤</a>
        <a class="btn" href="menuSuscrito.php">Volver</a>

        <!-- Botón para reportar -->
        <form method="post" style="display:inline;">
            <button class="btn btn-reportar" name="reportar" onclick="return confirm('¿Seguro que deseas reportar este contenido como inapropiado?')">
                🚩 Reportar contenido
            </button>
        </form>
    </div>

    <?php if ($mensaje): ?>
        <div class="mensaje"><?= $mensaje ?></div>
    <?php endif; ?>
</div>

</body>
</html>
