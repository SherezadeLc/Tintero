<?php

session_start(); // Inicia la sesión para acceder a variables como id_usuario
// Redirige al login si el usuario no está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tintero");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Recupera el ID del usuario desde la sesión
$id_usuario = $_SESSION['id_usuario'];
$mensaje = ""; // Inicializa un mensaje vacío para mostrar notificaciones
// Verifica si el usuario ha entrado al modo edición o cambio de contraseña
$modo_edicion = isset($_GET['editar']) && $_GET['editar'] == '1';
$cambiando_pass = isset($_GET['cambiar_pass']) && $_GET['cambiar_pass'] == '1';

// ---------------- ACTUALIZACIÓN DE DATOS BÁSICOS ----------------
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['actualizar_datos'])) {
    // Escapa caracteres especiales para evitar inyecciones SQL
    $nuevo_nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $nuevo_correo = mysqli_real_escape_string($conexion, $_POST['correo_electronico']);

    // Consulta para actualizar los datos del usuario
    $sql_update = "UPDATE usuario SET nombre = '$nuevo_nombre', correo_electronico = '$nuevo_correo' WHERE id_usuario = $id_usuario";

    // Ejecuta la actualización y guarda un mensaje de confirmación o error
    if (mysqli_query($conexion, $sql_update)) {
        $mensaje = "¡Datos actualizados correctamente!";
    } else {
        $mensaje = "Error al actualizar: " . mysqli_error($conexion);
    }

    // Redirige al perfil con el mensaje como parámetro GET
    header("Location: perfil.php?mensaje=" . urlencode($mensaje));
    exit();
}

// ---------------- CAMBIO DE CONTRASEÑA ----------------
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['cambiar_password'])) {
    // Escapa los datos del formulario
    $actual = mysqli_real_escape_string($conexion, $_POST['password_actual']);
    $nueva = mysqli_real_escape_string($conexion, $_POST['nueva_password']);
    $confirmacion = mysqli_real_escape_string($conexion, $_POST['confirmar_password']);

    // Obtiene la contraseña actual desde la base de datos
    $sql_pass = "SELECT contraseña FROM usuario WHERE id_usuario = $id_usuario";
    $res_pass = mysqli_query($conexion, $sql_pass);
    $datos = mysqli_fetch_assoc($res_pass);

    // Verifica que la contraseña actual sea correcta
    if (!password_verify($actual, $datos['contraseña'])) {
        $mensaje = "La contraseña actual es incorrecta.";

        // Verifica que la nueva contraseña coincida con su confirmación
    } elseif ($nueva !== $confirmacion) {
        $mensaje = "Las contraseñas nuevas no coinciden.";

        // Si todo es correcto, actualiza la contraseña en la base de datos
    } else {
        $nueva_hash = password_hash($nueva, PASSWORD_DEFAULT); // Hashea la nueva contraseña
        $update_pass = "UPDATE usuario SET contraseña = '$nueva_hash' WHERE id_usuario = $id_usuario";

        if (mysqli_query($conexion, $update_pass)) {
            $mensaje = "¡Contraseña actualizada correctamente!";
        } else {
            $mensaje = "Error al actualizar contraseña.";
        }
    }

    // Redirige al perfil con el mensaje
    header("Location: perfil.php?mensaje=" . urlencode($mensaje));
    exit();
}

// ---------------- OBTENER DATOS DEL USUARIO PARA MOSTRAR ----------------
$sql = "SELECT nombre, correo_electronico, tipo_usuario, fecha_registro FROM usuario WHERE id_usuario = $id_usuario";
$resultado = mysqli_query($conexion, $sql);
$usuario = mysqli_fetch_assoc($resultado); // Almacena los datos en un array asociativo

mysqli_close($conexion); // Cierra la conexión
// Si hay un mensaje en la URL, lo guarda para mostrarlo
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}
?>
