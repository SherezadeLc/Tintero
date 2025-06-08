<?php
    //Inicia o reanuda la sesión para mantener datos del usuario
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tintero</title>
        <!-- Icono de pestaña del navegador -->
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
         <!-- Estilos CSS del formulario -->
        <link rel="stylesheet" type="text/css" href="./css/Registro_Login.css">
        <!-- Estilos para fondo animado de estrellas -->
        <link rel="stylesheet" type="text/css" href="./css/fondo_estrellas.css">
        <!-- JavaScript adicional -->
        <script src="./javascript/script.js"></script>
    </head>
    <body class="loaded">
        <!-- Fondo animado de estrellas -->
        <div id="estrellas">
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div><div class="firefly"></div><div class="firefly"></div>
            <div class="firefly"></div>
        </div>

        <!-- Contenedor del formulario de inicio de sesión -->
        <div class="contenedor-registro">
            <form name="form" action="" method="POST" enctype="multipart/form-data">
                <h2>LOGIN</h2>
                <hr>
                <h3>Accede y encuentra lo que buscas</h3><br>

                <!-- Campo de usuario -->
                Nombre usuario:<br><br>
                <input type="text" name="usuario" value="" /><br><br>

                <!-- Campo de contraseña -->
                Contraseña:<br><br>
                <input type="password" name="contrasena" value="" /><br><br>

                <!-- Botón de enviar -->
                <input type="submit" value="Enviar" name="enviar" /><br>
                <hr>
                <!-- Enlace a registro -->
                <p>¿No tienes una cuenta? Regístrate aquí</p>
                <a href="registro.php"><input type="button" class="login-button" value="Registro" name="registro" /></a> 
            </form>
        </div>

        <?php
        // Verifica si el usuario ha enviado el formulario
            if (isset($_POST['enviar'])) {
                $usuario_ingresado = $_POST['usuario'];
                $contrasena_ingresada = $_POST['contrasena'];

                // Conexión a la base de datos
                $conexion = mysqli_connect("localhost", "root", "", "tintero") or die("No se puede conectar con la base de datos");

                // Consulta para verificar usuario, contraseña y el estado en el que se encuentra
                $consulta = "SELECT nombre, id_usuario, Estado FROM usuario WHERE nombre = '$usuario_ingresado' AND contrasena = '$contrasena_ingresada'";
                $resultado = mysqli_query($conexion, $consulta);
                $datosConsulta = mysqli_fetch_assoc($resultado);

                if ($datosConsulta) {
                    // Usuario encontrado
                    $id_usuario = $datosConsulta['id_usuario'];
                    $_SESSION["id_usuario"] = $id_usuario;
                    $_SESSION["nombre_usuario"] = $datosConsulta['nombre'];
                    $estado = $datosConsulta['Estado'];

                    // Si el usuario es administrador, redirigir a panel de administración
                    if ($_SESSION["nombre_usuario"] == "admin") {
                        header('Location: admin_panel.php');
                        exit;
                    }

                    // Validar si la suscripción ha vencido
                    $hoy = date('Y-m-d');
                    $checkFecha = "SELECT Fecha_Finalizacion FROM suscripcion WHERE ID_Usuario = '$id_usuario'";
                    $resFecha = mysqli_query($conexion, $checkFecha);
                    $rowFecha = mysqli_fetch_assoc($resFecha);

                    if ($rowFecha && $rowFecha['Fecha_Finalizacion'] < $hoy) {
                        // Si la suscripción venció, actualizar a Plan Básico
                        $reset = "UPDATE suscripcion SET 
                            Nombre_Plan = 'Plan Basico',
                            Precio = 0,
                            Beneficios_Incluidos = 'Acceso básico a la plataforma',
                            Duracion_Meses = 0,
                            Fecha_Inicio = NULL,
                            Fecha_Finalizacion = NULL
                          WHERE ID_Usuario = '$id_usuario'";
                        mysqli_query($conexion, $reset);
                    }

                    // Obtener el nombre del plan actualizado
                    $consulta_plan = "SELECT Nombre_Plan FROM suscripcion WHERE ID_Usuario = '$id_usuario'";
                    $resPlan = mysqli_query($conexion, $consulta_plan);
                    $plan = mysqli_fetch_assoc($resPlan);

                    if ($plan && $estado == "activo") {
                        // Guardar el plan en la sesión y redirigir al menú principal
                        $_SESSION["Nombre_Plan"] = $plan["Nombre_Plan"];

                        header('Location: menuSuscrito.php');
                        exit;
                    } else {
                        // Usuario con cuenta inactiva o sin suscripción
                        echo "<p style='color:red; text-align:center;'>Este usuario no tiene una suscripción activa o no se encuentra activo.</p>";
                    }
                } else {
                     // Credenciales inválidas
                    echo "<p style='color:red; text-align:center;'>Credenciales incorrectas. Por favor, inténtalo de nuevo.</p>";
                }

                mysqli_close($conexion);
            }
        ?>
    </body>
</html>
