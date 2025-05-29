<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$conexion = mysqli_connect("localhost", "root", "", "tintero");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$sql = "SELECT lv.ID_Contenido, lv.Titulo, lv.portada
        FROM lista_favoritos lf
        JOIN libro lv ON lf.id_contenido = lv.ID_Contenido
        WHERE lf.id_usuario = $id_usuario";

$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Favoritos | Tintero</title>
    <link rel="stylesheet" href="./css/Registro_Login.css">
    <style>
        .contenedor {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
        }
        .libro {
            display: inline-block;
            width: 180px;
            margin: 10px;
            text-align: center;
        }
        .libro img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
        }
        .titulo {
            color: white;
            margin-top: 10px;
        }
        .btn-eliminar {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
        }
        .btn-eliminar:hover {
            background-color: #bb2d3b;
        }
        .btn-volver {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            margin: 30px auto 0;
        }
        .btn-volver:hover {
            background-color: #0056b3;
        }
        .volver-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <h2 style="color:white; text-align:center;">Mis Favoritos</h2>

        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <?php while ($libro = mysqli_fetch_assoc($resultado)): ?>
                <div class="libro">
                    <a href="opciones_lectura.php?id=<?= $libro['ID_Contenido'] ?>">
                        <img src="./img_portada/<?= htmlspecialchars($libro['portada']) ?>" alt="Portada">
                        <div class="titulo"><?= htmlspecialchars($libro['Titulo']) ?></div>
                    </a>
                    <form method="POST" action="eliminar_favoritos.php">
                        <input type="hidden" name="id_contenido" value="<?= $libro['ID_Contenido'] ?>">
                        <button type="submit" class="btn-eliminar">Eliminar de Favoritos</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="color:white; text-align:center;">No tienes libros en favoritos.</p>
        <?php endif; ?>
    </div>

    <div class="volver-container">
        <a href="menuSuscrito.php" class="btn-volver">Volver al Menú</a>
    </div>
</body>
</html>

<?php mysqli_close($conexion); ?>
