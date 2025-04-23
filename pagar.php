<?php
session_start();

if (!isset($_GET['plan']) || !isset($_GET['modo'])) {
    echo "No se han recibido datos de pago.";
    exit;
}

$plan_id = $_GET['plan'];
$modo_pago = $_GET['modo'];

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tintero");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener los datos del plan
$sql = "SELECT Nombre_Plan, Precio_Mensual, Precio_Anual FROM plan_suscripcion WHERE id_plan = $plan_id";
$resultado = mysqli_query($conexion, $sql);
$plan = mysqli_fetch_assoc($resultado);

// Determinar el precio según el modo
$precio = $modo_pago === "mensual" ? $plan["Precio_Mensual"] : $plan["Precio_Anual"];
$nombre_plan = $plan["Nombre_Plan"];

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html>
    <head>
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero</title>
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <link rel="stylesheet" type="text/css" href="./css/Registro_Login.css">
        <script src="./javascript/script.js"></script>
    </head>
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

        <div class="resumen">
            <h2>Resumen del Pago</h2>
            <p><strong>Plan Seleccionado:</strong> <?= $nombre_plan ?></p>
            <p><strong>Modalidad:</strong> <?= ucfirst($modo_pago) ?></p>
            <p><strong>Precio:</strong> <?= $precio ?> €</p>

            <!-- Aquí podrías redirigir a un procesador de pago real -->
            <form action="pago_exitoso.php" method="POST">

                <input type="hidden" name="plan_id" value="<?= $plan_id ?>">
                <input type="hidden" name="nombre_plan" value="<?= htmlspecialchars($nombre_plan) ?>">
                <input type="hidden" name="modo" value="<?= $modo_pago ?>">
                <input type="hidden" name="precio" value="<?= $precio ?>">
                <button class="btn" type="submit">Proceder al Pago</button>

            </form>
        </div>

    </body>
</html>
