<?php
session_start(); // Inicia o reanuda la sesión del usuario

// Verifica que el usuario esté autenticado y que se haya proporcionado un ID de contenido por GET
if (!isset($_SESSION['id_usuario']) || !isset($_GET['id_contenido'])) {
    header("Location: login.php"); // Redirige a la página de login si no está autenticado o no hay ID
    exit(); // Termina la ejecución del script
}

// Obtiene el ID del usuario desde la sesión y el ID del contenido desde la URL
$id_usuario = $_SESSION['id_usuario'];
$id_contenido = $_GET['id_contenido'];
$fecha = date("Y-m-d"); // Fecha actual (opcionalmente se puede usar para registrar el favorito)

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tintero");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error()); // Muestra error si falla la conexión
}

// Consulta para verificar si ese libro ya está en favoritos del usuario
$verificar = "SELECT * FROM lista_favoritos WHERE id_usuario = $id_usuario AND id_contenido = $id_contenido";
$resultado = mysqli_query($conexion, $verificar);

// Si no existe el registro en favoritos, lo insertamos
if (mysqli_num_rows($resultado) === 0) {
    $insertar = "INSERT INTO lista_favoritos (id_usuario, id_contenido) 
                 VALUES ($id_usuario, $id_contenido)";

    // Ejecuta el insert y verifica si fue exitoso
    if (mysqli_query($conexion, $insertar)) {
        // Muestra alerta de éxito y redirige a la página de favoritos
        echo "<script>alert('✅ Agregado a favoritos.'); window.location.href = 'mis_favoritos.php';</script>";
    } else {
        // Muestra alerta de error si falla el insert y vuelve atrás
        echo "<script>alert('❌ Error al agregar a favoritos. En el insert'); window.history.back();</script>";
    }
} else {
    // Si ya estaba en la lista de favoritos, se muestra una alerta informativa
    echo "<script>alert('ℹ️ Este libro ya está en tu lista de favoritos.'); window.history.back();</script>";
}

// Cierra la conexión con la base de datos
mysqli_close($conexion);
?>
