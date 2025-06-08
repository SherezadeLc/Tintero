<?php
    // Inicia la sesión
    session_start();

    // Verifica si el usuario ha iniciado sesión
    if (!isset($_SESSION["id_usuario"])) 
        {
        // Si no está logueado, lo redirige al login
        header("Location: login.php");
        // Finaliza la ejecución
        exit();
    }

    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "tintero");
    if (!$conexion) 
        {
        // Error si falla la conexión
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Verifica si el ID del contenido (libro) viene por GET o ya está en sesión
    if (isset($_GET['id'])) 
        {
        // Guarda el ID del libro en sesión
        $id_contenido = intval($_GET['id']);
        $_SESSION['ID_Contenido'] = $id_contenido;
    } elseif (isset($_SESSION['ID_Contenido'])) 
        {
        // Recupera el ID desde la sesión si ya fue establecido
        $id_contenido = $_SESSION['ID_Contenido'];
    } else {
         // Si no hay ID, error
        die("Error: No se especificó el libro al que pertenece el capítulo.");
    }

    // Variable para mostrar mensajes al usuario
    $mensaje = "";

    // Si se ha enviado el formulario para guardar capítulo
    if (isset($_POST['guardar_capitulo'])) 
        {
        // Escapa caracteres para evitar inyecciones SQL
        $titulo = mysqli_real_escape_string($conexion, $_POST['titulo_capitulo']);
        $contenido = mysqli_real_escape_string($conexion, $_POST['contenido_capitulo']);
        $numero_capitulo = intval($_POST['numero_capitulo']);
        // Asegura que sea numérico
        $id_contenido = intval($id_contenido);
        // Fecha actual
        $fecha_publicacion = date("Y-m-d");

        // Verifica que todos los campos estén presentes
        if ($titulo && $contenido && $numero_capitulo && $id_contenido) 
            {
            // Inserta el capítulo en la base de datos
            $sql = "INSERT INTO capitulos (titulo_capitulo, contenido, numero_capitulo, ID_Contenido)
                    VALUES ('$titulo', '$contenido', '$numero_capitulo', '$id_contenido')";

            if (mysqli_query($conexion, $sql)) 
                    {
                $mensaje = "<p style='color:lightgreen; text-align:center;'>✅ Capítulo guardado correctamente.</p>";
            } else 
                {
                $mensaje = "<p style='color:red; text-align:center;'>❌ Error SQL: " . mysqli_error($conexion) . "</p>";
            }
        } else 
            {
            $mensaje = "<p style='color:red; text-align:center;'>❌ Faltan campos obligatorios.</p>";
        }
    }


     // Cierra la conexión con la base de datos
    mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero - Crear Capítulo</title>
         <!-- Favicon -->
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon">
        <!-- Estilos -->
        <link rel="stylesheet" type="text/css" href="./css/Crear_Capitulo.css">
        <!-- Editor de texto enriquecido (CKEditor) -->
        <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
        <script>
            window.onload = function () {
                 // Aplica CKEditor al área de texto del contenido del capítulo
                CKEDITOR.replace('contenido_capitulo', {
                    height: 300,
                    uiColor: '#34214d'
                });
            };
        </script>
        <style>
            /* Estilo de los botones */
            form input[type="submit"], form button{
                background-color: #6a3f8b;
                color: white;
                border: none;
                padding: 12px 20px;
                border-radius: 10px;
                cursor: pointer;
                font-weight: bold;
                transition: background-color 0.3s ease;
            }

            form input[type="submit"]:hover, form button:hover{
                background-color: #110011;
            }
        </style>
    </head>
    <body>

        <h1>Crear un nuevo capítulo</h1>

        <!-- Mensaje del servidor (éxito o error) -->
        <?= $mensaje ?>

        <!-- Formulario para ingresar datos del capítulo -->
        <form method="POST" action="">
            <div>
                <label for="titulo_capitulo">Título del capítulo:</label><br>
                <input type="text" id="titulo_capitulo" name="titulo_capitulo" required>
            </div>
            <br>
            <div>
                <label for="numero_capitulo">Número del capítulo:</label><br>
                <input type="number" id="numero_capitulo" name="numero_capitulo" required>
            </div>
            <br>
            <div>
                <label for="contenido_capitulo">Contenido del capítulo:</label><br>
                <textarea id="contenido_capitulo" name="contenido_capitulo" rows="15" required></textarea>
            </div>
            <br>
            <!-- Botón para guardar el capítulo -->
            <input type="submit" name="guardar_capitulo" value="Guardar Capítulo">
            <!-- Botón para volver atrás -->
            <button id="boton_cancelar" type="button" class="btn">Cancelar</button>
            <!-- Botón para salir al menú principal -->
            <a href="menuSuscrito.php"><button  type="button" class="btn">Salir</button></a>
        </form>
        <!-- Script para cancelar usando el botón "Cancelar" -->
        <script>
            document.getElementById("boton_cancelar").addEventListener("click", function () {
                // Retrocede a la página anterior
                history.back();
            });
        </script>
    </body>
</html>
