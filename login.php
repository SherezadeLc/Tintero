<?php
session_start();
?>
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
                <p>¿No tienes una cuenta? Registrate aquí</p>
                <a href="registro.php"><input type="button" class="login-button" value="Registro" name="registro" /></a> 

            </form>
        </div>
        <?php
        // put your code here
        /* inicio sesion */
        session_start();

        /* Si el usuario pulsa el boton de salir en el menu se elimina el usuario de la variable de sesion y se destruye la session */
        if (isset($_REQUEST['salir'])) {
            unset($_SESSION['usuario']);
            session_destroy();
        }

        // Verificar si el formulario  de logeo ha sido enviado
        if (isset($_POST['enviar'])) {
            // Recuperar los datos del formulario
            $usuario_ingresado = $_POST['usuario'];
            $contrasena_ingresada = $_POST['contrasena'];

            //aqui hacemos la conexion a la base de datos
            $conexion = mysqli_connect("localhost", "root", "", "tintero") or die("No se puede conectar con el servidor o seleccionar la base de datos");


            /* Consulta SQL para verificar usuario y contraseña introducido */
            $consulta = "SELECT nombre,id_usuario FROM usuario WHERE usuario = '$usuario_ingresado' AND contrasena = '$contrasena_ingresada'";

            $consulta = mysqli_query($conexion, $consulta)
                    or die("Fallo en la consulta");

            /* Sacamos la fila */
            $datosConsulta = mysqli_fetch_assoc($consulta);

            // Verificar si la consulta devuelve true porque hay resultados y son mas de 0 filas
            if ($consulta && mysqli_num_rows($consulta) > 0) {
                //aqui guardamos la informacion del id_usuario que luego lo vamos a utilizar para buscar que tipo de suscripcion tiene
                $id_usuario = $datosConsulta['id_usuario'];
                //aqui sacamos la informacion del plan de suscripcion que es el id_plan que luego buscamos en otra tabla cual de todos es. 
                $consulta_suscripcion = "SELECT id_plan FROM suscripcion WHERE ID_Usuario = '$id_usuario'";
                $datosConsultaId_planSuscripcion = mysqli_query($conexion, $consulta_suscripcion);

                $id_plan_Suscripcion = $datosConsultaId_planSuscripcion['id_plan'];
                $consulta_Plan_suscripcion = "SELECT ID_Plan,Nombre_Plan FROM plan_suscripcion WHERE ID_Plan = '$id_plan_Suscripcion'";
                $datosConsultaPlanSuscripcion = mysqli_query($conexion, $consulta_Plan_suscripcion);
                /* Sacamos la fila */
                $datosConsulta_Plan_Suscripcion = mysqli_fetch_assoc($datosConsultaPlanSuscripcion);



                // Credenciales válidas, iniciar sesión
                $_SESSION['usuario'] = $usuario_ingresado;

                /* Guardo el nombre del usuario para mostrarle un mensaje de bienvenido */
                $_SESSION['nombreUsuario'] = $datosConsulta['nombre'];

                /* Guardo en variable de sesion el id del usuario para usarlo mas tarde */
                $_SESSION['id_usuario'] = $datosConsulta['id_usuario'];

                $_SESSION['plan_suscripcion'] = $datosConsulta_Plan_Suscripcion['Nombre_Plan'];

                /* Si el usuario que se logea tiene como rol invitado, solo le redirigira a previsualizacion donde podra solo observar los productos */
                if ($_SESSION['plan_suscripcion'] == 'Plan_Basico') {

                    header('Location: menuPlanBasico.php');
                    exit;
                }
                if ($_SESSION['plan_suscripcion'] == 'Plan_Estandar') {

                    header('Location: menuPlanEstandar.php');
                    exit;
                }
                if ($_SESSION['plan_suscripcion'] == 'Plan_Premium') {

                    header('Location: menuPlanPremium.php');
                    exit;
                }
                if ($_SESSION['plan_suscripcion'] == 'Mes_prueba') {

                    header('Location: menuPlanPremium.php');
                    exit;
                }
            } else {
                // Credenciales inválidas, mostrar mensaje de error
                echo "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
            }

            // Cerrar la conexión a la base de datos
            $conexion->close();
        }
        ?>
    </body>
</html>
