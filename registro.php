<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero</title>
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <link rel="stylesheet" type="text/css" href="./css/Registro_Login.css">
        <script src="./javascript/script.js"></script>
    </head>
    <body class="loaded">
        <div class="contenedor-registro">
            <h2>Registro</h2>
            <hr><br>
            <form method="POST" onsubmit="return validarCorreo()">
                <label>Nombre:</label>
                <input type="text" name="nombre" required><br>

                <label>Apellido:</label>
                <input type="text" name="apellido" required><br>

                <label>Correo electrónico:</label>
                <input type="email" name="email" id="email" required>
                <span id="error-message">Correo inválido</span><br>

                <label>Contraseña:</label>
                <input type="password" name="contrasena" required><br>

                <input type="submit" value="Registrar">
            </form>

            <p>¿Ya tienes cuenta?</p>
            <a href="login.php"><button class="login-button">Iniciar sesión</button></a>
            <p>¿No quieres registrarte? <a href="index.php">Pulsa aquí</a></p>
        </div>
        <?php
        $conexion = mysqli_connect("localhost", "root", "", "tintero");
        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }
        //aqui comprobamos si se ha pulsado a enviar
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
            @$nombre = $_POST['nombre'];
            @$apellido = $_POST['apellido'];
            @$email = $_POST['email'];
            @$contrasena = $_POST['contrasena'];

            //aqui pasa un filtro para saber si tiene las caracteristicas que se necesitan del correo
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                echo "<p style='color:red;'>Correo inválido</p>";
            } else {
                $fechaActual = date("Y-m-d");
                $sql = "INSERT INTO usuario( Nombre, Apellido, Correo_Electronico, Contrasena, Fecha_Registro) 
                        VALUES ('$nombre', '$apellido', '$email', '$contrasena', '$fechaActual')";

                if (mysqli_query($conexion, $sql)) {
                    $id_usuario = mysqli_insert_id($conexion); // ← obtenemos el ID del usuario recién insertado

                    $sql_insert_suscripcion = "INSERT INTO suscripcion(`Fecha_Inicio`, `Fecha_Finalizacion`, `Precio`, `ID_Usuario`, `id_plan`) 
                    VALUES ('$fechaActual', NULL, '0.00', '$id_usuario', '1')";

                    if (mysqli_query($conexion, $sql_insert_suscripcion)) {
                        echo "<p style='color:green;'>Usuario registrado con éxito</p>";
                    } else {
                        echo "<p style='color:red;'>Error en la suscripción: " . mysqli_error($conexion) . "</p>";
                    }
                } else {
                    echo "<p style='color:red;'>Error al registrar usuario: " . mysqli_error($conexion) . "</p>";
                }
            }
        }




        // Cerrar la conexión
        mysqli_close($conexion);
        ?>
    </body>
</html>
