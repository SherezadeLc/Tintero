<!DOCTYPE html>
<?php
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
    </head>
    <?php
// Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "tintero");
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

// Fechas para novedades
    $fechaActual = date('Y-m-d');
    $fechaHaceUnMes = date('Y-m-d', strtotime('-1 month'));

// Consulta de novedades (último mes)
    $consultaFecha = "SELECT Titulo, portada, ID_Contenido FROM libro_video 
    WHERE Tipo = 'Libro' AND Estado = 'Publicado' AND fecha_publicacion >= '$fechaHaceUnMes'";
    $resultado_novedades = mysqli_query($conexion, $consultaFecha);

// Consulta de recomendaciones
    $sql = "SELECT ID_Contenido, Titulo, portada FROM libro_video 
    WHERE Tipo = 'Libro' AND Estado = 'Publicado'";
    $resultado_recomendaciones = mysqli_query($conexion, $sql);
    ?>
    <body>

        <!-- Fondo de estrellas -->
        <div id="estrellas">
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div>
        </div>

        <header>
            <div class="contenedor-logo">
                <img src="./img/FondoTintero.png" class="logo">
            </div><br>
            <div class="contenedor-h2">
            <div class="contenedor-nav">
                <!-- Buscador -->
                <div class="nav-left">
                    <form method="get" class="buscador">
                        <input type="text" id="input-buscar" name="buscar" placeholder="Buscar" />
                        <input id="boton-buscar" type="submit" value="Buscar" />
                    </form>
                </div>
                <!-- Enlaces -->
                <nav class="nav-center">
                    <ul>
                        <li><a href="#">Categorías</a></li>
                        <li><a href="#">Biblioteca</a></li>
                        <li><a href="#">Perfil</a></li>
                        <li><a href="creaUniveros.php">Crea un nuevo universo</a></li>
                        <li><a href="misUniversos.php">Mis universos</a></li>
                        <li><a href="menu_planes_suscripciones.php">Planes suscripción</a></li>
                    </ul>
                </nav>
                <!-- Login -->
                <div class="nav-right">
                    <a href="logout.php">Cerrar Sesión</a>
                </div>
            </div></div>

        </header><br>

        <!-- NOVEDADES -->

        <h2 class="colorear">Novedades</h2>

        <div class="contenedor-h2">
            <section id="Novedades" class="contenedor-carrusel">
                <button class="flecha" id="izquierda">&#10094;</button>
                <div class="carrusel">
                    <?php
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
                    }
                    ?>
                </div>
                <button class="flecha" id="derecha">&#10095;</button>
            </section>
        </div><br>

        <!-- RECOMENDACIONES -->

        <h2 class="colorear">Recomendaciones</h2>

        <div class="contenedor-h2">
            <section id="Recomendaciones" class="contenedor-carrusel">
                <button class="flecha" id="izquierda">&#10094;</button>
                <div class="carrusel">
                    <?php
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
                    }
                    ?>
                </div>
                <button class="flecha" id="derecha">&#10095;</button>
            </section>
        </div>
    </body>
</html>
