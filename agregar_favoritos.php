<?php
session_start();

// Verifica que el usuario esté logueado y que se haya enviado un ID de contenido
if (!isset($_SESSION['id_usuario']) || !isset($_GET['id_contenido'])) {
    header("Location: login.php");
    exit();
}

// Obtener datos del usuario y contenido
$id_usuario = $_SESSION['id_usuario'];
$id_contenido = $_GET['id_contenido'];
$fecha = date("Y-m-d");

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tintero");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verifica si ya está en favoritos
$verificar = "SELECT * FROM lista_favoritos WHERE id_usuario = $id_usuario AND id_contenido = $id_contenido";
$resultado = mysqli_query($conexion, $verificar);

// Si no está, se inserta
if (mysqli_num_rows($resultado) === 0) {
    $insertar = "INSERT INTO lista_favoritos (id_usuario, id_contenido) 
                 VALUES ($id_usuario, $id_contenido)";

    if (mysqli_query($conexion, $insertar)) {
        echo "<script>alert('✅ Agregado a favoritos.'); window.location.href = 'mis_favoritos.php';</script>";
    } else {
        echo "<script>alert('❌ Error al agregar a favoritos. En el insert'); window.history.back();</script>";
    }
} else {
    // Si ya existe, muestra aviso
    echo "<script>alert('ℹ️ Este libro ya está en tu lista de favoritos.'); window.history.back();</script>";
}

// Cierra la conexión
mysqli_close($conexion);
?>
