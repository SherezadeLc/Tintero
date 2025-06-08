<!DOCTYPE html>
<?php
// Inicia la sesión para poder acceder a las variables de sesión si existen
session_start();
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero</title>
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <link rel="stylesheet" type="text/css" href="./css/estilo.css">
        <link rel="stylesheet" type="text/css" href="./css/fondo_estrellas.css">
        <script src="./javascript/script.js"></script>
        <style>
            /* Estilo para el contenedor del carrusel */
            .contenedor-carrusel {
                position: relative;
                display: flex;
                align-items: center;
                overflow: hidden;
                padding: 10px 40px;
            }

            /* Carrusel de tarjetas */
            .carrusel {
                display: flex;
                gap: 20px;
                overflow-x: auto;
                scroll-behavior: smooth;
            }

            /* Botones de navegación del carrusel */
            .flecha {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                background-color: rgba(255, 255, 255, 0.1);
                border: none;
                color: white;
                font-size: 30px;
                cursor: pointer;
                padding: 10px;
                z-index: 1;
                border-radius: 50%;
                transition: background 0.3s;
            }

            .flecha:hover {
                background-color: rgba(255, 255, 255, 0.3);
            }

            .flecha.izquierda {
                left: 0;
            }

            .flecha.derecha {
                right: 0;
            }
        </style>
    </head>
    <?php
    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "tintero");
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Elimina cualquier sesión activa (posiblemente usado para cerrar sesión automáticamente)
    session_destroy();

    // Define el rango de fechas para obtener libros publicados en el último mes
    $fechaActual = date('Y-m-d');
    $fechaHaceUnMes = date('Y-m-d', strtotime('-1 month'));

   // Consulta para obtener libros publicados recientemente
    $consultaFecha = "SELECT libro.Titulo, libro.portada, libro.ID_Contenido, CONCAT(usuario.Nombre, ' ', usuario.Apellido) AS Autor
                  FROM libro
                  JOIN usuario ON libro.ID_Autor = usuario.ID_Usuario
                  WHERE libro.Estado = 'Publicado' 
                  AND libro.Fecha_Publicacion BETWEEN '$fechaHaceUnMes' AND '$fechaActual'";
    $resultado_novedades = mysqli_query($conexion, $consultaFecha);
    ?>
    <body>

        <!-- Fondo de estrellas -->
        <div id="estrellas">
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div>
        </div>

        <!-- Encabezado y navegación -->
        <header>
            <div class="contenedor-logo">
                <img src="./img/FondoTintero.png" class="logo">
            </div><br>
            <div class="contenedor-h2">
                <div class="contenedor-nav">
                    <!-- Buscador -->
                    <div class="nav-left">
                        <form method="get" action="Busqueda.php" class="buscador">
                            <input type="text" id="input-buscar" name="buscar" placeholder="Buscar por título o autor" />
                            <input id="boton-buscar" type="submit" value="Buscar" />
                        </form>
                    </div>
                    <!-- Enlaces de navegación -->
                    <nav class="nav-center">
                        <ul>
                            <li><a href="categorias.php">Categorías</a></li>
                            <li><a href="misUniversos.php">Biblioteca</a></li>
                            <li><a href="perfil.php">Perfil</a></li>
                        </ul>
                    </nav>
                     <!-- Acceso/Login -->
                    <div class="nav-right">
                        <a href="login.php">Iniciar sesión/Registrarse</a>
                    </div>
                </div>
            </div>
        </header><br>

        <!-- Sección de novedades (carrusel) -->
        <h2 class="colorear">Novedades</h2>
        <div class="contenedor-h2">
            <section class="contenedor-carrusel">
                <!-- Flecha izquierda para deslizar el carrusel -->
                <button class="flecha izquierda" onclick="document.querySelector('#carrusel-novedades').scrollBy({left: -300, behavior: 'smooth'});">&#10094;</button>
                <!-- Contenedor de las tarjetas de libros -->
                <div class="carrusel" id="carrusel-novedades">
                    <?php
                     // Verifica si hay resultados y los muestra en tarjetas
                    if ($resultado_novedades && mysqli_num_rows($resultado_novedades) > 0) {
                        while ($fila = mysqli_fetch_assoc($resultado_novedades)) {
                            echo "<div class='flip-card'>";
                            echo "  <div class='flip-card-inner'>";
                            echo "      <div class='flip-card-front'>";
                            echo "          <a href='detalle_historia.php?id=" . $fila['ID_Contenido'] . "'>";
                            echo "              <img src='./img_portada/" . htmlspecialchars($fila['portada']) . "' alt='Portada de " . htmlspecialchars($fila['Titulo']) . "'>";
                            echo "          </a>";
                            echo "      </div>";
                            echo "      <div class='flip-card-back'>";
                            echo "          <div class='titulo-historia'>" . htmlspecialchars($fila['Titulo']) . "</div>";
                            echo "      </div>";
                            echo "  </div>";
                            echo "</div>";
                        }
                    } else {
                        // Si no hay novedades recientes
                        echo "<p style='color:white;'>No hay novedades recientes.</p>";
                    }
                    ?>
                </div>
                <!-- Flecha derecha para deslizar el carrusel -->
                <button class="flecha derecha" onclick="document.querySelector('#carrusel-novedades').scrollBy({left: 300, behavior: 'smooth'});">&#10095;</button>
            </section>
        </div><br>

    </body>
</html>
