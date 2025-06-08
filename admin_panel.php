<?php
session_start();

// Verifica si el usuario está autenticado y es el administrador
if (!isset($_SESSION['id_usuario']) || $_SESSION["nombre_usuario"] !== 'admin') {
    die("Acceso denegado.");
}

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tintero");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Si el formulario fue enviado (POST), ejecutar las acciones según el botón presionado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Acción: Suspender usuario
    if (isset($_POST['suspender'])) {
        $id = $_POST['id_usuario'];
        mysqli_query($conexion, "UPDATE usuario SET estado = 'suspendido' WHERE id_usuario = $id");
    }
    // Acción: Activar usuario
    if (isset($_POST['activar'])) {
        $id = $_POST['id_usuario'];
        mysqli_query($conexion, "UPDATE usuario SET estado = 'activo' WHERE id_usuario = $id");
    }
    // Acción: Eliminar libro reportado
    if (isset($_POST['eliminar'])) {
        $id = $_POST['id_contenido'];
        mysqli_query($conexion, "DELETE FROM libro WHERE ID_Contenido = $id");
    }
    // Acción: Marcar como revisado un libro reportado (quitar estado de reporte)
    if (isset($_POST['marcar_revisado'])) {
        $id = $_POST['id_contenido'];
        mysqli_query($conexion, "UPDATE libro SET reportado = 0 WHERE ID_Contenido = $id");
    }

    // Redireccionar a sí mismo para evitar reenvíos de formulario
    header("Location: admin_panel.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
    <!-- A PARTIR DE AQUÍ EL HTML -->
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
        <!-- Encabezado -->
        <h1>Bienvenido Administrador</h1>

         <!-- Sección para gestionar usuarios -->
        <h2>Gestión de Usuarios</h2>
        <table border="1">
            <tr><th>ID</th><th>Nombre</th><th>Estado</th><th>Acción</th></tr>
            <?php
            // Obtener todos los usuarios registrados
            $res = mysqli_query($conexion, "SELECT id_usuario, nombre, estado FROM usuario");
            while ($row = mysqli_fetch_assoc($res)) {
                // Mostrar cada usuario con botones para suspender o activar
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

         <!-- Sección de contenido reportado -->
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
                // Buscar libros marcados como reportados
                $res = mysqli_query($conexion, "SELECT ID_Contenido, Titulo FROM libro WHERE reportado = 1");

                if (mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "<tr>
                            <td>{$row['ID_Contenido']}</td>
                            <td>" . htmlspecialchars($row['Titulo']) . "</td>
                            <td>
                            <!-- Eliminar contenido -->
                                <form method='post' style='display:inline;'>
                                    <input type='hidden' name='id_contenido' value='{$row['ID_Contenido']}'>
                                    <button type='submit' name='eliminar' onclick=\"return confirm('¿Seguro que quieres eliminar este contenido?')\">❌ Eliminar</button>
                                </form>
                                <!-- Ver capítulos -->
                                <form method='get' action='ver_capitulos.php' style='display:inline;'>
                                    <input type='hidden' name='id' value='{$row['ID_Contenido']}'>
                                    <button type='submit'>📖 Ver Capítulos</button>
                                </form>
                                <!-- Marcar como revisado -->
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
        <!-- Botón para cerrar sesión -->
        <form action="logout.php" method="POST" style="text-align: right; margin: 10px;">
            <button type="submit" style="padding: 8px 16px; background-color: #d9534f; color: white; border: none; border-radius: 5px;">Cerrar Sesión</button>
        </form>

    </body>
</html>
