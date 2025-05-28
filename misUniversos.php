<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mis Historias | Tintero</title>
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <link rel="stylesheet" type="text/css" href="./css/Registro_Login.css">
        <style>
            h1 {
                text-align: center;
                margin-top: 50px;
                font-size: 40px;
                color: white;
                text-shadow: 0 0 10px rgb(255, 217, 105),
                    0 0 20px rgb(255, 217, 105),
                    0 0 40px rgb(255, 217, 105),
                    0 0 80px rgb(255, 217, 105);
            }

            .contenedor-historias {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 30px;
                margin: 50px auto;
                padding: 0 40px;
                max-width: 1200px;
            }

            .tarjeta-historia {
                background-color: #1e1e1e;
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
                width: 200px;
                transition: transform 0.3s, box-shadow 0.3s;
                cursor: pointer;
                text-decoration: none; /* Para quitar el subrayado al enlace */
            }

            .tarjeta-historia:hover {
                transform: scale(1.05);
                box-shadow: 0 0 20px rgba(255, 217, 105, 0.8);
            }

            .tarjeta-historia img {
                width: 100%;
                height: 300px;
                object-fit: cover;
            }

            .titulo-historia {
                text-align: center;
                font-size: 18px;
                padding: 15px 10px;
                color: white;
                font-weight: bold;
                background-color: #2c2c2c;
            }

            p {
                color: white;
                text-align: center;
                font-size: 20px;
                margin-top: 50px;
            }
        </style>
        <script src="./javascript/script.js"></script>
    </head>
    <body>

        <?php
        session_start();

        if (!isset($_SESSION["id_usuario"])) {
            header("Location: login.php");
            exit();
        }

        $id_usuario = $_SESSION['id_usuario'];

        $conexion = mysqli_connect("localhost", "root", "", "tintero");

        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        $sql = "SELECT ID_Contenido, Titulo, portada FROM libro WHERE ID_Autor = '$id_usuario'";
        $resultado = mysqli_query($conexion, $sql);
        ?>

        <h1>Mis Historias</h1>

        <div class="contenedor-historias">
            <?php
            if (mysqli_num_rows($resultado) > 0) {
                while ($historia = mysqli_fetch_assoc($resultado)) {
                    
                    echo "<a href='crearCapitulo.php?id=" . urlencode($historia['ID_Contenido']) . "' class='tarjeta-historia'>";
                    echo "<img src='./portadas/" . htmlspecialchars($historia['portada']) . "' alt='Portada'>";
                    echo "<div class='titulo-historia'>" . htmlspecialchars($historia['Titulo']) . "</div>";
                    echo "</a>";
                    $_SESSION['ID_Contenido']=urlencode($historia['ID_Contenido']);
                }
            } else {
                echo "<p>No has creado ninguna historia todavía.</p>";
            }

            mysqli_close($conexion);
            ?>
        </div>

    </body>
</html>
