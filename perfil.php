<?php  
session_start(); // Inicia la sesión o la reanuda

// Si el usuario no ha iniciado sesión, lo redirige al login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

// Conexión con la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tintero");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error()); // En caso de fallo, muestra error
}

// Guarda el ID del usuario actual desde la sesión
$id_usuario = $_SESSION['id_usuario'];
$mensaje = ""; // Mensaje que se mostrará al usuario (éxito o error)

// Detecta si se ha activado el modo edición (editar datos)
$modo_edicion = isset($_GET['editar']) && $_GET['editar'] == '1';

// Detecta si se ha activado el modo cambiar contraseña
$cambiando_pass = isset($_GET['cambiar_pass']) && $_GET['cambiar_pass'] == '1';

// ---------------- ACTUALIZACIÓN DE NOMBRE Y CORREO ----------------
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['actualizar_datos'])) {
    // Escapa los datos recibidos por seguridad
    $nuevo_nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $nuevo_correo = mysqli_real_escape_string($conexion, $_POST['correo_electronico']);

    // Query para actualizar el nombre y correo
    $sql_update = "UPDATE usuario SET nombre = '$nuevo_nombre', correo_electronico = '$nuevo_correo' WHERE id_usuario = $id_usuario";

    // Ejecuta la query y muestra el mensaje correspondiente
    if (mysqli_query($conexion, $sql_update)) {
        $mensaje = "¡Datos actualizados correctamente!";
    } else {
        $mensaje = "Error al actualizar: " . mysqli_error($conexion);
    }

    // Redirige para evitar reenvío del formulario
    header("Location: perfil.php?mensaje=" . urlencode($mensaje));
    exit();
}

// ---------------- CAMBIO DE CONTRASEÑA ----------------
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['cambiar_password'])) {
    // Escapa y guarda los campos del formulario
    $actual = mysqli_real_escape_string($conexion, $_POST['password_actual']);
    $nueva = mysqli_real_escape_string($conexion, $_POST['nueva_password']);
    $confirmacion = mysqli_real_escape_string($conexion, $_POST['confirmar_password']);

    // Obtiene la contraseña actual del usuario desde la BD
    $sql_pass = "SELECT contraseña FROM usuario WHERE id_usuario = $id_usuario";
    $res_pass = mysqli_query($conexion, $sql_pass);
    $datos = mysqli_fetch_assoc($res_pass);

    // Verifica que la contraseña actual introducida sea correcta
    if (!password_verify($actual, $datos['contraseña'])) {
        $mensaje = "La contraseña actual es incorrecta.";
    } elseif ($nueva !== $confirmacion) {
        $mensaje = "Las contraseñas nuevas no coinciden.";
    } else {
        // Encripta la nueva contraseña
        $nueva_hash = password_hash($nueva, PASSWORD_DEFAULT);

        // Actualiza la contraseña en la base de datos
        $update_pass = "UPDATE usuario SET contraseña = '$nueva_hash' WHERE id_usuario = $id_usuario";

        if (mysqli_query($conexion, $update_pass)) {
            $mensaje = "¡Contraseña actualizada correctamente!";
        } else {
            $mensaje = "Error al actualizar contraseña.";
        }
    }

    // Redirige con el mensaje
    header("Location: perfil.php?mensaje=" . urlencode($mensaje));
    exit();
}

// ---------------- OBTENER DATOS DEL USUARIO ----------------
// Consulta los datos del usuario logueado
$sql = "SELECT nombre, correo_electronico, tipo_usuario, fecha_registro FROM usuario WHERE id_usuario = $id_usuario";
$resultado = mysqli_query($conexion, $sql);
$usuario = mysqli_fetch_assoc($resultado);

// Cierra la conexión con la base de datos
mysqli_close($conexion);

// Si hay mensaje enviado por GET, lo almacena
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}
?>

<!-- ---------------- HTML ---------------- -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil - Tintero</title>
    <link rel="stylesheet" href="./css/Perfil.css"> <!-- Enlaza el CSS -->
    <script>
        // Al cargar la página, añade la clase 'loaded' al body (para animación)
        window.addEventListener('load', () => {
            document.body.classList.add('loaded');
        });
    </script>
</head>
<body>

<div class="perfil">
    <h2>Mi Perfil</h2>

    <!-- Muestra mensaje de éxito o error -->
    <?php if ($mensaje): ?>
        <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <!-- FORMULARIO DE EDICIÓN DE DATOS -->
    <?php if ($modo_edicion): ?>
        <form method="post">
            <input type="hidden" name="actualizar_datos" value="1">

            <label for="nombre"><strong>Nombre:</strong></label>
            <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>

            <label for="correo"><strong>Correo electrónico:</strong></label>
            <input type="email" name="correo_electronico" id="correo" value="<?= htmlspecialchars($usuario['correo_electronico']) ?>" required>

            <p><strong>Tipo de usuario:</strong> <?= htmlspecialchars($usuario['tipo_usuario']) ?></p>
            <p><strong>Fecha de registro:</strong> <?= htmlspecialchars($usuario['fecha_registro']) ?></p>

            <button type="submit">Guardar cambios</button>
            <a class="btn cancelar" href="perfil.php">Cancelar</a>
        </form>

    <!-- FORMULARIO DE CAMBIO DE CONTRASEÑA -->
    <?php elseif ($cambiando_pass): ?>
        <form method="post">
            <input type="hidden" name="cambiar_password" value="1">

            <label for="password_actual"><strong>Contraseña actual:</strong></label>
            <input type="password" name="password_actual" id="password_actual" required>

            <label for="nueva_password"><strong>Nueva contraseña:</strong></label>
            <input type="password" name="nueva_password" id="nueva_password" required>

            <label for="confirmar_password"><strong>Confirmar nueva contraseña:</strong></label>
            <input type="password" name="confirmar_password" id="confirmar_password" required>

            <button type="submit">Cambiar contraseña</button>
            <a class="btn cancelar" href="perfil.php">Cancelar</a>
        </form>

    <!-- VISTA NORMAL DEL PERFIL (sin edición ni cambio de contraseña) -->
    <?php else: ?>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></p>
        <p><strong>Correo electrónico:</strong> <?= htmlspecialchars($usuario['correo_electronico']) ?></p>
        <p><strong>Tipo de usuario:</strong> <?= htmlspecialchars($usuario['tipo_usuario']) ?></p>
        <p><strong>Fecha de registro:</strong> <?= htmlspecialchars($usuario['fecha_registro']) ?></p>

        <!-- Botones para editar o cambiar contraseña -->
        <a class="btn" href="perfil.php?editar=1">Editar información</a>
        <a class="btn" href="perfil.php?cambiar_pass=1">Cambiar contraseña</a>
        <a class="btn" href="menuSuscrito.php">Volver al menú</a>
    <?php endif; ?>
</div>

</body>
</html>
