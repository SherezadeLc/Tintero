<?php
    // Inicia la sesión para guardar información entre páginas
    session_start();
?>
<?php
    // Obtener el plan y el modo de pago desde la URL (método GET)
    // Si no se envían, se inicializan como cadena vacía
    $plan = $_GET['plan'] ?? '';
    $modo = $_GET['modo'] ?? '';

    // Definición manual de los planes disponibles
    $planes = [
        'basico' => [
            'nombre' => 'Plan Básico',
            'beneficios' => 'Acceso a la plataforma y funciones básicas de creación y publicación de historias. Herramientas de edición y formateo de texto básicas. Posibilidad de compartir contenido con otros usuarios. Acceso limitado a plantillas y funciones de diseño.',
            'precio_mensual' => 0,
            'precio_anual' => 0,
            'duracion_mensual' => '6',
            'duracion_anual' => '12',
        ],
        'estandar' => [
            'nombre' => 'Plan Estándar',
            'beneficios' => 'Todo lo incluido en el Plan Básico. Acceso a un conjunto más amplio de herramientas de creación y edición. Posibilidad de personalizar plantillas y diseños. Analíticas básicas sobre el rendimiento de las publicaciones.',
            'precio_mensual' => 28.99,
            'precio_anual' => 30.99,
            'duracion_mensual' => '6',
            'duracion_anual' => '12',
        ],
        'premium' => [
            'nombre' => 'Plan Premium',
            'beneficios' => 'Todo lo incluido en el Plan Estándar. Acceso a herramientas avanzadas de creación de contenido visual. Plantillas personalizadas y exclusivas. Funcionalidades adicionales para mejorar la visibilidad y promoción del contenido. Analíticas detalladas sobre el rendimiento y compromiso de las publicaciones. Acceso prioritario a soporte y asistencia.',
            'precio_mensual' => 48.99,
            'precio_anual' => 60.99,
            'duracion_mensual' => '6',
            'duracion_anual' => '12',
        ],
        'mes_prueba' => [
            'nombre' => 'Mes Prueba',
            'beneficios' => 'Todo lo incluido en el Plan Estándar. Acceso a herramientas avanzadas de creación de contenido visual. Plantillas personalizadas y exclusivas. Funcionalidades adicionales para mejorar la visibilidad y promoción del contenido. Analíticas detalladas sobre el rendimiento y compromiso de las publicaciones. Acceso prioritario a soporte y asistencia.',
            'precio_mensual' => 0,
            'precio_anual' => 0,
            'duracion_mensual' => '1',
            'duracion_anual' => '-',// No aplica plan anual para mes de prueba
        ]
    ];

   // Verifica si el plan recibido por GET existe en la lista
    if (!isset($planes[$plan])) {
        echo "Plan no válido.";
        exit;
    }

    // Extrae los datos del plan seleccionado
    $datosPlan = $planes[$plan];
    // Determina el precio y duración según el modo de pago elegido
    $precio = $modo === 'mensual' ? $datosPlan['precio_mensual'] : $datosPlan['precio_anual'];
    $duracion = $modo === 'mensual' ? $datosPlan['duracion_mensual'] : $datosPlan['duracion_anual'];

    // Guarda en la sesión los detalles del plan seleccionado
    $_SESSION['plan_seleccionado'] = [
        'nombre_plan' => $datosPlan['nombre'],
        'beneficios' => $datosPlan['beneficios'],
        'precio' => $precio,
        'modo_pago' => $modo,
        'duracion' => $duracion
    ];
?>
<!DOCTYPE html>
<html>
    <head>

        <meta charset="UTF-8">
        <link rel="shortcut icon" href="./img/icono.jpg" type="image/x-icon" id="ico">
        <link rel="stylesheet" href="./css/Pagar.css">
        <title>Confirmación de Pago</title>
    </head>
    <!-- Contenedor del formulario de datos de la tarjeta -->
    <div class="contenedor-registro">
        <!-- Formulario para introducir los datos de pago -->
        <form name="form_tarjeta" action="pago_exitoso.php" method="POST" enctype="multipart/form-data">

            <h2>Datos de la Tarjeta</h2>
            <hr> 
            <h3>Introduce la información de tu método de pago</h3><br>

            <!-- Campo para el número de tarjeta -->
            Número de Tarjeta:<br><br>
            <input type="text" name="numero_tarjeta" placeholder="Ej: 1234 5678 9012 3456" required><br><br>

             <!-- Campo para el nombre del titular -->
            Nombre del Titular:<br><br>
            <input type="text" name="nombre_titular" placeholder="Nombre completo" required><br><br>

             <!-- Campo para la fecha de expiración -->
            Fecha de Expiración (MM/AA):<br><br>
            <input type="text" name="fecha_expiracion" placeholder="MM/AA" required><br><br>

            <!-- Campo para el CVV -->
            Código de Seguridad (CVV):<br><br>
            <input type="text" name="cvv" placeholder="Ej: 123" required><br><br>



            <hr>

        </form>
    </div>

    <!-- Cuerpo de la página con estilos en línea -->
    <body style="background-color:#2a1f36; color:white; font-family: Arial; padding: 20px;">
         <!-- Sección que muestra el resumen del plan elegido -->
        <h2>Resumen del Plan Seleccionado</h2>
        <p><strong>Nombre del Plan:</strong> <?= $_SESSION['plan_seleccionado']['nombre_plan'] ?></p>
        <p><strong>Modo de Pago:</strong> <?= ucfirst($_SESSION['plan_seleccionado']['modo_pago']) ?></p>
        <p><strong>Duración:</strong> <?= $_SESSION['plan_seleccionado']['duracion'] ?> meses.</p>
        <p><strong>Precio:</strong> <?= $_SESSION['plan_seleccionado']['precio'] ?> €</p>
        <p><strong>Beneficios Incluidos:</strong><br><?= $_SESSION['plan_seleccionado']['beneficios'] ?></p>

         <!-- Botón para confirmar el pago -->
        <form method="post" action="pago_exitoso.php">
            <input type="submit" value="Confirmar Pago" class="btn">
        </form>
    </body>
</html>
