<?php
     // Inicia la sesión para acceder a variables de usuario
    session_start();

    // Si se ha enviado el formulario con el botón "guardar_historia"
    if (isset($_POST['guardar_historia'])) 
    {
         // Conexión a la base de datos
        $conexion = mysqli_connect("localhost", "root", "", "tintero");
        // Validar si hubo error al conectar
        if ($conexion->connect_error) 
        {
            die('Error de conexión: ' . $conexion->connect_error);
        }
        
        // Recoger los datos enviados desde el formulario
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $id_categoria = $_POST['categoria'];
        $fechaActual = date("Y-m-d");

        // Manejo de la imagen de portada
        $nombreImagen = '';
        if (isset($_FILES['imagen_portada']) && $_FILES['imagen_portada']['error'] === UPLOAD_ERR_OK) 
        {
            // Archivo temporal
            $nombreTemporal = $_FILES['imagen_portada']['tmp_name'];
            // Nombre original del archivo
            $nombreOriginal = basename($_FILES['imagen_portada']['name']);
            // Carpeta de destino
            $carpetaDestino = 'img_portada/';

            // Crear la carpeta si no existe
            if (!file_exists($carpetaDestino)) 
            {
                mkdir($carpetaDestino, 0777, true);
            }

            // Renombrar la imagen con un ID único para evitar conflictos
            $nombreImagen = uniqid() . '_' . $nombreOriginal;
            $rutaDestino = $carpetaDestino . $nombreImagen;

            // Mover el archivo cargado al destino final
            if (!move_uploaded_file($nombreTemporal, $rutaDestino)) 
            {
                die('Error al mover la imagen.');
            }
        }

        // ID del autor desde la sesión
        $id_usuario = $_SESSION['id_usuario'];

        // Insertar los datos de la historia en la base de datos
        $sql = "INSERT INTO libro (Titulo, Descripcion, ID_Autor, portada, id_categoria, Fecha_Publicacion,Estado) 
        VALUES ('$titulo', '$descripcion','$id_usuario', '$nombreImagen', '$id_categoria', '$fechaActual','Borrador')";

        // Ejecutar la consulta
        if (mysqli_query($conexion, $sql)) 
        {
            // Obtener el ID insertado
            $id_universo = mysqli_insert_id($conexion);
            $consulta_id_contenido = "SELECT ID_Contenido FROM libro WHERE Titulo = '$titulo'";
            $consulta_id_contenidos = mysqli_query($conexion, $consulta_id_contenido) or die("Fallo en la consulta de seleccionar el id contenido");

            $_SESSION['ID_Contenido'] = $consulta_id_contenidos;
            // Redirigir a la creación de capítulos con el ID de la historia creada
            header('Location: crearCapitulo.php?ID_Contenido=' . $id_universo);
            exit();
        } else 
        {
            die('Error al guardar: ' . mysqli_error($conexion));
        }

        $conexion->close();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero</title>
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <link rel="stylesheet" type="text/css" href="./css/crea_Universos.css">
        <script src="./javascript/script.js"></script>
    </head>
    <body>
        <section id="agregar_historia">
            <h1 id="titulo_pagina">Agregar información de la historia</h1><br>

            <div id="contenedor_historia">
                <form id="formulario_historia" method="POST" action="" enctype="multipart/form-data">

                    <!-- Subida de portada -->
                    <div id="portada_historia">
                        <label for="imagen_portada">Subir portada:</label>
                        <input type="file" id="imagen_portada" name="imagen_portada" accept="image/*" required>
                    </div>

                    <!-- Campo de título -->
                    <div class="campo_formulario">
                        <label for="titulo">Título</label>
                        <input type="text" id="titulo" name="titulo" required>
                    </div>

                    <!-- Campo de descripción -->
                    <div class="campo_formulario">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="5" required></textarea>
                    </div>

                    <div class="campo_formulario">
                        <label for="categoria">Categoría</label>
                        <select id="categoria" name="categoria" required>
                            <option value="">Selecciona una categoría</option>
                            <?php
                            // Conexión a la base de datos para cargar las categorías
                            $conexion = mysqli_connect("localhost", "root", "", "tintero");

                            if (!$conexion->connect_error) 
                            {
                                $resultado = $conexion->query("SELECT ID_Categoria, Nombre FROM categoria");

                                while ($fila = $resultado->fetch_assoc()) 
                                {
                                    echo '<option value="' . $fila['ID_Categoria'] . '">' . htmlspecialchars($fila['Nombre']) . '</option>';
                                }
                                $resultado->free();
                                $conexion->close();
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Campo de etiquetas (texto libre separado por comas) -->
                    <div class="campo_formulario">
                        <label for="etiquetas">Etiquetas</label>
                        <input type="text" id="etiquetas" name="etiquetas" placeholder="Agrega etiquetas separadas por coma">
                    </div>

                    <!-- Clasificación de la historia -->
                    <div class="campo_formulario">
                        <label for="clasificacion">Clasificación</label>
                        <select id="clasificacion" name="clasificacion">
                            <option value="normal">Normal</option>
                            <option value="madura">Madura</option>
                        </select>
                    </div>

                    <!-- Botones para guardar o cancelar -->
                    <div id="botones_formulario">
                        <button type="submit" name="guardar_historia" id="boton_guardar">Guardar</button>
                        <a href="menuSuscrito.php"><button type="button" id="boton_cancelar">Cancelar</button></a>
                    </div>

                </form>
            </div>
        </section>
    </body>
</html>
