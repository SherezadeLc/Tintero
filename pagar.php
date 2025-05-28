<?php
session_start();
?>
<?php
// Obtener plan y modo de pago desde GET
$plan = $_GET['plan'] ?? '';
$modo = $_GET['modo'] ?? '';

// Definir los planes manualmente
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
        'duracion_anual' => '-',
    ]
];

// Validar el plan
if (!isset($planes[$plan])) {
    echo "Plan no válido.";
    exit;
}

// Obtener datos del plan
$datosPlan = $planes[$plan];
$precio = $modo === 'mensual' ? $datosPlan['precio_mensual'] : $datosPlan['precio_anual'];
$duracion = $modo === 'mensual' ? $datosPlan['duracion_mensual'] : $datosPlan['duracion_anual'];

// Guardar en sesión
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
        <title>Confirmación de Pago</title>
    </head>
    <body style="background-color:#2a1f36; color:white; font-family: Arial; padding: 20px;">
        <h2>Resumen del Plan Seleccionado</h2>
        <p><strong>Nombre del Plan:</strong> <?= $_SESSION['plan_seleccionado']['nombre_plan'] ?></p>
        <p><strong>Modo de Pago:</strong> <?= ucfirst($_SESSION['plan_seleccionado']['modo_pago']) ?></p>
        <p><strong>Duración:</strong> <?= $_SESSION['plan_seleccionado']['duracion'] ?> meses.</p>
        <p><strong>Precio:</strong> <?= $_SESSION['plan_seleccionado']['precio'] ?> €</p>
        <p><strong>Beneficios Incluidos:</strong><br><?= $_SESSION['plan_seleccionado']['beneficios'] ?></p>

        <form method="post" action="pago_exitoso.php">
            <input type="submit" value="Confirmar Pago" class="btn">
        </form>
    </body>
</html>
