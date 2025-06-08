<!DOCTYPE html>
<html>
    <head>
        <!-- Configuración básica de la página -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero - Registro</title>
        <!-- Ícono de la pestaña -->
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <!-- Hojas de estilo -->
        <link rel="stylesheet" type="text/css" href="./css/Registro_Login.css">
        <link rel="stylesheet" type="text/css" href="./css/fondo_estrellas.css">
         <!-- Script de validación u otras funciones JS -->
        <script src="./javascript/script.js"></script>
    </head>
    <body class="loaded">
         <!-- Fondo animado de estrellas con luciérnagas -->
        <div id="estrellas">
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div>
        </div>

         <!-- Formulario de registro -->
        <div class="contenedor-registro">
            <h2>Registro</h2>
            <hr><br>
            <form method="POST" onsubmit="return validarCorreo()">
                <!-- Campos del formulario -->
                <label>Nombre:</label>
                <input type="text" name="nombre" required><br>

                <label>Apellido:</label>
                <input type="text" name="apellido" required><br>

                <label>Correo electrónico:</label>
                <input type="email" name="email" id="email" required>
                 <!-- Mensaje de error oculto que puede mostrarse con JS -->
                <span id="error-message">Correo inválido</span><br>

                <label>Contraseña:</label>
                <input type="password" name="contrasena" required><br>

               <!-- Botón para enviar el formulario -->
                <input type="submit" value="Registrar" name="registrar">
            </form>

             <!-- Enlaces adicionales -->
            <p>¿Ya tienes cuenta?</p>
            <a href="login.php"><button class="login-button">Iniciar sesión</button></a>
            <p>¿No quieres registrarte? <a href="index.php">Pulsa aquí</a></p>
        </div>

        <?php
            // Conexión a la base de datos 
            $conexion = mysqli_connect("localhost", "root", "", "tintero")
                    or die("No se puede conectar con el servidor o seleccionar la base de datos");

            // Verificar si se envió el formulario
            if (isset($_POST['registrar'])) {
                // Obtener los valores del formulario
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $email = $_POST['email'];
                $contrasena = $_POST['contrasena'];

                // Validar que el correo tenga un formato válido
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<p style='color:red; text-align:center;'>Correo inválido</p>";
                } else {
                    // Obtener la fecha actual
                    $fechaActual = date("Y-m-d");

                    // Insertar el nuevo usuario con tipo 'Normal'
                    $sql = "INSERT INTO usuario(Nombre, Apellido, Correo_Electronico, Contrasena, Fecha_Registro, Tipo_Usuario) 
                    VALUES ('$nombre', '$apellido', '$email', '$contrasena', '$fechaActual', 'Normal')";

                     // Verificar si la inserción del usuario fue exitosa
                    if (mysqli_query($conexion, $sql)) {
                        $id_usuario = mysqli_insert_id($conexion); // ID del usuario recién registrado
                        // Insertar suscripción básica automáticamente
                        $sql_insert_suscripcion = "INSERT INTO suscripcion(Fecha_Inicio, Fecha_Finalizacion, Precio, ID_Usuario,Nombre_Plan,Beneficios_Incluidos) 
                                           VALUES ('$fechaActual', NULL, '0.00', '$id_usuario','Plan Basico','Acceso a la plataforma y funciones básicas de creación y publicación de historias.
                                                    Herramientas de edición y formateo de texto básicas.
                                                    Posibilidad de compartir contenido con otros usuarios.
                                                    Acceso limitado a plantillas y funcionalidades de diseño.')";

                        // Verificar si la inserción de la suscripción fue exitosa
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

            // Cerrar conexión a la base de datos
            mysqli_close($conexion);
        ?>
    </body>
</html>
