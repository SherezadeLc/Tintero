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
    </head>
    <body class="loaded">
        <div class="contenedor-registro">
            <form name="form" action="" method="POST" enctype="multipart/form-data">

                <h2>LOGIN</h2>
                <hr>
                <h3>Accede y encuentra lo que buscas</h3><br>

                Nombre usuario:
                <br><br>
                <input type="text" name="usuario" value="" />
                <br><br>

                Contraseña:
                <br><br>
                <input type="password" name="contrasena" value="" />
                <br><br>

                <input type="submit" value="Enviar" name="enviar" />
                <br>
                <hr>
                <p>¿No tienes una cuenta? Regístrate aquí</p>
                <a href="registro.php"><input type="button" class="login-button" value="Registro" name="registro" /></a> 

            </form>
        </div>

        <?php
// Si el usuario pulsa el botón de salir
        if (isset($_REQUEST['salir'])) {
            unset($_SESSION['usuario']);
            session_destroy();
        }

// Verificar si el formulario de login ha sido enviado
        if (isset($_POST['enviar'])) {
            // Recuperar los datos del formulario
            $usuario_ingresado = $_POST['usuario'];
            $contrasena_ingresada = $_POST['contrasena'];

            // Conexión a la base de datos
            $conexion = mysqli_connect("localhost", "root", "", "tintero")
                    or die("No se puede conectar con el servidor o seleccionar la base de datos");

            // Consulta para verificar usuario y contraseña
            $consulta = "SELECT nombre, id_usuario FROM usuario WHERE nombre = '$usuario_ingresado' AND contrasena = '$contrasena_ingresada'";
            $resultado = mysqli_query($conexion, $consulta) or die("Fallo en la consulta");
            $datosConsulta = mysqli_fetch_assoc($resultado);

            if ($datosConsulta) {
                // Usuario encontrado, obtener id_usuario
                $id_usuario = $datosConsulta['id_usuario'];

                // Consultar la suscripción
                $consulta_suscripcion = "SELECT id_plan FROM suscripcion WHERE ID_Usuario = '$id_usuario'";
                $resultadoConsultaSuscripcion = mysqli_query($conexion, $consulta_suscripcion) or die("Fallo en la consulta de suscripción");
                $datosConsultaId_planSuscripcion = mysqli_fetch_assoc($resultadoConsultaSuscripcion);

                if ($datosConsultaId_planSuscripcion) {
                    // Si existe suscripción
                    $id_plan_Suscripcion = $datosConsultaId_planSuscripcion['id_plan'];

                    // Consultar nombre del plan
                    $consulta_Plan_suscripcion = "SELECT ID_Plan, Nombre_Plan FROM plan_suscripcion WHERE ID_Plan = '$id_plan_Suscripcion'";
                    $resultadoPlanSuscripcion = mysqli_query($conexion, $consulta_Plan_suscripcion) or die("Fallo en la consulta de plan");
                    $datosConsulta_Plan_Suscripcion = mysqli_fetch_assoc($resultadoPlanSuscripcion);

                    // Iniciar sesión
                    $_SESSION['usuario'] = $usuario_ingresado;
                    $_SESSION['nombreUsuario'] = $datosConsulta['nombre'];
                    $_SESSION['id_usuario'] = $datosConsulta['id_usuario'];
                    $_SESSION['plan_suscripcion'] = $datosConsulta_Plan_Suscripcion['Nombre_Plan'];

                    // Redireccionar según el plan
                    if ($_SESSION['plan_suscripcion'] == 'Plan_Basico') {
                        header('Location: index.php');
                        exit;
                    } elseif ($_SESSION['plan_suscripcion'] == 'Plan_Estandar') {
                        header('Location: index.php');
                        exit;
                    } elseif ($_SESSION['plan_suscripcion'] == 'Plan_Premium' || $_SESSION['plan_suscripcion'] == 'Mes_prueba') {
                        header('Location: index.php');
                        exit;
                    }
                } else {
                    echo "<p style='color:red; text-align:center;'>Este usuario no tiene una suscripción activa.</p>";
                }
            } else {
                echo "<p style='color:red; text-align:center;'>Credenciales incorrectas. Por favor, inténtalo de nuevo.</p>";
            }

            // Cerrar conexión
            mysqli_close($conexion);
        }
        ?>
    </body>
</html>
