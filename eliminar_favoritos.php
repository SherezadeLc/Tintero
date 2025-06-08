<?php
    // Inicia o reanuda la sesión
    session_start();

    // Verifica si el usuario ha iniciado sesión, si no, lo redirige al login
    if (!isset($_SESSION['id_usuario'])) 
    {
        header("Location: login.php");
        // Verifica si el usuario ha iniciado sesión, si no, lo redirige al login
        exit();
    }

    // Verifica que la petición sea POST y que se haya enviado el ID del contenido a eliminar
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_contenido'])) 
    {
        // Recupera el ID del usuario desde la sesión
        $id_usuario = $_SESSION['id_usuario'];
         // Convierte el valor recibido del formulario a un número entero para evitar inyecciones SQL
        $id_contenido = intval($_POST['id_contenido']);

          // Conecta a la base de datos
        $conexion = mysqli_connect("localhost", "root", "", "tintero");

        // Si falla la conexión, se muestra un error y se detiene el script
        if (!$conexion) 
        {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Ejecuta la consulta SQL para eliminar el libro de la lista de favoritos del usuario actual
        $sql = "DELETE FROM lista_favoritos WHERE id_usuario = $id_usuario AND id_contenido = $id_contenido";
       // Ejecuta la consulta
        mysqli_query($conexion, $sql);
        // Cierra la conexión con la base de datos
        mysqli_close($conexion);
    }

    // Redirige al usuario de nuevo a la página de favoritos
    header("Location: mis_favoritos.php");
    exit();
?>