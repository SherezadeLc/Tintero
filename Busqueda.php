<!DOCTYPE html>
<?php session_start(); // Inicia la sesión para usar variables de sesión ?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Resultados de Búsqueda - Tintero</title>
        <!-- Estilos personalizados -->
        <link rel="stylesheet" type="text/css" href="./css/estilo.css">
        <link rel="stylesheet" type="text/css" href="./css/fondo_estrellas.css"> <!-- Fondo animado con estrellas -->
    </head>
    <body>

        <!-- Fondo animado -->
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

// Array que almacenará los libros encontrados tras la búsqueda
        $libros_encontrados = [];

// Si el usuario ha enviado el formulario con un término de búsqueda
        if (isset($_GET['buscar']) && !empty(trim($_GET['buscar']))) {
            $termino = mysqli_real_escape_string($conexion, $_GET['buscar']); // Sanitiza entrada para evitar inyecciones SQL
            // Consulta: buscar en libros publicados por título o por autor
            $consultaBusqueda = "SELECT libro.Titulo, libro.portada, libro.ID_Contenido, 
                                CONCAT(usuario.Nombre, ' ', usuario.Apellido) AS Autor
                         FROM libro
                         JOIN usuario ON libro.ID_Autor = usuario.ID_Usuario
                         WHERE libro.Estado = 'Publicado'
                         AND (libro.Titulo LIKE '%$termino%' 
                              OR usuario.Nombre LIKE '%$termino%' 
                              OR usuario.Apellido LIKE '%$termino%')";

            $resultado = mysqli_query($conexion, $consultaBusqueda);

            // Si se encuentran resultados, almacenarlos en el array
            if ($resultado && mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    $libros_encontrados[] = $fila;
                }
            }
        }
        ?>

        <!-- Encabezado con logo de Tintero -->
        <header>
            <div class="contenedor-logo">
                <a href="index.php"><img src="./img/FondoTintero.png" class="logo"></a>
            </div>
        </header><br>

        <!-- Contenedor de resultados de búsqueda -->
        <div class="contenedor-h2">
            <h2 class="colorear">Resultados de búsqueda para "<?php echo htmlspecialchars($_GET['buscar']); ?>"</h2>

            <section class="contenedor-carrusel">
                <!-- Si se encontraron libros -->
                <?php if (!empty($libros_encontrados)): ?>
                    <?php foreach ($libros_encontrados as $libro): ?>
                        <div class="flip-card">
                            <div class="flip-card-inner">
                                <div class="flip-card-front">
                                    <!-- Imagen de portada, clicable -->
                                    <a href="opciones_lectura.php?id=<?php echo $libro['ID_Contenido']; ?>">
                                        <img src="./img_portada/<?php echo htmlspecialchars($libro['portada']); ?>" 
                                             alt="Portada de <?php echo htmlspecialchars($libro['Titulo']); ?>">
                                    </a>
                                </div>
                                <div class="flip-card-back">
                                    <!-- Título y autor en la parte trasera de la tarjeta -->
                                    <div class="titulo-historia">
                                        <?php echo htmlspecialchars($libro['Titulo']); ?><br>
                                        <small>por <?php echo htmlspecialchars($libro['Autor']); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Si no se encontró ningún libro -->
                    <p style="color:white;">No se encontraron libros con ese título o autor.</p>
                <?php endif; ?>
            </section>
        </div><br>

        <!-- Botón para volver al menú del usuario no suscrito -->
        <div style="text-align: center; margin-top: 30px;">
            <a href="index.php" class="btn-volver" style="
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
