<?php  
    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "tintero");
    if (!$conexion) 
    {
        die("Error de conexión: " . mysqli_connect_error());
    }
    // Si se recibe una petición POST y contiene la clave 'accion'
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) 
    {
        // Acción para cargar las categorías desde la base de datos
        if ($_POST['accion'] === 'cargar_categorias') 
        {
            $resultado = mysqli_query($conexion, "SELECT * FROM categoria");
            // Genera checkboxes por cada categoría encontrada
            while ($fila = mysqli_fetch_assoc($resultado)) 
            {
                echo '<label><input type="checkbox" name="categorias[]" value="' . $fila['ID_Categoria'] . '"> ' . htmlspecialchars($fila['Nombre']) . '</label>';
            }
            // Detiene ejecución para no continuar con el resto del código
            exit;
        }

        // Acción para buscar libros según las categorías seleccionadas
        if ($_POST['accion'] === 'buscar_libros' && isset($_POST['categorias'])) 
        {
            // Convierte cada ID recibido a entero para evitar inyecciones
            $categorias = array_map('intval', $_POST['categorias']);
            // Se convierte a una cadena separada por comas
            $ids = implode(',', $categorias);

            // Consulta libros cuyo id_categoria coincida y que estén publicados
            $sql = "SELECT ID_Contenido, Titulo, portada FROM libro WHERE id_categoria IN ($ids) AND Estado = 'Publicado'";
            $resultado = mysqli_query($conexion, $sql);

            if (mysqli_num_rows($resultado) > 0) 
            {
                echo '<div class="grid-libros">';
                while ($libro = mysqli_fetch_assoc($resultado)) 
                {
                     // Se imprime una tarjeta por cada libro con portada y título
                    echo "<a href='opciones_lectura.php?id=" . urlencode($libro['ID_Contenido']) . "' style='text-decoration: none; color: inherit;'>";
                    echo "  <div class='flip-card'>";
                    echo "    <div class='flip-card-inner'>";
                    echo "      <div class='flip-card-front'>";
                    echo "        <img src='./img_portada/" . htmlspecialchars($libro['portada']) . "' alt='Portada de " . htmlspecialchars($libro['Titulo']) . "'>";
                    echo "      </div>";
                    echo "      <div class='flip-card-back'>";
                    echo "        <div class='titulo-historia'>" . htmlspecialchars($libro['Titulo']) . "</div>";
                    echo "      </div>";
                    echo "    </div>";
                    echo "  </div>";
                    echo "</a>";
                }
                echo '</div>';
            } else 
            {
                echo "<p>No se encontraron libros.</p>";
            }
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tintero</title>
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <link rel="stylesheet" type="text/css" href="./css/Categoria.css">
        <style>
            /* Estilo de la cuadrícula de libros */
            .grid-libros 
            {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
                gap: 20px;
                padding: 40px;
            }

            /* Tarjeta 3D para portada del libro */
            .flip-card 
            {
                background-color: transparent;
                width: 100%;
                perspective: 1000px;
            }

            .flip-card-inner 
            {
                position: relative;
                width: 100%;
                height: 280px;
                text-align: center;
                transition: transform 0.6s;
                transform-style: preserve-3d;
            }

            .flip-card:hover .flip-card-inner 
            {
                transform: rotateY(180deg);
            }

            .flip-card-front, .flip-card-back 
            {
                position: absolute;
                width: 100%;
                height: 100%;
                backface-visibility: hidden;
                border-radius: 15px;
                overflow: hidden;
            }

            .flip-card-front img 
            {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 15px;
            }

            .flip-card-back 
            {
                background-color: #110011;
                color: white;
                transform: rotateY(180deg);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 10px;
                text-align: center;
                font-weight: bold;
                text-shadow: 0 0 8px rgb(255, 217, 105);
            }
        </style>
    </head>
    <body>

        <!-- Ventana emergente de selección de categorías -->
        <div id="modal" class="modal">
            <div class="modal-content">
                <button class="boton-cerrar" onclick="cerrarModal()">✕</button>
                <h3>Elige categorías</h3>

                <form id="formCategorias">
                    <div id="contenedorCategorias" class="grid-categorias">Cargando...</div>
                    <br>
                    <button type="submit">Aceptar</button>
                </form>
            </div>
        </div>

        <!-- Aquí se mostrarán los resultados de los libros filtrados -->
        <div id="resultado"></div>

        <script>
            // Carga las categorías cuando se cargue la página
            window.addEventListener('load', () => {
                cargarCategorias();
            });

            // Función que carga las categorías dinámicamente con fetch
            function cargarCategorias() 
            {
                const formData = new FormData();
                formData.append('accion', 'cargar_categorias');

                fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(html => {
                    document.getElementById('contenedorCategorias').innerHTML = html;
                });
            }

            // Cierra el modal de selección de categorías
            function cerrarModal() 
            {
                document.getElementById('modal').style.display = 'none';
            }

            // Manejo del envío del formulario de selección de categorías
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.getElementById('formCategorias');

                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    // Obtener las categorías seleccionadas
                    const seleccionadas = Array.from(
                        document.querySelectorAll('input[name="categorias[]"]:checked')
                    ).map(cb => cb.value);

                    if (seleccionadas.length === 0) {
                        alert("Selecciona al menos una categoría.");
                        return;
                    }

                    // Enviar la búsqueda por categorías al servidor
                    const formData = new FormData();
                    formData.append('accion', 'buscar_libros');
                    seleccionadas.forEach(cat => formData.append('categorias[]', cat));

                    fetch('', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('resultado').innerHTML = html;
                        // Oculta el modal después de mostrar los resultados
                        cerrarModal();
                    });
                });
            });
        </script>
    </body>
</html>
