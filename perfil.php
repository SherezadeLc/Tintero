<?php
session_start();

// Verificar que el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tintero");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener datos del usuario
$id_usuario = $_SESSION['id_usuario'];
$sql = "SELECT nombre, correo_electronico, tipo_usuario, fecha_registro FROM usuario WHERE id_usuario = $id_usuario";
$resultado = mysqli_query($conexion, $sql);
$usuario = mysqli_fetch_assoc($resultado);

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil - Tintero</title>
    <link rel="stylesheet" href="./css/Registro_Login.css">
    <style>
        body {
            background-color: #2a1f36;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        .perfil {
            background-color: #3a2d4d;
            padding: 30px;
            border-radius: 10px;
            display: inline-block;
            text-align: left;
        }
        h2 {
            color: #ffd969;
        }
        .btn {
            padding: 10px 20px;
            background-color: #28a745;
            border: none;
            color: white;
            border-radius: 5px;
            margin-top: 20px;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="perfil">
        <h2>Mi Perfil</h2>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></p>
        <p><strong>Correo electrónico:</strong> <?= htmlspecialchars($usuario['correo_electronico']) ?></p>
        <p><strong>Tipo de usuario:</strong> <?= htmlspecialchars($usuario['tipo_usuario']) ?></p>
        <p><strong>Fecha de registro:</strong> <?= htmlspecialchars($usuario['fecha_registro']) ?></p>
        <a class="btn" href="menuSuscrito.php">Volver al menú</a>
    </div>

</body>
</html>
