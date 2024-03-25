<?php $__env->startSection('titulo'); ?>
    <?php echo e($titulo); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('encabezado'); ?>
    <?php echo e($encabezado); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
    <a href="productos.php" class="btn btn-info mr-4">Acceder a Productos</a>
    <a href="familias.php" class="mr-4 btn btn-info">Acceder a Familias</a>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantillas.plantilla1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\DWES_Tareas\EJEMPLOT_5FINAL\views/vistaPortada.blade.php ENDPATH**/ ?>