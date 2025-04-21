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
                //aqui insertamos el usuario en la base de datos 
                $sql = "INSERT INTO usuario( Nombre, Apellido, Correo_Electronico, Contrasena,Fecha_Registro) VALUES ('$nombre','$apellido','$email','$contrasena',' $fecha_actual')";
                 $fechaActual = date("Y-m-d");
                $sql_coger_info_id_usu= "SELECT ID_Usuario FROM usuario WHERE Correo_Electronico = '$email'";
                $sql_insert_suscripcion= "INSERT INTO suscripcion(`Fecha_Inicio`, `Fecha_Finalizacion`, `Precio`, `ID_Usuario`, `id_plan`) VALUES ('$fechaActual','null','0.00','$sql_coger_info_id_usu','1')";
                
                //aqui hacemos la conexion para introducirlo a la base de datos
                if (mysqli_query($conexion, $sql)) {
                  
                     if (mysqli_query($conexion, $sql_insert_suscripcion)) 
                      {
                        //si esta todo bien sale un mensaje en verde
                          echo "<p style='color:green;'>Usuario registrado con éxito</p>";
                       } else {
                    //si hay algun error sale un mensaje en rojo
                    echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
                }
                    
                } else {
                    
                    //si hay algun error sale un mensaje en rojo
                    echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
                }
               
            }
        }




        // Cerrar la conexión
        mysqli_close($conexion);
        ?>
    </body>
</html>
