<?php
    // Inicia la sesión para acceder a variables de sesión
    session_start();
    // Verifica si el usuario ha iniciado sesión; si no, lo redirige al login
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php");
        exit();
    }
    // Obtiene el ID del usuario desde la sesión
    $id_usuario = $_SESSION['id_usuario'];
    // Establece conexión con la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "tintero");
    if (!$conexion) {
         // Si la conexión falla, muestra un mensaje de error
        die("Error de conexión: " . mysqli_connect_error());
    }
    
    // Consulta SQL para obtener los libros marcados como favoritos por el usuario
    $sql = "SELECT lv.ID_Contenido, lv.Titulo, lv.portada
            FROM lista_favoritos lf
            JOIN libro lv ON lf.id_contenido = lv.ID_Contenido
            WHERE lf.id_usuario = $id_usuario";

    // Ejecuta la consulta y guarda el resultado
    $resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mis Favoritos | Tintero</title>
         <!-- Enlaza hoja de estilos externa -->
        <link rel="stylesheet" href="./css/Registro_Login.css">
        <!-- Estilos adicionales para esta página -->
        <style>
            /* Estilo general del contenedor */
            .contenedor {
                max-width: 1000px;
                margin: auto;
                padding: 20px;
            }
            /* Tarjetas individuales de libros */
            .libro {
                display: inline-block;
                width: 180px;
                margin: 10px;
                text-align: center;
            }
             /* Imagen de portada del libro */
            .libro img {
                width: 100%;
                height: 250px;
                object-fit: cover;
                border-radius: 8px;
            }
             /* Estilo del título */
            .titulo {
                color: white;
                margin-top: 10px;
            }
            /* Botón para eliminar de favoritos */
            .btn-eliminar {
                background-color: #dc3545;
                color: white;
                border: none;
                padding: 6px 12px;
                border-radius: 5px;
                margin-top: 10px;
                cursor: pointer;
            }
            .btn-eliminar:hover {
                background-color: #bb2d3b;
            }
             /* Botón para volver al menú */
            .btn-volver {
                background-color: #007bff;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 6px;
                text-decoration: none;
                display: inline-block;
                margin: 30px auto 0;
            }
            .btn-volver:hover {
                background-color: #0056b3;
            }
            .volver-container {
                text-align: center;
            }
        </style>
        <style>
        .footer {
            background-color: #2a1f36;
            color: white;
            padding: 30px 20px;
            font-family: Arial, sans-serif;
        }

        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            max-width: 1000px;
            margin: auto;
        }

        .footer h3, .footer h4 {
            color: #FFD764;
            margin-bottom: 10px;
        }

        .footer p, .footer a {
            color: #ccc;
            font-size: 14px;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .footer-center ul {
            list-style: none;
            padding: 0;
        }

        .footer-center ul li {
            margin: 6px 0;
        }

        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                text-align: center;
            }

            .footer-left, .footer-center, .footer-right {
                margin-bottom: 20px;
            }
        }

    </style>
    </head>
    <body>
        <div class="contenedor">
            <h2 style="color:white; text-align:center;">Mis Favoritos</h2>

              <!-- Si hay libros en la lista de favoritos -->
            <?php if (mysqli_num_rows($resultado) > 0): ?>
               <!-- Itera sobre cada libro favorito -->
                <?php while ($libro = mysqli_fetch_assoc($resultado)): ?>
                    <div class="libro">
                        <!-- Enlace a la página de opciones de lectura del libro -->
                        <a href="opciones_lectura.php?id=<?= $libro['ID_Contenido'] ?>">
                            <!-- Imagen de portada del libro -->
                            <img src="./img_portada/<?= htmlspecialchars($libro['portada']) ?>" alt="Portada">
                            <!-- Título del libro -->
                            <div class="titulo"><?= htmlspecialchars($libro['Titulo']) ?></div>
                        </a>
                        <!-- Formulario para eliminar libro de favoritos -->
                        <form method="POST" action="eliminar_favoritos.php">
                            <input type="hidden" name="id_contenido" value="<?= $libro['ID_Contenido'] ?>">
                            <button type="submit" class="btn-eliminar">Eliminar de Favoritos</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
               <!-- Mensaje si no hay libros en favoritos -->
                <p style="color:white; text-align:center;">No tienes libros en favoritos.</p>
            <?php endif; ?>
        </div>

        <!-- Botón para volver al menú principal -->
        <div class="volver-container">
            <a href="menuSuscrito.php" class="btn-volver">Volver al Menú</a>
        </div>
    </body>
</html>

<?php 
    // Cierra la conexión con la base de datos
    mysqli_close($conexion); 
?>
