<?php
    // Inicia la sesión para acceder a las variables de sesión
    session_start();

    // Verifica que el usuario esté logueado (es decir, que exista el id en la sesión)
    if (!isset($_SESSION['id_usuario'])) {
        // Si no está logueado, lo redirige al login
        header("Location: login.php");
        exit();
    }

    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "tintero");
    // Verifica que la conexión sea exitosa
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Recupera el ID del usuario desde la sesión
    $id_usuario = $_SESSION['id_usuario'];
    // Consulta SQL para obtener la información del usuario
    $sql = "SELECT nombre, correo_electronico, tipo_usuario, fecha_registro FROM usuario WHERE id_usuario = $id_usuario";
    // Ejecuta la consulta en la base de datos
    $resultado = mysqli_query($conexion, $sql);
    // Obtiene los resultados en un array asociativo
    $usuario = mysqli_fetch_assoc($resultado);
    // Cierra la conexión con la base de datos
    mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mi Perfil - Tintero</title>
        <!-- Estilo CSS externo -->
        <link rel="stylesheet" href="./css/Registro_Login.css">
        <!-- Estilo CSS interno -->
        <style>
            body {
                background-color: #2a1f36;/* Fondo oscuro */
                color: white;
                font-family: Arial, sans-serif;
                text-align: center;
                padding: 50px;
            }
            .perfil {
                background-color: #3a2d4d;/* Fondo del cuadro de perfil */
                padding: 30px;
                border-radius: 10px;
                display: inline-block;
                text-align: left;
            }
            h2 {
                color: #ffd969;/* Color llamativo para el título */
            }
            .btn {
                padding: 10px 20px;
                background-color: #28a745;/* Verde */
                border: none;
                color: white;
                border-radius: 5px;
                margin-top: 20px;
                text-decoration: none;
                display: inline-block;
            }
            .btn:hover {
                background-color: #218838;/* Verde más oscuro al pasar el mouse */
            }
        </style>
    </head>
    <body>

        <!-- Contenedor con la información del perfil del usuario -->
        <div class="perfil">
            <h2>Mi Perfil</h2>
            <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></p>
            <p><strong>Correo electrónico:</strong> <?= htmlspecialchars($usuario['correo_electronico']) ?></p>
            <p><strong>Tipo de usuario:</strong> <?= htmlspecialchars($usuario['tipo_usuario']) ?></p>
            <p><strong>Fecha de registro:</strong> <?= htmlspecialchars($usuario['fecha_registro']) ?></p>
            <!-- Botón para volver al menú de usuario suscrito -->
            <a class="btn" href="menuSuscrito.php">Volver al menú</a>
        </div>

    </body>
</html>
