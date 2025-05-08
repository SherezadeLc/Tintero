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
        <!--CSS para los brillos del fondo-->
        <link rel="stylesheet" type="text/css" href="./css/fondo_estrellas.css">
        <script src="./javascript/script.js"></script>
    </head>
    <?php
    $conexion = mysqli_connect("localhost", "root", "", "tintero");
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    $consulta = "SELECT Titulo FROM libro_video WHERE Tipo = 'Libro' AND Estado = 'Publicado'";
    $resultado = mysqli_query($conexion, $consulta);

    $libros = [];

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $libros[] = [
                "src" => "./img_portada/" . $fila["Titulo"] . ".jpeg",
                "alt" => "Portada de " . $fila["Titulo"]
            ];
        }
    }
    $sql = "SELECT ID_Contenido, Titulo, portada FROM libro_video";
    $resultado = mysqli_query($conexion, $sql);
    // Obtener la fecha actual y la fecha de hace un mes
    $fechaActual = date('Y-m-d');
    $fechaHaceUnMes = date('Y-m-d', strtotime('-1 month'));

    // Consulta para obtener libros publicados en el último mes
    $consultaFecha = "SELECT Titulo, portada, ID_Contenido FROM libro_video 
    WHERE Tipo = 'Libro' AND Estado = 'Publicado'AND fecha_publicacion >= '$fechaHaceUnMes'";

// Ejecutar la consulta
    $resultado = mysqli_query($conexion, $consultaFecha);

    $libros = [];
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $libros[] = [
                "src" => "./img_portada/" . $fila["portada"],
                "alt" => "Portada de " . $fila["Titulo"],
                "id" => $fila["ID_Contenido"]
            ];
        }
    }
    ?>
    <body>
        <!-- CONTENEDOR DE LUCES (luciérnagas) -->
        <div id="estrellas">
            <div class="firefly"></div>
            <div class="firefly"></div>
            <div class="firefly"></div>
            <div class="firefly"></div>
            <div class="firefly"></div>
            <div class="firefly"></div>
            <div class="firefly"></div>
            <div class="firefly"></div>
            <div class="firefly"></div>
            <div class="firefly"></div>
        </div>
        <header>
            <div class="contenedor-logo">
                <img src="./img/FondoTintero.png" class="logo">
            </div>
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
            </div>


        </header> 

        <div class="contenedor-h2">
            <h2 class="colorear">Novedades</h2>
        </div>

        <section id="Novedades" class="contenedor-carrusel">
            <button class="flecha" id="izquierda">&#10094;</button>
            <div class="carrusel">
                <?php foreach ($libros as $libro): ?>
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                <a href="detalle_historia.php?id=<?php echo $libro['id']; ?>">
                                    <img src="<?php echo $libro['src']; ?>" alt="<?php echo $libro['alt']; ?>" />
                                </a>
                            </div>
                            <div class="flip-card-back">
                                <div class='titulo-historia'><?php echo htmlspecialchars($libro['alt']); ?> </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="flecha"id="derecha">&#10095;</button>
        </section>

        <div class="contenedor-h2">
            <h2 class="colorear">Recomendaciones</h2>
        </div>

        <section id="Recomendaciones" class="contenedor-carrusel">
            <button class="flecha"id="izquierda">&#10094;</button>
            <div class="carrusel">
                <?php
                // Asegúrate de que el puntero se reinicie si $resultado ya fue usado antes
                if ($resultado && mysqli_num_rows($resultado) > 0) {
                    mysqli_data_seek($resultado, 0);
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<div class='flip-card'>";
                        echo "  <div class='flip-card-inner'>";
                        echo "      <div class='flip-card-front'>";
                        echo "          <a href='detalle_historia.php?id=" . $fila['ID_Contenido'] . "'>";
                        echo "              <img src='./img_portada/" . htmlspecialchars($fila['portada']) . "' alt='Portada'>";
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
            <button class="flecha"id="derecha"id="izquierda">&#10095;</button>
        </section>



    </body>
</html>
