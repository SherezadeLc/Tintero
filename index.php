<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tintero</title>
    <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
    <link rel="stylesheet" type="text/css" href="./css/estilo.css">
    <script src="./javascript/script.js"></script>
</head>
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
            <?php
            // Array de imágenes y títulos
            $libros = [
                ["src" => "./img_portada/El Ascenso de un Imperio.jpeg", "alt" => "Portada de El Ascenso de un Imperio"],
                ["src" => "./img_portada/El circo de la noche.jpg", "alt" => "Portada de El Circo de la Noche"],
                ["src" => "./img_portada/El Laberinto de los Susurros.jpeg", "alt" => "Portada de El Laberinto de los Susurros"],
                ["src" => "./img_portada/Hestia.jpeg", "alt" => "Portada de Hestia"],
                ["src" => "./img_portada/La Revelación.jpeg", "alt" => "Portada de La Revelación"],
                ["src" => "./img_portada/Las mil y una noches.jpeg", "alt" => "Portada de Las mil y una noches"],
                ["src" => "./img_portada/Los Juicios de Salem.jpeg", "alt" => "Portada de Los Juicios de Salem"],
                ["src" => "./img_portada/Reyes caídos.jpeg", "alt" => "Portada de Reyes caídos"],
                ["src" => "./img_portada/Todas las hadas del reino.jpeg", "alt" => "Portada de Todas las hadas del reino"],
                ["src" => "./img_portada/Utopia.jpeg", "alt" => "Portada de Utopia"],
            ];

            // Generar las tarjetas de los libros
            foreach ($libros as $libro) {
                echo '<div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                <img class="diapositiva" src="' . $libro['src'] . '" alt="' . $libro['alt'] . '" />
                            </div>
                            <div class="flip-card-back">
                                <!-- Contenido adicional en el reverso de la tarjeta -->
                            </div>
                        </div>
                    </div>';
            }
            ?>
        </div>
    </section>
    
    <div class="contenedor-h2">
        <h2 class="colorear">Recomendaciones</h2>
    </div>
</body>
</html>
