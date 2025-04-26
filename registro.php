<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero - Registro</title>
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

                <!-- Aquí agregamos el atributo name="registrar" -->
                <input type="submit" value="Registrar" name="registrar">
            </form>

            <p>¿Ya tienes cuenta?</p>
            <a href="login.php"><button class="login-button">Iniciar sesión</button></a>
            <p>¿No quieres registrarte? <a href="index.php">Pulsa aquí</a></p>
        </div>

        <?php
// Conexión a la base de datos
        $conexion = mysqli_connect("localhost", "root", "", "tintero")
                or die("No se puede conectar con el servidor o seleccionar la base de datos");

// Comprobar si se ha enviado el formulario
        if (isset($_POST['registrar'])) {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];
            $contrasena = $_POST['contrasena'];

            // Validar el correo
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<p style='color:red; text-align:center;'>Correo inválido</p>";
            } else {
                $fechaActual = date("Y-m-d");

                // Insertar usuario
                $sql = "INSERT INTO usuario(Nombre, Apellido, Correo_Electronico, Contrasena, Fecha_Registro, Tipo_Usuario) 
                VALUES ('$nombre', '$apellido', '$email', '$contrasena', '$fechaActual', 'Normal')";

                if (mysqli_query($conexion, $sql)) {
                    $id_usuario = mysqli_insert_id($conexion); // ID del usuario recién registrado
                    // Insertar suscripción básica
                    $sql_insert_suscripcion = "INSERT INTO suscripcion(Fecha_Inicio, Fecha_Finalizacion, Precio, ID_Usuario, id_plan) 
                                       VALUES ('$fechaActual', NULL, '0.00', '$id_usuario', '1')";

                    if (mysqli_query($conexion, $sql_insert_suscripcion)) {
                        echo "<p style='color:green; text-align:center;'>Usuario registrado con éxito</p>";
                    } else {
                        echo "<p style='color:red; text-align:center;'>Error en la suscripción: " . mysqli_error($conexion) . "</p>";
                    }
                } else {
                    echo "<p style='color:red; text-align:center;'>Error al registrar usuario: " . mysqli_error($conexion) . "</p>";
                }
            }
        }

// Cerrar la conexión
        mysqli_close($conexion);
        ?>
    </body>
</html>
