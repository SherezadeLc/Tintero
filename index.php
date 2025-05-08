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
    ?>
    <body>
        <!-- CONTENEDOR DE LUCES (luciérnagas). -->
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
                    <a href="login.php">Iniciar sesión/Registrarse</a>
                </div>
            </div>


        </header> 

        <div class="contenedor-h2">
            <h2 class="colorear">Novedades</h2>
        </div>

        <section id="Novedades" class="contenedor-carrusel">
            <div class="carrusel">
                <?php foreach ($libros as $libro): ?>
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                <img src="<?php echo $libro['src']; ?>" alt="<?php echo $libro['alt']; ?>" />
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </body>
</html>
