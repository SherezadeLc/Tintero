<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Registro</title>
        <script src="./javascript/script.js" defer></script> <!-- Carga el JS -->
        <link rel="stylesheet" type="text/css" href="./css/estilo.css">
    </head>
    <body>
        <div class="parallax">
        <div class="grupo-parallax">
            <div class="capa-parallax capa-base">
                <div class="contenerdor-h2">
                    <h2>Registro</h2>
                </div>
                <form method="POST" onsubmit="return validarCorreo()">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" required><br><br>
                    <label>Apellido:</label>
                    <input type="text" name="apellido" required><br><br>
                    <label>Correo electronico:</label>
                    <input type="text" name="email" required>
                    <span id="error-message">Correo inválido</span>
                    <br><br>
                    <label>Contraseña:</label>
                    <input type="password" name="contrasena" required><br><br>

                    <input type="submit" name="enviar" value="Registrar">
                </form>
            </div>
            <div class="capa-parallax capa-fondo">
                <img src="./img/foto1.jpeg" alt="Imagen de Fondo">
            </div>
            <div class="capa-parallax capa-primer-plano">
                <img src="" alt="Imagen de Primer Plano">
            </div>
        </div>
    </div>

    <hr>
    <p>¿Ya te has registrado?</p>
    <a href="login.php"><button class="login-button">Iniciar sesión</button></a><br><br>
    <p>Si no quieres registrar <a href="index.php">Pulsa aqui</a></p>


        <?php
       

        //aqui hacemos la conexion a la base de datos
        $conexion = mysqli_connect("localhost", "root", "", "tintero") or die("No se puede conectar con el servidor o seleccionar la base de datos");

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
