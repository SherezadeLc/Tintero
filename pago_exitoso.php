<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero</title>
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <link rel="stylesheet" type="text/css" href="./css/Registro_Login.css">
        <script src="./javascript/script.js"></script>
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
                background-color: #28a745;
                border: none;
                color: white;
                border-radius: 5px;
                margin-top: 20px;
                text-decoration: none;
            }
            .btn:hover {
                background-color: #218838;
            }
        </style>
    </head>
    <body>

        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_SESSION['plan_seleccionado'])) {
                $nombre_plan = $_SESSION['plan_seleccionado']['nombre_plan'];
                $modo = ucfirst($_SESSION['plan_seleccionado']['modo_pago']);
                $precio = $_SESSION['plan_seleccionado']['precio'];
                $duracion = $_SESSION['plan_seleccionado']['duracion'];
                $beneficios = $_SESSION['plan_seleccionado']['beneficios'];
                ?>

                <div class="resumen">
                    <h2>¡Pago realizado con éxito!</h2>
                    <p><strong>Plan seleccionado:</strong> <?= $nombre_plan ?></p>
                    <p><strong>Modo de pago:</strong> <?= $modo ?></p>
                    <p><strong>Metodo de pago:</strong> Tarjeta</p>
                    <p><strong>Duración:</strong> <?= $duracion ?> meses</p>
                    <p><strong>Precio:</strong> <?= $precio ?> €</p>
                    <p><strong>Beneficios incluidos:</strong></p>
                    <p style="text-align: left;"><?= nl2br($beneficios) ?></p>
                    <?php
                    $conexion = mysqli_connect("localhost", "root", "", "tintero")
                            or die("No se puede conectar con el servidor o seleccionar la base de datos");

                    $id_usuario = $_SESSION["id_usuario"];

                    // Cálculo de fechas
                    $fechaInicio = new DateTime();
                    $fechaFin = clone $fechaInicio;
                    $fechaFin->modify("+$duracion months");
                    $diferencia = $fechaInicio->diff($fechaFin);

                    $meses = $diferencia->m + ($diferencia->y * 12);
                    $dias = $diferencia->d;

                    echo "Fecha de inicio: " . $fechaInicio->format('Y-m-d') . "<br>";
                    echo "Fecha de fin: " . $fechaFin->format('Y-m-d') . "<br>";
                    echo "Duración real: $meses meses y $dias días.<br>";

// Convertir objetos DateTime a string antes de usarlos en la consulta SQL
                    $fechaInicio = $fechaInicio->format('Y-m-d');
                    $fechaFin = $fechaFin->format('Y-m-d');

                    $updateSuscripcionUsuario = "UPDATE suscripcion 
    SET Fecha_Inicio = '$fechaInicio', Fecha_Finalizacion = '$fechaFin', Precio ='$precio', Nombre_Plan = '$nombre_plan', Beneficios_Incluidos = '$beneficios', Duracion_Meses = '$duracion'
    WHERE id_usuario = '$id_usuario'";

                    $resultado = mysqli_query($conexion, $updateSuscripcionUsuario) or die("Fallo en el update de suscripcion del usuario");
                    ?>
                    <a class="btn" href="menuSuscrito.php">Volver</a>
                </div>

                <?php
            } else {
                echo "<p style='color: red;'>No hay información de plan en la sesión.</p>";
            }
        } else {
            echo "<p style='color: red;'>Acceso no válido.</p>";
        }
        ?>

    </body>
</html>
