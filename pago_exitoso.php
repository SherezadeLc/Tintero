<?php
    // Inicia la sesión para acceder a las variables almacenadas previamente
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <!-- Hace que la vista sea responsive en dispositivos móviles -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero</title>
         <!-- Icono del sitio -->
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <!-- Estilos CSS externos -->
        <link rel="stylesheet" type="text/css" href="./css/Pagar.css">
        <script src="./javascript/script.js"></script>
        <!-- Estilos CSS internos -->
        <style>
            body {
                background-color: #2a1f36;
                color: white;
                font-family: Arial, sans-serif;
                text-align: center;
                padding-top: 50px;
            }
            .resumen {
                background-color: #3a2d4d;
                padding: 20px;
                border-radius: 10px;
                display: inline-block;
            }
            .btn {
                padding: 10px 20px;
                background-color: rgba(195, 6, 135, 1);
                border: none;
                color: white;
                border-radius: 5px;
                margin-top: 20px;
                text-decoration: none;
            }
            .btn:hover {
                background-color: rgba(195, 6, 135, 1);
            }
        </style>
    </head>
    <body>

        <?php
        // Verifica si el formulario se envió mediante POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Verifica si existe un plan seleccionado en la sesión
            if (isset($_SESSION['plan_seleccionado'])) {
                 // Recupera los datos del plan desde la sesión
                $nombre_plan = $_SESSION['plan_seleccionado']['nombre_plan'];
                 // Capitaliza la primera letra
                $modo = ucfirst($_SESSION['plan_seleccionado']['modo_pago']);
                $precio = $_SESSION['plan_seleccionado']['precio'];
                $duracion = $_SESSION['plan_seleccionado']['duracion'];
                $beneficios = $_SESSION['plan_seleccionado']['beneficios'];
                ?>

                <!-- Muestra un resumen del plan seleccionado -->
                <div class="resumen">
                    <h2>¡Pago realizado con éxito!</h2>
                    <p><strong>Plan seleccionado:</strong> <?= $nombre_plan ?></p>
                    <p><strong>Modo de pago:</strong> <?= $modo ?></p>
                    <p><strong>Metodo de pago:</strong> Tarjeta</p>
                    <p><strong>Duración:</strong> <?= $duracion ?> meses</p>
                    <p><strong>Precio:</strong> <?= $precio ?> €</p>
                    <p><strong>Beneficios incluidos:</strong></p>
                    <!-- Muestra los beneficios con saltos de línea -->
                    <p style="text-align: left;"><?= nl2br($beneficios) ?></p>
                    <?php
                    // Conexión a la base de datos
                    $conexion = mysqli_connect("localhost", "root", "", "tintero")
                            or die("No se puede conectar con el servidor o seleccionar la base de datos");

                    // Obtener el ID del usuario desde la sesión
                    $id_usuario = $_SESSION["id_usuario"];

                     // Crear objetos DateTime para calcular las fechas
                    // Fecha actual
                    $fechaInicio = new DateTime();
                    // Clon para modificar sin afectar la original
                    $fechaFin = clone $fechaInicio;
                    // Suma la duración en meses
                    $fechaFin->modify("+$duracion months");
                    // Calcula la diferencia entre fechas
                    $diferencia = $fechaInicio->diff($fechaFin);
                    // Total de meses
                    $meses = $diferencia->m + ($diferencia->y * 12);
                    // Días adicionales
                    $dias = $diferencia->d;

                    // Muestra las fechas y duración
                    echo "Fecha de inicio: " . $fechaInicio->format('Y-m-d') . "<br>";
                    echo "Fecha de fin: " . $fechaFin->format('Y-m-d') . "<br>";
                    echo "Duración real: $meses meses y $dias días.<br>";

                    // Formatear fechas para la consulta SQL
                    $fechaInicio = $fechaInicio->format('Y-m-d');
                    $fechaFin = $fechaFin->format('Y-m-d');

                    // Actualiza los datos de suscripción del usuario en la base de datos
                    $updateSuscripcionUsuario = "UPDATE suscripcion 
    SET Fecha_Inicio = '$fechaInicio', Fecha_Finalizacion = '$fechaFin', Precio ='$precio', Nombre_Plan = '$nombre_plan', Beneficios_Incluidos = '$beneficios', Duracion_Meses = '$duracion'
    WHERE id_usuario = '$id_usuario'";

                    // Ejecuta la consulta
                    $resultado = mysqli_query($conexion, $updateSuscripcionUsuario) or die("Fallo en el update de suscripcion del usuario");
                    ?>
                    <!-- Botón para volver al menú de usuario suscrito -->
                    <a class="btn" href="menuSuscrito.php">Volver</a>
                </div>

                <?php
            } else {
                // Si no hay plan en la sesión
                echo "<p style='color: red;'>No hay información de plan en la sesión.</p>";
            }
        } else {
            // Si no se accede mediante POST
            echo "<p style='color: red;'>Acceso no válido.</p>";
        }
        ?>

    </body>
</html>
