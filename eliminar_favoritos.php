<?php
    session_start();

    if (!isset($_SESSION['id_usuario'])) 
    {
        header("Location: login.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_contenido'])) 
    {
        $id_usuario = $_SESSION['id_usuario'];
        $id_contenido = intval($_POST['id_contenido']);

        $conexion = mysqli_connect("localhost", "root", "", "tintero");

        if (!$conexion) 
        {
            die("Error de conexión: " . mysqli_connect_error());
        }

        $sql = "DELETE FROM lista_favoritos WHERE id_usuario = $id_usuario AND id_contenido = $id_contenido";
        mysqli_query($conexion, $sql);

        mysqli_close($conexion);
    }

    header("Location: mis_favoritos.php");
    exit();
?>