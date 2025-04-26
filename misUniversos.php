<?php
session_start();

// Verifica que haya sesión iniciada
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

$conexion = mysqli_connect("localhost", "root", "", "tintero");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// *** Aquí usa el nombre correcto de la columna ***
$sql = "SELECT ID_Contenido, Titulo, portada FROM libro_video WHERE ID_Autor = '$id_usuario'";
$resultado = mysqli_query($conexion, $sql);
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
    </head>
    <body>

        <h1>Mis Historias</h1>

        <div class="contenedor-historias">
            <?php
            if (mysqli_num_rows($resultado) > 0) {
                while ($historia = mysqli_fetch_assoc($resultado)) {
                    echo "<div class='tarjeta-historia'>";
                    echo "<img src='./portadas/" . htmlspecialchars($historia['portada']) . "' alt='Portada'>";
                    echo "<div class='titulo-historia'>" . htmlspecialchars($historia['Titulo']) . "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No has creado ninguna historia todavía.</p>";
            }

            mysqli_close($conexion);
            ?>
        </div>

    </body>
</html>
