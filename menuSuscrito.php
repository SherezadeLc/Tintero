<!DOCTYPE html>
<?php
    // Inicia la sesión para poder usar variables de sesión
    session_start();
?>
<html lang="es">
    <head>
        <!-- Metadatos y recursos externos -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero</title>
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <link rel="stylesheet" type="text/css" href="./css/estilo.css">
        <link rel="stylesheet" type="text/css" href="./css/fondo_estrellas.css">
        <script src="./javascript/script.js"></script>
        <!-- Estilos internos para el carrusel -->
        <style>
            .contenedor-carrusel {
                position: relative;
                display: flex;
                align-items: center;
                overflow: hidden;
                padding: 10px 40px;
            }

            .carrusel {
                display: flex;
                gap: 20px;
                overflow-x: auto;
                scroll-behavior: smooth;
            }

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
    <?php
        // Conexión a la base de datos
        $conexion = mysqli_connect("localhost", "root", "", "tintero");
        // Verifica si hubo error en la conexión
        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Fechas para filtrar las novedades (último mes)
        $fechaActual = date('Y-m-d');
        $fechaHaceUnMes = date('Y-m-d', strtotime('-1 month'));

        // Consulta para obtener libros publicados en el último mes
        $consultaFecha = "SELECT Titulo, portada, ID_Contenido FROM libro 
            WHERE Estado = 'Publicado' 
            AND Fecha_Publicacion BETWEEN '$fechaHaceUnMes' AND '$fechaActual'";
        $resultado_novedades = mysqli_query($conexion, $consultaFecha);

        // Consulta para obtener 10 libros aleatorios publicados
        $sql = "SELECT ID_Contenido, Titulo, portada FROM libro 
            WHERE Estado = 'Publicado' 
            ORDER BY RAND() LIMIT 10";
        $resultado_recomendaciones = mysqli_query($conexion, $sql);
    ?>
    <body>

        <!-- Fondo animado de estrellas -->
        <div id="estrellas">
            <?php for ($i = 0; $i < 10; $i++)
                echo '<div class="firefly"></div>';
            ?>
        </div>
        <!-- Encabezado del sitio -->
        <header>
            <div class="contenedor-logo">
                <img src="./img/FondoTintero.png" class="logo">
            </div><br>
            <!-- Barra de navegación -->
            <div class="contenedor-h2">
                <div class="contenedor-nav">
                    <div class="nav-left">
                        <!-- Formulario de búsqueda -->
                        <form method="get" action="Buscar.php" class="buscador">
                            <input type="text" id="input-buscar" name="buscar" placeholder="Buscar por título o autor" />
                            <input id="boton-buscar" type="submit" value="Buscar" />
                        </form>
                    </div>
                    <!-- Enlaces de navegación principales -->
                    <nav class="nav-center">
                        <ul>
                            <li><a href="categorias.php">Categorías</a></li>
                            <li><a href="mis_favoritos.php">Biblioteca</a></li>

                            <li><a href="creaUniveros.php">Crea un nuevo universo</a></li>
                            <li><a href="misUniversos.php">Mis universos</a></li>
                            <li><a href="menu_planes_suscripciones.php">Planes suscripción</a></li>
                        </ul>
                    </nav>
                    <!-- Enlace para cerrar sesión -->
                    <div class="nav-right">
                        <a href="perfil.php">Perfil</a>
                        <a href="logout.php">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </header><br>

        <!-- Sección de novedades -->
        <h2 class="colorear">Novedades</h2>
        <div class="contenedor-h2">
            <section class="contenedor-carrusel">
                <!-- Flecha izquierda para mover el carrusel -->
                <button class="flecha izquierda" onclick="document.querySelector('#carrusel-novedades').scrollBy({left: -300, behavior: 'smooth'});">&#10094;</button>
                <!-- Carrusel de libros recientes -->
                <div class="carrusel" id="carrusel-novedades">
                    <?php
                    // Si hay resultados, mostrar cada libro
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
                        // Mensaje si no hay novedades
                        echo "<p style='color:white;'>No hay novedades recientes.</p>";
                    }
                    ?>
                </div>
                <!-- Flecha derecha para mover el carrusel -->
                <button class="flecha derecha" onclick="document.querySelector('#carrusel-novedades').scrollBy({left: 300, behavior: 'smooth'});">&#10095;</button>
            </section>
        </div><br>

        <!-- Sección de recomendaciones -->
        <h2 class="colorear">Recomendaciones</h2>
        <div class="contenedor-h2">
            <section class="contenedor-carrusel">
                <!-- Flecha izquierda -->
                <button class="flecha izquierda" onclick="document.querySelector('#carrusel-recomendaciones').scrollBy({left: -300, behavior: 'smooth'});">&#10094;</button>
                <!-- Carrusel de libros recomendados -->
                <div class="carrusel" id="carrusel-recomendaciones">
                    <?php
                    // Mostrar libros recomendados aleatorios
                    if ($resultado_recomendaciones && mysqli_num_rows($resultado_recomendaciones) > 0) {
                        while ($fila = mysqli_fetch_assoc($resultado_recomendaciones)) {
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
                        // Mensaje si no hay recomendaciones
                        echo "<p style='color:white;'>No hay recomendaciones disponibles.</p>";
                    }
                    ?>
                </div>
                <!-- Flecha derecha -->
                <button class="flecha derecha" onclick="document.querySelector('#carrusel-recomendaciones').scrollBy({left: 300, behavior: 'smooth'});">&#10095;</button>
            </section>
        </div>

    </body>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-left">
                <h3>Tintero</h3>
                <p>Historias en cada gota</p>
                <p>Donde nacen historias en cada gota de inspiración </p>
                <h3>Redes sociales</h3>
                <p>Instagram: </p>
            </div>

            <div class="footer-center">
                <h4>Enlaces</h4>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="categorias.php">Categorías</a></li>
                    <li><a href="perfil.php">Mi Perfil</a></li>
                    <li><a href="login.php">Iniciar Sesión</a></li>
                </ul>
            </div>

            <div class="footer-right">
                <h4>Contacto</h4>
                <p>Email: soporte@tintero.com</p>
                <p>&copy; <?= date("Y") ?> Tintero. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

</html>
