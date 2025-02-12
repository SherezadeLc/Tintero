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
    </head>
    <body>
        <h1>Registro</h1>
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
        <hr>
        <p>¿Ya te has registrado?</p>
        <a href="login.php"><button class="login-button">Iniciar sesión</button></a><br><br>
        <a href="index.php">Pulsa aqui</a>
        

        <?php
        //obtener la fecha actual
        $fecha_actual = date("Y-m-d");
       
        $conexion =mysqli_connect("localhost", "root", "", "tintero") or die("No se puede conectar con el servidor o seleccionar la base de datos");
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
            $nombre =$_POST['nombre'];
            $apellido=$_POST['apellido'];
            $email=$_POST['email'];
            $contrasena=$_POST['contrasena'];
            
            //aqui pasa un filtro si el correo es como tiene que ser si no es con las caracteristicas que se necesitan le sale un mensaje en rojo
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                echo "<p style='color:red;'>Correo inválido</p>";
            }else{
                $sql= "INSERT INTO usuario( Nombre, Apellido, Correo_Electronico, Contrasena,Fecha_Registro) VALUES ('$nombre','$apellido','$email','$contrasena',' $fecha_actual' )";
                if(mysqli_query($conexion,$sql)){
                     echo "<p style='color:green;'>Usuario registrado con éxito</p>";
                }else{
                    echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
                }
                
            }
            
            
            
            
        }
        
        
        
        
        
        
        ?>
    </body>
</html>
