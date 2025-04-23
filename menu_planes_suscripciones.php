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
        }
        table {
            border-collapse: collapse;
            width: 90%;
            margin: auto;
            margin-top: 50px;
            background-color: #3a2d4d;
        }
        th, td {
            border: 1px solid #555;
            padding: 12px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #0077cc;
            color: white;
            font-size: 16px;
        }
        .btn {
            padding: 10px 18px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            display: inline-block;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">Planes de Suscripción</h2>

<?php
$conexion = mysqli_connect("localhost", "root", "", "tintero");

if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

$sql = "SELECT id_plan, Nombre_Plan, Precio_Mensual, Precio_Anual, Beneficios_Incluidos FROM plan_suscripcion";
$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) > 0) {
    echo "<table>";
    echo "<tr>
            <th>Nombre del Plan</th>
            <th>Precio Mensual</th>
            <th>Precio Anual</th>
            <th>Beneficios Incluidos</th>
            <th>Pagar Mensualmente</th>
            <th>Pagar Anualmente</th>
          </tr>";

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $idPlan = $fila["id_plan"];
        echo "<tr>";
        echo "<td>" . $fila["Nombre_Plan"] . "</td>";
        echo "<td>" . $fila["Precio_Mensual"] . " €</td>";
        echo "<td>" . $fila["Precio_Anual"] . " €</td>";
        echo "<td>" . $fila["Beneficios_Incluidos"] . "</td>";
        echo "<td><a class='btn' href='pagar.php?plan=$idPlan&modo=mensual'>Pagar Mensual</a></td>";
        echo "<td><a class='btn' href='pagar.php?plan=$idPlan&modo=anual'>Pagar Anual</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p style='text-align: center;'>No hay planes de suscripción disponibles.</p>";
}

mysqli_close($conexion);
?>

</body>
</html>