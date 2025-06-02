<?php
    session_start();

    // Verifica que el usuario esté autenticado y tenga su plan cargado
    if (!isset($_SESSION['id_usuario']) || !isset($_SESSION["Nombre_plan"])) 
    {
        die("Acceso no autorizado.");
    }

    $plan = $_SESSION["Nombre_plan"];
    $id_usuario = $_SESSION['id_usuario'];

    if (!isset($_GET['id_capitulo'])) 
    {
        die("Capítulo no especificado.");
    }

    $id_capitulo = $_GET['id_capitulo'];

    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "tintero");
    if (!$conexion) 
    {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Obtener los datos del capítulo y su libro asociado
    $sql = "SELECT c.*, l.Titulo AS titulo_libro
            FROM capitulos c
            JOIN libro l ON c.ID_Contenido = l.ID_Contenido
            WHERE c.id_capitulo = $id_capitulo";

    $resultado = mysqli_query($conexion, $sql);
    $capitulo = mysqli_fetch_assoc($resultado);

    if (!$capitulo) 
    {
        die("Capítulo no encontrado.");
    }

    // Verificar si el usuario con plan básico puede acceder
    if ($plan === 'Plan_Basico' ) 
    {
        die("<h2 style='color:red; text-align:center;'>Este capítulo no está disponible para tu plan de suscripción.</h2>");
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Leer Capítulo</title>
    <link rel="stylesheet" href="./css/Registro_Login.css">
    <style>
        body {
            background-color: #2a1f36;
            color: white;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .contenedor {
            max-width: 800px;
            margin: auto;
            background: #3a2d4d;
            padding: 30px;
            border-radius: 10px;
        }
        h1, h2 {
            text-align: center;
            color: #FFD764;
        }
        .contenido {
            margin-top: 20px;
            white-space: pre-wrap;
            line-height: 1.6;
        }
        .btn-volver {
            display: block;
            margin: 30px auto 0;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-volver:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="contenedor">
    <h1><?= htmlspecialchars($capitulo['titulo_libro']) ?></h1>
    <h2>Capítulo <?= $capitulo['numero_capitulo'] ?>: <?= htmlspecialchars($capitulo['titulo_capitulo']) ?></h2>

    <div class="contenido">
        <?= nl2br(htmlspecialchars($capitulo['contenido'])) ?>
    </div>

    <a class="btn-volver" href="ver_capitulos.php?id=<?= $capitulo['ID_Contenido'] ?>">← Volver a capítulos</a>
</div>

</body>
</html>
