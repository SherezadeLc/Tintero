<?php
    // Inicia la sesión para manejar datos del usuario
    session_start();
    
    // Si no hay una sesión iniciada, redirige al usuario al login
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php");
        exit();
    }



    // Conexión a la base de datos MySQL
    $conexion = mysqli_connect("localhost", "root", "", "tintero");
    // Verifica si la conexión fue exitosa
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Obtiene el ID del contenido desde la URL, usa 0 como valor por defecto si no está presente
    $id_contenido = intval($_GET['id'] ?? 0);
    // Inicializa variable para mostrar mensajes al usuario
    $mensaje = "";

    // Si el usuario ha enviado el formulario de reporte
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reportar'])) {
        // Marca el contenido como reportado en la base de datos
        $query = "UPDATE libro SET reportado = 1 WHERE ID_Contenido = $id_contenido";
        if (mysqli_query($conexion, $query)) {
            $mensaje = "📌 El contenido ha sido reportado correctamente.";
        } else {
            $mensaje = "❌ Error al reportar el contenido.";
        }
    }

   // Consulta para obtener los datos del libro (título, descripción y portada)
    $sql = "SELECT Titulo, Descripcion, portada FROM libro WHERE ID_Contenido = $id_contenido";
    $resultado = mysqli_query($conexion, $sql);
    $libro = mysqli_fetch_assoc($resultado);

    // Si no se encuentra el libro, se detiene la ejecución
    if (!$libro) {
        die("Libro no encontrado.");
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Opciones de Lectura</title>
        <style>
            /* Estilo general del cuerpo */
            body {
                background-color: #2a1f36;
                color: white;
                font-family: Arial, sans-serif;
                text-align: center;
                padding: 50px;
            }
            /* Tarjeta contenedora del libro */
            .tarjeta {
                background-color: #3a2d4d;
                padding: 30px;
                border-radius: 10px;
                display: inline-block;
            }
             /* Imagen del libro */
            .tarjeta img {
                width: 200px;
                height: auto;
                border-radius: 10px;
            }
            /* Contenedor de botones */
            .botones {
                margin-top: 20px;
            }
            /* Botón genérico */
            .btn {
                padding: 10px 15px;
                margin: 5px;
                background-color: #28a745;
                color: white;
                text-decoration: none;
                border-radius: 6px;
                border: none;
                cursor: pointer;
            }
            .btn:hover {
                background-color: #218838;
            }
            /* Estilo para el botón de reportar */
            .btn-reportar {
                background-color: #dc3545;
            }
            .btn-reportar:hover {
                background-color: #c82333;
            }
            /* Estilo para mensajes */
            .mensaje {
                margin-top: 15px;
                font-weight: bold;
                color: #ffd369;
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
    <body>

        <!-- Tarjeta que muestra los detalles del libro -->
        <div class="tarjeta">
            <!-- Título del libro -->
            <h2><?= htmlspecialchars($libro['Titulo']) ?></h2>
             <!-- Imagen de portada -->
            <img src="./img_portada/<?= htmlspecialchars($libro['portada']) ?>" alt="Portada"><br><br>
            <!-- Descripción del libro con saltos de línea respetados -->
            <p><?= nl2br(htmlspecialchars($libro['Descripcion'])) ?></p>
            <!-- Botones de acción -->
            <div class="botones">
                <!-- Leer la historia completa -->
                <a class="btn" href="leer_libro.php?id=<?= $id_contenido ?>">Leer historia</a>
                 <!-- Ver capítulos del libro -->
                <a class="btn" href="ver_capitulos.php?id=<?= $id_contenido ?>">Ver capítulos</a>
                <!-- Agregar a favoritos -->
                <a class="btn" href="agregar_favoritos.php?id_contenido=<?= $id_contenido ?>">Agregar a favoritos ❤</a>
                <!-- Volver al menú principal -->
                <a class="btn" href="menuSuscrito.php">Volver</a>

                <!-- Botón para reportar -->
                <form method="post" style="display:inline;">
                    <button class="btn btn-reportar" name="reportar" onclick="return confirm('¿Seguro que deseas reportar este contenido como inapropiado?')">
                        🚩 Reportar contenido
                    </button>
                </form>
            </div>

            <!-- Muestra mensaje de éxito o error tras el reporte -->
            <?php if ($mensaje): ?>
                <div class="mensaje"><?= $mensaje ?></div>
            <?php endif; ?>
        </div>

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
