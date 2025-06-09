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
    <style>
        .footer {
            background-color: #2a1f36;
            color: white;
            padding: 30px 20px;
            font-family: Arial, sans-serif;
        }

        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            max-width: 1000px;
            margin: auto;
        }

        .footer h3, .footer h4 {
            color: #FFD764;
            margin-bottom: 10px;
        }

        .footer p, .footer a {
            color: #ccc;
            font-size: 14px;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .footer-center ul {
            list-style: none;
            padding: 0;
        }

        .footer-center ul li {
            margin: 6px 0;
        }

        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                text-align: center;
            }

            .footer-left, .footer-center, .footer-right {
                margin-bottom: 20px;
            }
        }

    </style>
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
    <footer class="footer">
            <div class="footer-container">
                <div class="footer-left">
                    <h3>Tintero</h3>
                    <p>Historias en cada gota</p>
                    <p>Donde nacen historias en cada gota de inspiración </p>
                    <h3>Redes sociales</h3>
                    <p>Instagram: @tintero_oficial</p>
                    <p>X: @tintero_oficial</p>
                    <p>Tiktok: @tintero_oficial</p>
                    <p>Facebook: @tintero_oficial</p>
                </div>

                <div class="footer-center">
                    <h4>Enlaces</h4>
                    <ul>
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="categorias.php">Categorías</a></li>
                        <li><a href="perfil.php">Mi Perfil</a></li>
                        <li><a href="login.php">Iniciar Sesión</a></li>
                    </ul>
                </div>

                <div class="footer-right">
                    <h4>Contacto</h4>
                    <p>Email: soporte@tintero.com</p>
                    <p>&copy; <?= date("Y") ?> Tintero. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
</html>
