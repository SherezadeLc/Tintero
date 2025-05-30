<?php
    session_start();

    if (!isset($_SESSION['id_usuario'])) 
    {
        header("Location: login.php");
        exit();
    }

    $id_usuario = $_SESSION['id_usuario'];
    $conexion = mysqli_connect("localhost", "root", "", "tintero");

    if (!$conexion) 
    {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Actualizar estado si se envió un formulario
    //tambien recoge la accion de que queremos que haga
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_contenido'], $_POST['accion'])) 
    {
        $id_contenido = intval($_POST['id_contenido']);
        //aqui coge la accion que queremos que haga 
        $accion = $_POST['accion'];
        //aqui comprueba si es que quiere publicar la historia
        if ($accion === 'publicar') 
        { 
            //y aqui entra si es que lo que quiere es publicar la historia
            $estado = 'Publicado';
        } elseif ($accion === 'borrador') 
        {
             //y aqui entra si es que lo que quiere es publicar la historia
            $estado = 'Borrador';
        }
        //aqui lo que hacemos es hacer uj update del estado de como se encuentra el libro es decir si se encuentra publicado o como borrador
        $update = "UPDATE libro SET Estado = '$estado' WHERE ID_Contenido = $id_contenido AND ID_Autor = $id_usuario";
        //aqui hacemos que haga el cambio en la base de datos
        mysqli_query($conexion, $update);
    }

    // Obtener historias del usuario
    $sql = "SELECT ID_Contenido, Titulo, portada, Estado FROM libro WHERE ID_Autor = '$id_usuario'";
    //aqui hacemos que haga la conexion a la base de datos para que coga la informacion de la tabla
    $resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mis Historias | Tintero</title>
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="./css/Registro_Login.css">
        <style>
            body {
                background-color: #2a1f36;
                color: white;
                font-family: Arial, sans-serif;
            }
            h1 {
                text-align: center;
                margin-top: 50px;
                font-size: 40px;
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
                text-align: center;
                padding-bottom: 10px;
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
                font-size: 18px;
                padding: 10px;
                color: white;
                font-weight: bold;
            }
            form {
                margin-top: 10px;
            }
            .btn {
                padding: 6px 12px;
                margin: 4px;
                border: none;
                border-radius: 5px;
                font-weight: bold;
                cursor: pointer;
            }
            .btn-publicar {
                background-color: #28a745;
                color: white;
            }
            .btn-publicar:hover {
                background-color: #218838;
            }
            .btn-borrador {
                background-color: #ffc107;
                color: black;
            }
            .btn-borrador:hover {
                background-color: #e0a800;
            }
            .estado {
                font-size: 14px;
                color: #ccc;
            }
            .btn-volver {
                display: block;
                margin: 40px auto;
                padding: 10px 20px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 6px;
                font-weight: bold;
                cursor: pointer;
                text-decoration: none;
                text-align: center;
            }
            .btn-volver:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>

        <h1>Mis Historias</h1>

        <div class="contenedor-historias">
            <?php if (mysqli_num_rows($resultado) > 0): ?>
                <?php while ($historia = mysqli_fetch_assoc($resultado)): ?>
                    <div class="tarjeta-historia">
                        <a href="crearCapitulo.php?id=<?= urlencode($historia['ID_Contenido']) ?>">
                            <img src="./img_portada/<?= htmlspecialchars($historia['portada']) ?>" alt="Portada">
                        </a>
                        <div class="titulo-historia"><?= htmlspecialchars($historia['Titulo']) ?></div>
                        <div class="estado">(Estado: <?= htmlspecialchars($historia['Estado']) ?>)</div>
                        <form method="POST" action="">
                            <input type="hidden" name="id_contenido" value="<?= $historia['ID_Contenido'] ?>">
                            <button type="submit" name="accion" value="publicar" class="btn btn-publicar">Publicar</button>
                            <button type="submit" name="accion" value="borrador" class="btn btn-borrador">Borrador</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align:center;">No has creado ninguna historia todavía.</p>
            <?php endif; ?>
        </div>

        <!-- Botón Volver al Menú -->
        <a href="menuSuscrito.php" class="btn-volver">Volver al Menú</a>

    </body>
</html>

<?php mysqli_close($conexion); ?>
