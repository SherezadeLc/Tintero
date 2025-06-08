<?php
    // Inicia la sesión para acceder a las variables de sesión
    session_start();

    // Accede a las variables de sesión del usuario
    $_SESSION["Nombre_Plan"];
    $_SESSION['id_usuario'];
    // Plan actual del usuario (ej: Plan Premium)
    $plan = $_SESSION["Nombre_Plan"];
    // ID del usuario autenticado
    $id_usuario = $_SESSION['id_usuario'];

    // Verifica que se haya proporcionado un ID válido del libro mediante GET
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        // Termina si no se proporciona un ID válido
        die("ID de libro no válido.");
    }

    // Sanitiza el ID recibido
    $id_contenido = intval($_GET['id']);

    // Conecta a la base de datos MySQL
    $conexion = mysqli_connect("localhost", "root", "", "tintero");
    if (!$conexion) {
        // Error si no se conecta
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Obtiene los datos del libro
    $sql = "SELECT Titulo, Descripcion, portada FROM libro WHERE ID_Contenido = $id_contenido";
    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) == 0) {
         // Si el libro no existe, muestra mensaje
        die("Libro no encontrado.");
    }

    // Almacena los datos del libro
    $libro = mysqli_fetch_assoc($resultado);

    // Valida si el usuario tiene permiso para ver el contenido completo del libro
    $permitido = false;
    // Si el plan es Premium, Estándar o Mes prueba, tiene acceso total
    if ($plan == 'Plan Premium' || $plan == 'Plan Estandar' || $plan == 'Mes prueba') {
        $permitido = true;
        // Si es Plan Básico, solo se permite si el libro está marcado como visible para ese plan
    } elseif ($plan === 'Plan_Basico' && $libro['visible_basico'] == 1) {
        $permitido = true;
    }

    // Si el usuario no tiene permiso, se muestra mensaje de restricción y opción de actualizar plan
    if (!$permitido) {
        echo "<p style='color:red; text-align:center;'>Tu plan actual no permite acceder a este libro completo.</p>";
        echo "<p style='text-align:center;'><a href='menu_planes_suscripciones.php'>Mejorar suscripción</a></p>";
        // Detiene la ejecución
        exit();
    }

    // Consulta para obtener todos los capítulos del libro ordenados por número
    $sql_capitulos = "SELECT numero_capitulo, titulo_capitulo, contenido FROM capitulos WHERE ID_Contenido = $id_contenido ORDER BY numero_capitulo ASC";
    // Ejecuta la consulta
    $capitulos = mysqli_query($conexion, $sql_capitulos);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title><?= htmlspecialchars($libro['Titulo']) ?> - Tintero</title>
        <style>
            body {
                background-color: #2a1f36;
                color: white;
                font-family: Arial, sans-serif;
                padding: 40px;
            }
            .portada {
                width: 200px;
                height: 300px;
                object-fit: cover;
                border-radius: 8px;
            }
            .capitulo {
                margin-bottom: 40px;
            }
            h1, h2 {
                color: #ffd769;
            }
            .descripcion {
                font-style: italic;
                color: #ccc;
            }
        </style>
    </head>
    <body>

         <!-- Título del libro -->
        <h1><?= htmlspecialchars($libro['Titulo']) ?></h1>
        <!-- Imagen de portada -->
        <img src="./img_portada/<?= htmlspecialchars($libro['portada']) ?>" class="portada" alt="Portada del libro">
        <!-- Descripción del libro -->
        <p class="descripcion"><?= nl2br(htmlspecialchars($libro['Descripcion'])) ?></p>
        <hr>
        <!-- Lista de capítulos -->
        <?php
        
            if (mysqli_num_rows($capitulos) > 0) {
                while ($capitulo = mysqli_fetch_assoc($capitulos)) {
                    echo "<div class='capitulo'>";
                    echo "<h2>Capítulo " . $capitulo['numero_capitulo'] . ": " . htmlspecialchars($capitulo['titulo_capitulo']) . "</h2>";
                    echo "<p>" . nl2br(htmlspecialchars_decode($capitulo['contenido'])) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>Este libro aún no tiene capítulos.</p>";
            }

            // Cierra la conexión a la base de datos
            mysqli_close($conexion);
        ?>
        <!-- Botón para volver al menú principal -->
        <div style="text-align: center; margin-top: 40px;">
            <a href="menuSuscrito.php">
                <button style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
                    Volver al menú
                </button>
            </a>
        </div>
    </body>
</html>