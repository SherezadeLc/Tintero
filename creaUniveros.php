<!DOCTYPE html>
<?php
session_start();
?>
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

                    <div id="portada_historia">
                        <label for="imagen_portada">Subir portada:</label>
                        <input type="file" id="imagen_portada" name="imagen_portada" accept="image/*" required>
                    </div>

                    <div class="campo_formulario">
                        <label for="titulo">Título</label>
                        <input type="text" id="titulo" name="titulo" required>
                    </div>

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

                            if (!$conexion->connect_error) {
                                $resultado = $conexion->query("SELECT ID_Categoria, Nombre FROM categoria");

                                while ($fila = $resultado->fetch_assoc()) {
                                    echo '<option value="' . $fila['ID_Categoria'] . '">' . htmlspecialchars($fila['Nombre']) . '</option>';
                                }
                                $resultado->free();
                            }
                            ?>
                        </select>
                    </div>

                    <div class="campo_formulario">
                        <label for="etiquetas">Etiquetas</label>
                        <input type="text" id="etiquetas" name="etiquetas" placeholder="Agrega etiquetas separadas por coma">
                    </div>

                    <div class="campo_formulario">
                        <label for="clasificacion">Clasificación</label>
                        <select id="clasificacion" name="clasificacion">
                            <option value="normal">Normal</option>
                            <option value="madura">Madura</option>
                        </select>
                    </div>

                    <div id="botones_formulario">
                        <a href="misUniversos.php"><button type="submit" name="guardar_historia" id="boton_guardar">Guardar</button></a>
                        <button type="reset" id="boton_cancelar">Cancelar</button>
                    </div>

                </form>

            </div>
        </section>

        <?php
        if (isset($_POST['guardar_historia'])) {
            // Conexión a la base de datos
            $conexion = mysqli_connect("localhost", "root", "", "tintero");

            if ($conexion->connect_error) {
                die('Error de conexión: ' . $conexion->connect_error);
            }
            //aqui cogemos la informacion del libro que se esta creando
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $id_categoria = $_POST['categoria'];
            $fechaActual = date("Y-m-d");

            $nombreImagen = '';
            if (isset($_FILES['imagen_portada']) && $_FILES['imagen_portada']['error'] === UPLOAD_ERR_OK) {
                $nombreTemporal = $_FILES['imagen_portada']['tmp_name'];
                $nombreOriginal = basename($_FILES['imagen_portada']['name']);
                $carpetaDestino = 'img_portada/';

                if (!file_exists($carpetaDestino)) {
                    mkdir($carpetaDestino, 0777, true);
                }

                $nombreImagen = uniqid() . '_' . $nombreOriginal;
                $rutaDestino = $carpetaDestino . $nombreImagen;

                if (!move_uploaded_file($nombreTemporal, $rutaDestino)) {
                    die('Error al mover la imagen.');
                }
            }
            $id_usuario = $_SESSION['id_usuario'];
            $sql = "INSERT INTO libro_video (Titulo, Descripcion, ID_Autor, portada, id_categoria, Fecha_Publicacion) VALUES ('$titulo', '$descripcion','$id_usuario', '$nombreImagen', '$id_categoria',' $fechaActual')";

            if (mysqli_query($conexion, $sql)) {
                echo '<p>Historia guardada correctamente.</p>';
            } else {
                echo '<p>Error al guardar: ' . mysqli_error($conexion) . '</p>';
            }



            $conexion->close();
        }
        ?>
    </body>
</html>
