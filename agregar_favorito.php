<?php
    session_start();

    if (!isset($_SESSION['id_usuario']) || !isset($_GET['id_contenido'])) 
    {
        header("Location: login.php");
        exit();
    }

    $id_usuario = $_SESSION['id_usuario'];
    $id_contenido = intval($_GET['id_contenido']);

    $conexion = mysqli_connect("localhost", "root", "", "tintero");

    $verificar = "SELECT * FROM lista_favoritos WHERE id_usuario = $id_usuario AND id_contenido = $id_contenido";
    $resultado = mysqli_query($conexion, $verificar);

    if (mysqli_num_rows($resultado) === 0) 
    {
        $insertar = "INSERT INTO lista_favoritos (id_usuario, id_contenido) VALUES ($id_usuario, $id_contenido)";
        mysqli_query($conexion, $insertar);
        header("Location: mis_favoritos.php");
            exit();
    }

    mysqli_close($conexion);
    //header("Location: detalle_historia.php?id=$id_contenido"); // Redirige de nuevo
    exit();
?>
