<!DOCTYPE html>
<?php session_start(); // Iniciar sesión para poder usar variables de sesión ?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Resultados de Búsqueda - Tintero</title>
        <!-- Estilos principales -->
        <link rel="stylesheet" type="text/css" href="./css/estilo.css">
        <!-- Fondo animado con estrellas -->
        <link rel="stylesheet" type="text/css" href="./css/fondo_estrellas.css">
    </head>
    <body>

        <!-- Animación de fondo de estrellas -->
        <div id="estrellas">
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div>
        </div>

        <?php
    // Conexión a la base de datos
        $conexion = mysqli_connect("localhost", "root", "", "tintero");
        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }

    // Array para guardar los libros encontrados
        $libros_encontrados = [];

    // Si el parámetro "buscar" existe en la URL y no está vacío
        if (isset($_GET['buscar']) && !empty(trim($_GET['buscar']))) {
            // Escapar caracteres especiales para evitar inyección SQL
            $termino = mysqli_real_escape_string($conexion, $_GET['buscar']);

            // Consulta para buscar libros por título o por nombre/apellido del autor
            $consultaBusqueda = "SELECT libro.Titulo, libro.portada, libro.ID_Contenido, 
                                CONCAT(usuario.Nombre, ' ', usuario.Apellido) AS Autor
                         FROM libro
                         JOIN usuario ON libro.ID_Autor = usuario.ID_Usuario
                         WHERE libro.Estado = 'Publicado'
                         AND (libro.Titulo LIKE '%$termino%' 
                              OR usuario.Nombre LIKE '%$termino%' 
                              OR usuario.Apellido LIKE '%$termino%')";

            $resultado = mysqli_query($conexion, $consultaBusqueda);

            // Si hay resultados, añadir cada libro al array
            if ($resultado && mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    $libros_encontrados[] = $fila;
                }
            }
        }
        ?>

        <!-- Encabezado con logo -->
        <header>
            <div class="contenedor-logo">
                <a href="index.php"><img src="./img/FondoTintero.png" class="logo"></a>
            </div>
        </header><br>

        <!-- Contenedor principal de resultados -->
        <div class="contenedor-h2">
            <h2 class="colorear">Resultados de búsqueda para "<?php echo htmlspecialchars($_GET['buscar']); ?>"</h2>

            <section class="contenedor-carrusel">
                <!-- Si se encontraron libros -->
                <?php if (!empty($libros_encontrados)): ?>
                    <?php foreach ($libros_encontrados as $libro): ?>
                        <div class="flip-card">
                            <div class="flip-card-inner">
                                <div class="flip-card-front">
                                    <!-- Portada clicable que lleva a opciones de lectura -->
                                    <a href="opciones_lectura.php?id=<?php echo $libro['ID_Contenido']; ?>">
                                        <img src="./img_portada/<?php echo htmlspecialchars($libro['portada']); ?>" 
                                             alt="Portada de <?php echo htmlspecialchars($libro['Titulo']); ?>">
                                    </a>
                                </div>
                                <div class="flip-card-back">
                                    <!-- Información del libro en el reverso -->
                                    <div class="titulo-historia">
                                        <?php echo htmlspecialchars($libro['Titulo']); ?><br>
                                        <small>por <?php echo htmlspecialchars($libro['Autor']); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Si no se encontraron resultados -->
                    <p style="color:white;">No se encontraron libros con ese título o autor.</p>
                <?php endif; ?>
            </section>
        </div><br>

        <!-- Botón para volver al menú del usuario suscrito -->
        <div style="text-align: center; margin-top: 30px;">
            <a href="menuSuscrito.php" class="btn-volver" style="
               background-color: #007bff;
               color: white;
               padding: 10px 20px;
               border-radius: 6px;
               font-weight: bold;
               text-decoration: none;
               ">Volver al menú</a>
        </div>

    </body>
</html>
