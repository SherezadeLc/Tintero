<?php
    // Inicia la sesión para poder usar variables de sesión
    session_start();


    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php");
        exit();
    }

    // Obtiene el ID del usuario desde la sesión
    $id_usuario = $_SESSION['id_usuario'];
    // Establece conexión con la base de datos 
    $conexion = mysqli_connect("localhost", "root", "", "tintero");

    // Verifica si hubo un error de conexión
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Si se ha enviado el formulario para cambiar el estado de una historia
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_contenido'], $_POST['accion'])) {
        // Limpia los datos recibidos
        $id_contenido = intval($_POST['id_contenido']);
        $accion = $_POST['accion'];
         // Determina el nuevo estado basado en la acción del botón
        $estado = ($accion === 'publicar') ? 'Publicado' : 'Borrador';

        // Actualiza el estado de la historia en la base de datos solo si pertenece al autor actual
        $update = "UPDATE libro SET Estado = '$estado' WHERE ID_Contenido = $id_contenido AND ID_Autor = $id_usuario";
        mysqli_query($conexion, $update);
    }

    // Obtiene todas las historias del usuario actual
    $sql = "SELECT ID_Contenido, Titulo, portada, Estado FROM libro WHERE ID_Autor = '$id_usuario'";
    $resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mis Historias | Tintero</title>
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="./css/Registro_Login.css">
         <!-- Estilos internos para diseño de la página -->
        <style>
             /* Estilos generales */
            body {
                background-color: #2a1f36;
                color: white;
                font-family: Arial, sans-serif;
            }
            /* Título principal */
            h1 {
                text-align: center;
                margin-top: 50px;
                font-size: 40px;
                text-shadow: 0 0 10px rgb(255, 217, 105),
                    0 0 20px rgb(255, 217, 105),
                    0 0 40px rgb(255, 217, 105),
                    0 0 80px rgb(255, 217, 105);
            }
             /* Contenedor de tarjetas */
            .contenedor-historias {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 30px;
                margin: 50px auto;
                padding: 0 40px;
                max-width: 1200px;
            }
            /* Tarjeta individual de cada historia */
            .tarjeta-historia {
                background-color: #1e1e1e;
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
                width: 200px;
                transition: transform 0.3s, box-shadow 0.3s;
                text-align: center;
                padding-bottom: 10px;
            }
            /* Efecto hover sobre tarjeta */
            .tarjeta-historia:hover {
                transform: scale(1.05);
                box-shadow: 0 0 20px rgba(255, 217, 105, 0.8);
            }
            /* Imagen de portada */
            .tarjeta-historia img {
                width: 100%;
                height: 300px;
                object-fit: cover;
            }
            /* Título de la historia */
            .titulo-historia {
                font-size: 18px;
                padding: 10px;
                color: white;
                font-weight: bold;
            }
            /* Formulario de botones */
            form {
                margin-top: 10px;
            }
             /* Estilo general de botones */
            .btn {
                padding: 6px 12px;
                margin: 4px;
                border: none;
                border-radius: 5px;
                font-weight: bold;
                cursor: pointer;
            }
            /* Botón publicar */
            .btn-publicar {
                background-color: #28a745;
                color: white;
            }
            .btn-publicar:hover {
                background-color: #218838;
            }
            /* Botón borrador */
            .btn-borrador {
                background-color: #ffc107;
                color: black;
            }
            .btn-borrador:hover {
                background-color: #e0a800;
            }
             /* Botón añadir capítulo */
            .btn-anadir {
                background-color: #17a2b8;
                color: white;
            }
            .btn-anadir:hover {
                background-color: #138496;
            }
            /* Estado del libro */
            .estado {
                font-size: 14px;
                color: #ccc;
            }
             /* Botón volver */
            .btn-volver {
                display: block;
                margin: 40px auto;
                padding: 10px 20px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 6px;
                font-weight: bold;
                cursor: pointer;
                text-decoration: none;
                text-align: center;
            }
            .btn-volver:hover {
                background-color: #0056b3;
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

        <!-- Título -->
        <h1>Mis Historias</h1>

        <!-- Contenedor principal de historias -->
        <div class="contenedor-historias">
            <?php if (mysqli_num_rows($resultado) > 0): ?>
            <!-- Bucle que recorre todas las historias del usuario -->
                <?php while ($historia = mysqli_fetch_assoc($resultado)): ?>
                    <div class="tarjeta-historia">
                        <!-- Enlace a la creación de capítulos, pasando el ID por GET -->

                        <a href="crearCapitulo.php?id=<?= urlencode($historia['ID_Contenido']) ?>">
                            <img src="./img_portada/<?= htmlspecialchars($historia['portada']) ?>" alt="Portada">
                        </a>
                        <div class="titulo-historia"><?= htmlspecialchars($historia['Titulo']) ?></div>
                        <div class="estado">(Estado: <?= htmlspecialchars($historia['Estado']) ?>)</div>
                         <!-- Formulario para cambiar el estado de la historia -->
                        <form method="POST" action="">
                            <input type="hidden" name="id_contenido" value="<?= $historia['ID_Contenido'] ?>">
                            <button type="submit" name="accion" value="publicar" class="btn btn-publicar">Publicar</button>
                            <button type="submit" name="accion" value="borrador" class="btn btn-borrador">Borrador</button>
                        </form>
                         <!-- Botón para añadir capítulo -->
                        <form method="GET" action="crearCapitulo.php">
                            <input type="hidden" name="id" value="<?= $historia['ID_Contenido'] ?>">
                            <button type="submit" class="btn btn-anadir">Añadir Capítulo</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
            <!-- Mensaje si no hay historias -->
                <p style="text-align:center;">No has creado ninguna historia todavía.</p>
            <?php endif; ?>
        </div>
        <!-- Botón para volver al menú -->
        <a href="menuSuscrito.php" class="btn-volver">Volver al Menú</a>

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

<?php
    // Cierra la conexión a la base de datos
    mysqli_close($conexion); 
?>
