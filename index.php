<!DOCTYPE html>
<?php
// Inicia la sesión para poder utilizar variables de sesión si fuera necesario
session_start();
?>
<html lang="es">
    <head>
        <!-- Metadatos básicos -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero</title>

        <!-- Icono de la pestaña -->
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">

        <!-- Hojas de estilo -->
        <link rel="stylesheet" type="text/css" href="./css/estilo.css">
        <link rel="stylesheet" type="text/css" href="./css/fondo_estrellas.css">

        <!-- Archivo JavaScript externo -->
        <script src="./javascript/script.js"></script>

        <style>
            /* ======== Estilos para el carrusel de libros ======== */
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

            .flecha.izquierda { left: 0; }
            .flecha.derecha { right: 0; }
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


            /* ======== Estilos responsive y menú hamburguesa ======== */
            .menu-toggle {
                display: none;
                font-size: 30px;
                color: white;
                cursor: pointer;
                z-index: 1001;
                margin-bottom: 10px;
            }

            @media (max-width: 768px) {
                .menu-toggle {
                    display: block;
                }

                .contenedor-nav {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 15px;
                }

                .nav-left, .nav-center, .nav-right {
                    width: 100%;
                }

                .nav-center ul {
                    flex-direction: column;
                    gap: 10px;
                    padding: 0;
                    margin: 0;
                }

                .nav-center li a, .nav-right a {
                    display: block;
                    width: 100%;
                    padding: 10px 0;
                }

                .buscador {
                    flex-direction: column;
                    gap: 10px;
                    width: 100%;
                }

                #input-buscar, #boton-buscar {
                    width: 100%;
                }

                .menu {
                    display: none;
                    flex-direction: column;
                    width: 100%;
                    background-color: #2a1b30;
                    padding: 10px 20px;
                    border-radius: 10px;
                }

                .menu.abierto {
                    display: flex;
                }
            }
        </style>
    </head>

    <?php
        // Conexión con la base de datos MySQL
        $conexion = mysqli_connect("localhost", "root", "", "tintero");

        // Verifica si la conexión ha fallado
        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Se destruye cualquier sesión activa (puede utilizarse como cierre automático)
        session_destroy();

        // Fecha actual y hace un mes para filtrar novedades
        $fechaActual = date('Y-m-d');
        $fechaHaceUnMes = date('Y-m-d', strtotime('-1 month'));

        // Consulta SQL para obtener libros publicados recientemente
        $consultaFecha = "SELECT libro.Titulo, libro.portada, libro.ID_Contenido, CONCAT(usuario.Nombre, ' ', usuario.Apellido) AS Autor
                          FROM libro
                          JOIN usuario ON libro.ID_Autor = usuario.ID_Usuario
                          WHERE libro.Estado = 'Publicado' 
                          AND libro.Fecha_Publicacion BETWEEN '$fechaHaceUnMes' AND '$fechaActual'";

        // Ejecuta la consulta
        $resultado_novedades = mysqli_query($conexion, $consultaFecha);
    ?>

    <body>

        <!-- Fondo animado con estrellas -->
        <div id="estrellas">
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div>
        </div>

        <!-- Cabecera del sitio -->
        <header>
            <div class="contenedor-logo">
                <img src="./img/FondoTintero.png" class="logo">
            </div><br>

            <div class="contenedor-h2">
                <!-- Icono del menú hamburguesa -->
                <div class="menu-toggle" id="menu-toggle">&#9776;</div>

                <!-- Navegación del sitio -->
                <div class="contenedor-nav menu" id="menu">
                    <!-- Formulario de búsqueda -->
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

                    <!-- Enlace para iniciar sesión -->
                    <div class="nav-right">
                        <a href="login.php">Iniciar sesión/Registrarse</a>
                    </div>
                </div>
            </div>
        </header><br>

        <!-- Sección de novedades con carrusel de libros -->
        <h2 class="colorear">Novedades</h2>
        <div class="contenedor-h2">
            <section class="contenedor-carrusel">
                <!-- Botón para deslizar a la izquierda -->
                <button class="flecha izquierda" onclick="document.querySelector('#carrusel-novedades').scrollBy({left: -300, behavior: 'smooth'});">&#10094;</button>

                <!-- Contenedor de tarjetas con libros -->
                <div class="carrusel" id="carrusel-novedades">
                    <?php
                    // Verifica si hay resultados y los muestra
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

                <!-- Botón para deslizar a la derecha -->
                <button class="flecha derecha" onclick="document.querySelector('#carrusel-novedades').scrollBy({left: 300, behavior: 'smooth'});">&#10095;</button>
            </section>
        </div><br>

        <!-- Script para abrir/cerrar el menú hamburguesa en móvil -->
        <script>
            const toggle = document.getElementById('menu-toggle');
            const menu = document.getElementById('menu');
            toggle.addEventListener('click', () => {
                menu.classList.toggle('abierto');
            });
        </script>
    </body>
    <footer class="footer">
            <div class="footer-container">
                <div class="footer-left">
                    <h3>Tintero</h3>
                    <p>Historias en cada gota</p>
                    <p>Donde nacen historias en cada gota de inspiración </p>
                    <h3>Redes sociales</h3>
                    <p>Instagram: @tintero_oficial</p>
                    <p>X: @tintero_oficial</p>
                    <p>Tiktok: @tintero_oficial</p>
                    <p>Facebook: @tintero_oficial</p>
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
