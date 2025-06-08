<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION["nombre_usuario"] !== 'admin') {
    die("Acceso denegado.");
}

$conexion = mysqli_connect("localhost", "root", "", "tintero");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tintero</title>
    <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
    <link rel="stylesheet" type="text/css" href="./css/Admin_panel.css">
    <link rel="stylesheet" type="text/css" href="./css/fondo_estrellas.css">
    <script src="./javascript/script.js"></script>
</head>
<body>
    <h1>Bienvenido Administrador</h1>

    <!-- Usuarios -->
    <h2>Gestión de Usuarios</h2>
    <table border="1">
        <tr><th>ID</th><th>Nombre</th><th>Estado</th><th>Acción</th></tr>
        <?php
        $res = mysqli_query($conexion, "SELECT id_usuario, nombre, estado FROM usuario");
        while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>
                    <td>{$row['id_usuario']}</td>
                    <td>{$row['nombre']}</td>
                    <td>{$row['estado']}</td>
                    <td>
                        <form method='post'>
                            <input type='hidden' name='id_usuario' value='{$row['id_usuario']}'>
                            <button type='submit' name='suspender'>Suspender</button>
                            <button type='submit' name='activar'>Activar</button>
                        </form>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <!-- Contenido Reportado -->
<h2 style="margin-top: 40px;">Contenido Reportado</h2>

<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
    <thead style="background-color: #4b3a6b; color: white;">
        <tr>
            <th>ID Contenido</th>
            <th>Título</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $res = mysqli_query($conexion, "SELECT ID_Contenido, Titulo FROM libro WHERE reportado = 1");

        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                echo "<tr>
                        <td>{$row['ID_Contenido']}</td>
                        <td>" . htmlspecialchars($row['Titulo']) . "</td>
                        <td>
                            <form method='post' style='display:inline;'>
                                <input type='hidden' name='id_contenido' value='{$row['ID_Contenido']}'>
                                <button type='submit' name='eliminar' onclick=\"return confirm('¿Seguro que quieres eliminar este contenido?')\">❌ Eliminar</button>
                            </form>

                            <form method='get' action='ver_capitulos.php' style='display:inline;'>
                                <input type='hidden' name='id' value='{$row['ID_Contenido']}'>
                                <button type='submit'>📖 Ver Capítulos</button>
                            </form>

                            <form method='post' style='display:inline;'>
                                <input type='hidden' name='id_contenido' value='{$row['ID_Contenido']}'>
                                <button type='submit' name='marcar_revisado'>✅ Marcar como Revisado</button>
                            </form>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No hay contenido reportado actualmente.</td></tr>";
        }
        ?>
    </tbody>
</table>


    <!-- Promociones y suscripciones -->
    <h2>Administrar Suscripciones</h2>
    <a href="menu_planes_suscripciones.php">Ir a planes de suscripción</a>

</body>
</html>

<?php
// Acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['suspender'])) {
        $id = $_POST['id_usuario'];
        mysqli_query($conexion, "UPDATE usuario SET estado = 'suspendido' WHERE id_usuario = $id");
    }

    if (isset($_POST['activar'])) {
        $id = $_POST['id_usuario'];
        mysqli_query($conexion, "UPDATE usuario SET estado = 'activo' WHERE id_usuario = $id");
    }

    if (isset($_POST['eliminar'])) {
        $id = $_POST['id_contenido'];
        mysqli_query($conexion, "DELETE FROM libro WHERE ID_Contenido = $id");
    }
    if (isset($_POST['marcar_revisado'])) {
        $id = $_POST['id_contenido'];
        mysqli_query($conexion, "UPDATE libro SET reportado = 0 WHERE ID_Contenido = $id");
    }

    header("Location: admin_panel.php");
    exit;
}
?>
