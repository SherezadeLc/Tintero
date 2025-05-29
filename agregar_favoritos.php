<?php

    session_start();

    if (!isset($_SESSION['id_usuario']) || !isset($_GET['id_contenido'])) 
    {
        header("Location: login.php");
        exit();
    }

    $id_usuario = $_SESSION['id_usuario'];
    $id_contenido = intval($_GET['id_contenido']);
    $fecha = date("Y-m-d");

    $conexion = mysqli_connect("localhost", "root", "", "tintero");
    if (!$conexion) 
    {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Verificar si ya está en favoritos
    $verificar = "SELECT * FROM lista_favoritos WHERE id_usuario = $id_usuario AND id_contenido = $id_contenido";
    $resultado = mysqli_query($conexion, $verificar);

    if (mysqli_num_rows($resultado) === 0) 
    {
        // Agregar si no está
        $insertar = "INSERT INTO lista_favoritos (id_usuario, id_contenido, fecha_agregado)
                     VALUES ($id_usuario, $id_contenido, '$fecha')";
        if (mysqli_query($conexion, $insertar)) 
        {
            echo "<script>alert('Agregado a favoritos.'); window.history.back();</script>";
        } else 
        {
            echo "<p style='color:red;'>Error al agregar a favoritos.</p>";
        }
    } else {
        echo "<script>alert('Este libro ya está en tu lista de favoritos.'); window.history.back();</script>";
    }

    mysqli_close($conexion);
?>
