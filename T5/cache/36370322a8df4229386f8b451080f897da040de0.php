<?php $__env->startSection('titulo', 'Inversiones'); ?>
<?php $__env->startSection('encabezado', 'Listado de Inversiones'); ?>

<?php $__env->startSection('contenido'); ?>
<a href="fcrear.php" class="btn btn-fcrear">Nuevo Fondo</a>
<?php if(count($inversiones) > 0): ?>
    <table class="table table-striped">
        <thead>
            <tr class="text-center">
                <th scope="col">Nombre del Fondo</th>
                <th scope="col">Categoría</th>
                <th scope="col">Valor de la Inversión</th>
                <th scope="col">Fecha de Inversión</th>
                <th scope="col">Rentabilidad Esperada</th>
                <th scope="col">Tasa de Retorno Anual</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $inversiones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inversion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="text-center">
                    <td><?php echo e($inversion->nombre_fondo); ?></td>
                    <td><?php echo e($inversion->categoria); ?></td>
                    <td><?php echo e($inversion->valor_inversion); ?></td>
                    <td><?php echo e($inversion->fecha_inversion); ?></td>
                    <td><?php echo e($inversion->rentabilidad_esperada); ?></td>
                    <td><?php echo e($inversion->tasa_retorno_anual); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-center">No hay inversiones disponibles.</p>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantillas.plantilla1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\DWES_Tareas\T5\views/vinversiones.blade.php ENDPATH**/ ?>