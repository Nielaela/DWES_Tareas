
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('titulo'); ?></title>
    <link rel="stylesheet" href="../views/plantillas/css/estilo.css">
</head>
<body>

    <header>
        <h1><?php echo $__env->yieldContent('encabezado'); ?></h1>
    </header>

    <main>
        <?php echo $__env->yieldContent('contenido'); ?>
    </main>

</body>
</html>
<?php /**PATH C:\laragon\www\DWES_Tareas\T5\views/plantillas/plantilla1.blade.php ENDPATH**/ ?>