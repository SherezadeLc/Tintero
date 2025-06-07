<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
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

            Nombre usuario:<br><br>
            <input type="text" name="usuario" value="" /><br><br>

            Contraseña:<br><br>
            <input type="password" name="contrasena" value="" /><br><br>

            <input type="submit" value="Enviar" name="enviar" /><br>
            <hr>
            <p>¿No tienes una cuenta? Regístrate aquí</p>
            <a href="registro.php"><input type="button" class="login-button" value="Registro" name="registro" /></a> 
        </form>
    </div>

<?php
if (isset($_POST['enviar'])) {
    $usuario_ingresado = $_POST['usuario'];
    $contrasena_ingresada = $_POST['contrasena'];

    $conexion = mysqli_connect("localhost", "root", "", "tintero") or die("No se puede conectar con la base de datos");

    $consulta = "SELECT nombre, id_usuario FROM usuario WHERE nombre = '$usuario_ingresado' AND contrasena = '$contrasena_ingresada'";
    $resultado = mysqli_query($conexion, $consulta);
    $datosConsulta = mysqli_fetch_assoc($resultado);

    if ($datosConsulta) {
        $id_usuario = $datosConsulta['id_usuario'];
        $_SESSION["id_usuario"] = $id_usuario;
        $_SESSION["nombre_usuario"] = $datosConsulta['nombre'];

        if ($_SESSION["nombre_usuario"] == "admin") {
            header('Location: admin_panel.php');
            exit;
        }

        // Verificamos si la suscripción ha vencido
        $hoy = date('Y-m-d');
        $checkFecha = "SELECT Fecha_Finalizacion FROM suscripcion WHERE ID_Usuario = '$id_usuario'";
        $resFecha = mysqli_query($conexion, $checkFecha);
        $rowFecha = mysqli_fetch_assoc($resFecha);

        if ($rowFecha && $rowFecha['Fecha_Finalizacion'] < $hoy) {
            // Actualizar suscripción a Plan Basico
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

        // Obtener el plan actualizado
        $consulta_plan = "SELECT Nombre_Plan FROM suscripcion WHERE ID_Usuario = '$id_usuario'";
        $resPlan = mysqli_query($conexion, $consulta_plan);
        $plan = mysqli_fetch_assoc($resPlan);

        if ($plan) {
            $_SESSION["Nombre_Plan"] = $plan["Nombre_Plan"];

            header('Location: menuSuscrito.php');
            exit;
        } else {
            echo "<p style='color:red; text-align:center;'>Este usuario no tiene una suscripción activa.</p>";
        }
    } else {
        echo "<p style='color:red; text-align:center;'>Credenciales incorrectas. Por favor, inténtalo de nuevo.</p>";
    }

    mysqli_close($conexion);
}
?>
</body>
</html>
