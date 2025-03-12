<!DOCTYPE html>
<?php
session_start(); // Inicia la sesión para almacenar datos de sesión como el rol del usuario
//Holi
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero</title>
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <link rel="stylesheet" type="text/css" href="./css/estilo.css">
        <script src="./javascript/script.js"></script>
    </head>
    <?php
    // Conectamos a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "tintero");

    // Verificamos si la conexión fue exitosa
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Consulta para obtener los libros publicados
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
        <?php
        // Aquí puedes agregar cualquier lógica PHP que necesites
        ?>
        <div>
            <header>
                <div class="contenedor-nav">
                    <div class="buscador">
                        <form method="get">
                            <fieldset>
                                <input type="text" id="input-buscar" name="buscar" placeholder="Buscar" />
                                <input id="boton-buscar" type="submit" value=" Buscar" />
                                <i class="icono-buscar"></i>
                            </fieldset>
                        </form>
                    </div>

                    <nav>
                        <div class="barra">
                            <ul>
                                <li><a href="#">Categorías</a></li>
                                <li><a href="#">Biblioteca</a></li>   
                                <li><a href="#">Perfil</a></li>
                                <li><a href="login.php">Iniciar sesión/Registrarse</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="contenedor-logo">
                    <img src="./img/fondomof.webp" class="logo">
                </div>
            </header>
        </div>
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

        <div class="contenedor-h2">
            <h2 class="colorear">Recomendaciones</h2>
        </div>
    </body>
</html>
