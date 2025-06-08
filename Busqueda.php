<!DOCTYPE html>
<?php session_start(); ?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Búsqueda - Tintero</title>
    <link rel="stylesheet" type="text/css" href="./css/estilo.css">
    <link rel="stylesheet" type="text/css" href="./css/fondo_estrellas.css">
</head>
<body>

<!-- Fondo -->
<div id="estrellas">
    <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
    <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
    <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
    <div class="firefly"></div>
</div>

<?php
$conexion = mysqli_connect("localhost", "root", "", "tintero");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$libros_encontrados = [];

if (isset($_GET['buscar']) && !empty(trim($_GET['buscar']))) {
    $termino = mysqli_real_escape_string($conexion, $_GET['buscar']);
    $consultaBusqueda = "SELECT libro.Titulo, libro.portada, libro.ID_Contenido, CONCAT(usuario.Nombre, ' ', usuario.Apellido) AS Autor
                         FROM libro
                         JOIN usuario ON libro.ID_Autor = usuario.ID_Usuario
                         WHERE libro.Estado = 'Publicado'
                         AND (libro.Titulo LIKE '%$termino%' 
                         OR usuario.Nombre LIKE '%$termino%' 
                         OR usuario.Apellido LIKE '%$termino%')";
    $resultado = mysqli_query($conexion, $consultaBusqueda);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $libros_encontrados[] = $fila;
        }
    }
}
?>

<header>
    <div class="contenedor-logo">
        <a href="index.php"><img src="./img/FondoTintero.png" class="logo"></a>
    </div>
</header><br>


<div class="contenedor-h2">
    <h2 class="colorear">Resultados de búsqueda para "<?php echo htmlspecialchars($_GET['buscar']); ?>"</h2>
    <section class="contenedor-carrusel">
        <?php if (!empty($libros_encontrados)): ?>
            <?php foreach ($libros_encontrados as $libro): ?>
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <a href="opciones_lectura.php?id=<?php echo $libro['ID_Contenido']; ?>">
                                <img src="./img_portada/<?php echo htmlspecialchars($libro['portada']); ?>" alt="Portada de <?php echo htmlspecialchars($libro['Titulo']); ?>">
                            </a>
                        </div>
                        <div class="flip-card-back">
                            <div class="titulo-historia">
                                <?php echo htmlspecialchars($libro['Titulo']); ?><br>
                                <small>por <?php echo htmlspecialchars($libro['Autor']); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color:white;">No se encontraron libros con ese título o autor.</p>
        <?php endif; ?>
    </section>
</div><br>
<!-- Botón Volver -->
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